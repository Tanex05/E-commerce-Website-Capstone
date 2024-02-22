<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /** Show cart page  */
    public function cartDetails()
    {
        $cartItems = Cart::content();

        if(count($cartItems) === 0){
            Session::forget('coupon');
            toastr('Please add some products in your cart for view the cart page', 'warning', 'Cart is empty!');
            return redirect()->route('home');
        }

        // Check if the cart contains a 'flashout_product'
        $disabled = false;
        foreach ($cartItems as $item) {
            $product = $item->model;
            if ($product->product_type === 'flashout_product') {
                $disabled = true;
                break;
            }
        }
        $cartpage_banner_section = Advertisement::where('key', 'cartpage_banner_section')->first();
        $cartpage_banner_section = json_decode($cartpage_banner_section?->value);


        return view('frontend.pages.cart-details', compact('cartItems','disabled','cartpage_banner_section'));

    }

    public function addToCart(Request $request)
    {

        $product = Product::findOrFail($request->product_id);

        // check product quantity
        if ($product->qty === 0) {
            return response(['status' => 'error', 'message' => 'Product stock out']);
        } elseif ($product->qty < $request->qty) {
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }

        // Check if adding the product exceeds the quantity in cart
        $cartContent = Cart::content();
        foreach ($cartContent as $cartItem) {
            if ($cartItem->id == $product->id && $cartItem->qty + $request->qty > $product->qty) {
                return response(['status' => 'error', 'message' => 'Quantity exceeds maximum limit']);
            }
        }

        $variants = [];
        $variantTotalAmount = 0;

        if ($request->has('variants_items')) {
            foreach ($request->variants_items as $item_id) {
                $variantItem = ProductVariantItem::find($item_id);
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $variantTotalAmount += $variantItem->price;
            }
        }

        /** check discount */
        $productPrice = 0;

        if (checkDiscount($product)) {
            $productPrice = $product->offer_price;
        } else {
            $productPrice = $product->price;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumbnail_image;
        $cartData['options']['slug'] = $product->slug;

        Cart::add($cartData)->associate("\App\Models\Product");

        // Calculate total cart amount
        $totalCartAmount = $this->cartTotal();

        // Return the updated total cart amount in the response
        return response(['status' => 'success', 'message' => 'Added to cart successfully!', 'cart_total' => $totalCartAmount]);
    }


    /** Update product quantity Decrement  */
    public function updateProductQtyDecrement(Request $request)
    {
        $productId = Cart::get($request->rowId)->id;
        $product = Product::findOrFail($productId);

        // check product quantity
        if($product->qty === 0){
            return response(['status' => 'error', 'message' => 'Product stock out']);
        }elseif($product->qty < $request->qty){
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }

        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->getProductTotal($request->rowId);


        return response(['status' => 'success', 'message' => 'Product Quantity Updated!', 'product_total' => $productTotal]);
    }

    /** Update product quantity Increment */
    public function updateProductQtyIncrement(Request $request)
    {
        $row = Cart::get($request->rowId);
        $productId = $row->id;
        $product = Product::findOrFail($productId);

        // Get the maximum quantity of the product
        $maxQuantity = $product->qty;

        // Check if the requested quantity exceeds the maximum quantity
        if ($request->quantity > $maxQuantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reached maximum quantity of product or not enough stock available'
            ]);
        } else {
            // Update the quantity in the cart if validation passes
            Cart::update($request->rowId, $request->quantity);
            $productTotal = $this->getProductTotal($request->rowId);

            return response()->json([
                'status' => 'success',
                'message' => 'Product quantity updated!',
                'product_total' => $productTotal
            ]);
        }
    }




    /** get product total */
    public function getProductTotal($rowId)
    {
       $product = Cart::get($rowId);
       $total = ($product->price + $product->options->variants_total) * $product->qty;
       return $total;
    }

    /** get cart total amount */
    public function cartTotal()
    {
        $total = 0;
        foreach(Cart::content() as $product){
            $total += $this->getProductTotal($product->rowId);
        }

        return $total;
    }

    /** clear all cart products */
    public function clearCart()
    {
        Cart::destroy();

        return response(['status' => 'success', 'message' => 'Cart cleared successfully']);
    }

    /** Remove product form cart */
    public function removeProduct($rowId)
    {
        Cart::remove($rowId);
        toastr('Product removed succesfully!', 'success', 'Success');
        return redirect()->back();
    }

    /** Get cart count */
    public function getCartCount()
    {
        return Cart::content()->count();
    }

    /** Get all cart products */
    public function getCartProducts()
    {
        return Cart::content();
    }

    /** Romve product form sidebar cart */
    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);

        return response(['status' => 'success', 'message' => 'Product removed successfully!']);
    }

    /** Apply coupon */
    public function applyCoupon(Request $request)
    {
        if($request->coupon_code === null){
            return response(['status' => 'error', 'message' => 'Coupon filed is required']);
        }

        $coupon = Coupon::where(['code' => $request->coupon_code, 'status' => 1])->first();

        if($coupon === null){
            return response(['status' => 'error', 'message' => 'Coupon not exist!']);
        }elseif($coupon->start_date > date('Y-m-d')){
            return response(['status' => 'error', 'message' => 'Coupon not exist!']);
        }elseif($coupon->end_date < date('Y-m-d')){
            return response(['status' => 'error', 'message' => 'Coupon is expired']);
        }elseif($coupon->total_used >= $coupon->quantity){
            return response(['status' => 'error', 'message' => 'you can not apply this coupon']);
        }

        if($coupon->discount_type === 'amount'){
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'discount' => $coupon->discount
            ]);
        }elseif($coupon->discount_type === 'percent'){
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'percent',
                'discount' => $coupon->discount
            ]);
        }

        return response(['status' => 'success', 'message' => 'Coupon applied successfully!']);
    }

    /** Calculate coupon discount */
    public function couponCalculation()
{
    if(Session::has('coupon')){
        $coupon = Session::get('coupon');
        $subTotal = getCartTotal();
        if($coupon['discount_type'] === 'amount'){
            $discount = min($coupon['discount'], $subTotal); // Ensure discount doesn't exceed subtotal
            $total = $subTotal - $discount;
            return response(['status' => 'success', 'cart_total' => $total, 'discount' => $discount]);
        } elseif($coupon['discount_type'] === 'percent'){
            $discount = round($subTotal * ($coupon['discount'] / 100), 2); // Calculate discount
            $discount = min($discount, $subTotal); // Ensure discount doesn't exceed subtotal
            $total = $subTotal - $discount;
            return response(['status' => 'success', 'cart_total' => $total, 'discount' => $discount]);
        }
    } else {
        $total = getCartTotal();
        return response(['status' => 'success', 'cart_total' => $total, 'discount' => 0]);
    }
}

}
