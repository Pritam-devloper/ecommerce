<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product.seller')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart')->withErrors(['cart' => 'Your cart is empty.']);

        $addresses = Address::where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->final_price);
        $coupon = session('coupon');
        $discount = $coupon['discount'] ?? 0;
        $shipping = $subtotal > 500 ? 0 : 50;
        $total = $subtotal - $discount + $shipping;

        return view('checkout', compact('cartItems', 'addresses', 'subtotal', 'discount', 'shipping', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cartItems = Cart::with('product.seller')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart');

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->final_price);
        $coupon = session('coupon');
        $discount = $coupon['discount'] ?? 0;
        $shipping = $subtotal > 500 ? 0 : 50;
        $total = $subtotal - $discount + $shipping;

        DB::transaction(function () use ($cartItems, $request, $subtotal, $discount, $shipping, $total, $coupon) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'address_id' => $request->address_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'coupon_code' => $coupon['code'] ?? null,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'seller_id' => $item->product->seller_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->final_price,
                    'quantity' => $item->quantity,
                    'total' => $item->quantity * $item->product->final_price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            if ($coupon) {
                Coupon::where('code', $coupon['code'])->increment('used');
                session()->forget('coupon');
            }

            Cart::where('user_id', auth()->id())->delete();

            session(['last_order' => $order->id]);
        });

        return redirect()->route('order.success');
    }

    public function success()
    {
        $order = Order::with('items.product')->find(session('last_order'));
        if (!$order) return redirect()->route('home');
        return view('order-success', compact('order'));
    }
}
