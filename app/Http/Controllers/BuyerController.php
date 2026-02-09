<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function profile()
    {
        return view('buyer.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        auth()->user()->update($request->only('name', 'phone'));
        return back()->with('success', 'Profile updated.');
    }

    public function orders()
    {
        $orders = Order::with('items.product')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('buyer.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product', 'address');
        return view('buyer.order-detail', compact('order'));
    }

    public function trackOrder(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        return view('buyer.track-order', compact('order'));
    }

    public function wishlist()
    {
        $items = Wishlist::with('product.seller')->where('user_id', auth()->id())->latest()->paginate(12);
        return view('buyer.wishlist', compact('items'));
    }

    public function toggleWishlist(Product $product)
    {
        $existing = Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first();
        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Removed from wishlist.');
        }
        Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
        return back()->with('success', 'Added to wishlist!');
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return view('buyer.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
        ]);

        if ($request->boolean('is_default')) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        Address::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return back()->with('success', 'Address added.');
    }

    public function deleteAddress(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->delete();
        return back()->with('success', 'Address deleted.');
    }

    public function storeReview(Request $request, Product $product)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5', 'comment' => 'nullable|string|max:500']);

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );
        return back()->with('success', 'Review submitted!');
    }
}
