<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    private function seller()
    {
        return auth()->user()->seller;
    }

    public function pending()
    {
        if ($this->seller() && $this->seller()->isApproved()) {
            return redirect()->route('seller.dashboard');
        }
        return view('seller.pending');
    }

    public function dashboard()
    {
        $seller = $this->seller();
        $totalProducts = $seller->products()->count();
        $totalOrders = OrderItem::where('seller_id', $seller->id)->distinct('order_id')->count('order_id');
        $pendingOrders = OrderItem::where('seller_id', $seller->id)
            ->whereHas('order', fn($q) => $q->where('status', 'pending'))->distinct('order_id')->count('order_id');
        $totalRevenue = OrderItem::where('seller_id', $seller->id)
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))->sum('total');
        $recentOrders = OrderItem::where('seller_id', $seller->id)->with('order.user', 'product')->latest()->take(5)->get();

        return view('seller.dashboard', compact('seller', 'totalProducts', 'totalOrders', 'pendingOrders', 'totalRevenue', 'recentOrders'));
    }

    // Products
    public function products()
    {
        $products = $this->seller()->products()->with('category')->latest()->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::where('is_active', true)->get();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('thumbnail', 'images');
        $data['seller_id'] = $this->seller()->id;
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('seller.products')->with('success', 'Product created! Awaiting admin approval.');
    }

    public function editProduct(Product $product)
    {
        abort_if($product->seller_id !== $this->seller()->id, 403);
        $categories = Category::where('is_active', true)->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        abort_if($product->seller_id !== $this->seller()->id, 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->except('thumbnail');
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('seller.products')->with('success', 'Product updated.');
    }

    public function deleteProduct(Product $product)
    {
        abort_if($product->seller_id !== $this->seller()->id, 403);
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    // Orders
    public function orders(Request $request)
    {
        $status = $request->get('status');
        $query = Order::whereHas('items', fn($q) => $q->where('seller_id', $this->seller()->id))
            ->with('user', 'items.product');

        if ($status) $query->where('status', $status);

        $orders = $query->latest()->paginate(10);
        return view('seller.orders.index', compact('orders', 'status'));
    }

    public function orderDetail(Order $order)
    {
        $items = $order->items()->where('seller_id', $this->seller()->id)->with('product')->get();
        return view('seller.orders.detail', compact('order', 'items'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:confirmed,processing,shipped,delivered,cancelled']);

        $data = ['status' => $request->status];
        if ($request->status === 'shipped') $data['shipped_at'] = now();
        if ($request->status === 'delivered') {
            $data['delivered_at'] = now();
            $data['payment_status'] = 'paid';
        }

        $order->update($data);
        return back()->with('success', 'Order status updated.');
    }

    // Coupons
    public function coupons()
    {
        $coupons = Coupon::where('seller_id', $this->seller()->id)->latest()->paginate(10);
        return view('seller.coupons.index', compact('coupons'));
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            'min_order' => 'nullable|numeric|min:0',
            'max_uses' => 'required|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Coupon::create(array_merge($request->all(), ['seller_id' => $this->seller()->id]));
        return back()->with('success', 'Coupon created!');
    }

    public function deleteCoupon(Coupon $coupon)
    {
        abort_if($coupon->seller_id !== $this->seller()->id, 403);
        $coupon->delete();
        return back()->with('success', 'Coupon deleted.');
    }

    // Wallet / Earnings
    public function wallet()
    {
        $seller = $this->seller();
        $totalEarnings = OrderItem::where('seller_id', $seller->id)
            ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))->sum('total');
        $commission = $totalEarnings * ($seller->commission_rate / 100);
        $netEarnings = $totalEarnings - $commission;
        $withdrawals = WithdrawRequest::where('seller_id', $seller->id)->latest()->get();

        return view('seller.wallet', compact('seller', 'totalEarnings', 'commission', 'netEarnings', 'withdrawals'));
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:100|max:' . $this->seller()->balance]);
        WithdrawRequest::create(['seller_id' => $this->seller()->id, 'amount' => $request->amount]);
        return back()->with('success', 'Withdrawal request submitted.');
    }

    // Profile
    public function profile()
    {
        return view('seller.profile', ['seller' => $this->seller()]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $data = $request->only('shop_name', 'description', 'phone', 'address');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sellers', 'public');
        }

        $this->seller()->update($data);
        auth()->user()->update(['name' => $request->name ?? auth()->user()->name]);

        return back()->with('success', 'Profile updated.');
    }
}
