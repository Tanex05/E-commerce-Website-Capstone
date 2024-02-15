<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Transaction;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function index()
    {
        if(!Session::has('address')){
            return redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    public function paymentSuccess()
    {
        $sessionID = \Session::get('session_id');
        dd($sessionID);
        // return view('frontend.pages.payment-success');
    }

    public function storeOrder($paymentMethod, $paymentStatus, $transactionId)
    {

        $order = new Order();
        $order->invoice_id  = rand(1, 999999);
        $order->user_id = Auth::user()->id;
        $order->sub_total = getCartTotal();
        $order->amount =  getFinalPayableAmount();
        $order->product_qty = \Cart::content()->count();
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->order_address = json_encode(Session::get('address'));
        $order->shipping_method = json_encode(Session::get('shipping_method'));
        $order->coupon = json_encode(Session::get('coupon'));
        $order->order_status = 'pending';
        $order->save();

        // store order products
        foreach(\Cart::content() as $item){
            $product = Product::find($item->id);
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->product_name = $product->name;
            $orderProduct->variants = json_encode($item->options->variants);
            $orderProduct->variant_total = $item->options->variants_total;
            $orderProduct->unit_price = $item->price;
            $orderProduct->qty = $item->qty;
            $orderProduct->save();

            // update product quantity
            $updatedQty = ($product->qty - $item->qty);
            $product->qty = $updatedQty;
            $product->save();
        }

        // not yet tested hehe

        // Increment usage Total_used for the coupon if a coupon is applied
        $coupon = Session::get('coupon');
        if (!empty($coupon)) {
            $couponModel = Coupon::where('code', $coupon)->first();
            if ($couponModel) {
                $couponModel->total_used += 1;
                $couponModel->save();
            }
        }

        // store transaction details
        $transaction = new Transaction();
        $transaction->order_id = $order->id;
        $transaction->transaction_id = $transactionId;
        $transaction->payment_method = $paymentMethod;
        $transaction->amount = getFinalPayableAmount();
        $transaction->save();

    }

    public function clearSession()
    {
        \Cart::destroy();
        Session::forget('address');
        Session::forget('shipping_method');
        Session::forget('coupon');
    }

    public function payWithPaymongo()
    {
        $data = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => getFinalPayableAmount() * 100, // Adjust to the final payable amount
                            'name' => 'Technoblast Product Total',
                            'quantity' => 1,
                        ],
                    ],
                    'payment_method_types' => ['card', 'gcash', 'billease', 'paymaya'], // Correct key name
                    'success_url' => route('user.payment.success'),
                    'cancel_url' => route('user.payment.success'),
                    'description' => Auth::user()->name
                ]
            ]
        ];
        $api_key = base64_encode(env('PAYMONGO_SECRET_KEY')); // Encode the API key
        $headers = [
            'Content-Type: application/json',
            'accept: application/json',
            'Authorization: Basic ' . $api_key, // Use the encoded API key in the Authorization header
        ];


        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                ->withHeaders($headers)
                ->withData($data)
                ->asJson()
                ->post();

        \Session::put('session_id', $response->data->id);

        return redirect()->to($response->data->attributes->checkout_url);
    }



}
