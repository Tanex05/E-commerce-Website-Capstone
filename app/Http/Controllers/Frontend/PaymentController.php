<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;
use GuzzleHttp\Client;
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
        return view('frontend.pages.payment-success');
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

    public function payWithPayMongo(Request $request)
    {
        // Calculate payable amount
        $total = getFinalPayableAmount();

        try {
            // Create PayMongo Checkout Session
            $sessionId = $this->createCheckoutSession($total);

            // Redirect to PayMongo checkout page
            return redirect()->away("https://checkout.paymongo.com/{$sessionId}");
        } catch (\Exception $e) {
            // Handle error (e.g., log error, display error message)
            return redirect()->route('user.checkout')->with('error', 'Failed to initiate payment. Please try again later.');
        }
    }

    private function createCheckoutSession($amount)
    {
        $client = new Client();

        try {
            $response = $client->post('https://api.paymongo.com/v1/checkout_sessions', [
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $amount, // Convert amount to cents
                            'currency' => 'PHP',
                            'payment_methods' => [
                                'gcash',
                                'bank_transfer', // Add more payment methods as needed
                            ],
                            'livemode' => false, // Set to false for test mode
                            'send_email_receipt' => false, // Don't send email receipt
                            'show_description' => true, // Show description
                            'show_line_items' => true, // Show line items
                        ],
                    ],
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . env('PAYMONGO_SECRET_KEY'),
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the status code is 200 (success) or 201 (created)
            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
                // Trigger storeOrder and clear session
                $this->storeOrder('Paymongo', 1, $data['data']['id'], $amount);
                $this->clearSession();
            } else {
                // Handle error (e.g., log error, throw exception)
                throw new \Exception('Failed to create checkout session: ' . $response->getStatusCode());
            }

            return $data['data']['id']; // Return the Checkout Session ID
        } catch (\Exception $e) {
            // Handle errors (e.g., log error, throw exception)
            throw $e;
        }
    }




}
