<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product.seller')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->final_price);
        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'integer|min:1|max:10']);
        $qty = $request->input('quantity', 1);

        $cart = Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first();
        if ($cart) {
            $cart->update(['quantity' => min($cart->quantity + $qty, $product->stock)]);
        } else {
            Cart::create(['user_id' => auth()->id(), 'product_id' => $product->id, 'quantity' => min($qty, $product->stock)]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:' . $cart->product->stock]);
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->withErrors(['code' => 'Invalid or expired coupon code.']);
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->final_price);
        $discount = $coupon->calculateDiscount($subtotal);

        session(['coupon' => ['code' => $coupon->code, 'discount' => $discount]]);
        return back()->with('success', "Coupon applied! You save ₹{$discount}");
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
