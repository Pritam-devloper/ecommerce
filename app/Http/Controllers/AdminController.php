<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\Coupon;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'buyer')->count();
        $totalSellers = Seller::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingSellers = Seller::where('status', 'pending')->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $topProducts = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders', 'totalRevenue',
            'pendingOrders', 'pendingSellers', 'recentOrders', 'topProducts'
        ));
    }

    // User Management
    public function users(Request $request)
    {
        $query = User::where('role', 'buyer');
        if ($request->search) $query->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%");
        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', ($user->is_active ? 'Unblocked' : 'Blocked') . ' user.');
    }

    // Seller Management
    public function sellers(Request $request)
    {
        $query = Seller::with('user');
        if ($request->status) $query->where('status', $request->status);
        $sellers = $query->latest()->paginate(15);
        return view('admin.sellers.index', compact('sellers'));
    }

    public function approveSeller(Seller $seller)
    {
        $seller->update(['status' => 'approved']);
        return back()->with('success', 'Seller approved.');
    }

    public function suspendSeller(Seller $seller)
    {
        $seller->update(['status' => 'suspended']);
        return back()->with('success', 'Seller suspended.');
    }

    // Product Management
    public function products(Request $request)
    {
        $query = Product::with('seller.user', 'category');
        if ($request->status) $query->where('status', $request->status);
        $products = $query->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'thumbnail' => 'required|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['thumbnail', 'images']);
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['status'] = 'approved'; // Auto-approve admin products
        $data['is_active'] = true;
        
        // For single seller, use first seller or create one
        $seller = Seller::first();
        if (!$seller) {
            // Create a default seller for admin
            $seller = Seller::create([
                'user_id' => auth()->id(),
                'shop_name' => 'Shiivaraa Store',
                'slug' => 'shiivaraa-store',
                'status' => 'approved',
            ]);
        }
        $data['seller_id'] = $seller->id;

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create($data);

        // Handle additional images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
            $product->update(['images' => json_encode($images)]);
        }

        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    public function approveProduct(Product $product)
    {
        $product->update(['status' => 'approved']);
        return back()->with('success', 'Product approved.');
    }

    public function rejectProduct(Product $product)
    {
        $product->update(['status' => 'rejected']);
        return back()->with('success', 'Product rejected.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product removed.');
    }

    // Order Management
    public function orders(Request $request)
    {
        $query = Order::with('user', 'items');
        if ($request->status) $query->where('status', $request->status);
        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $order->load('user', 'items.product.seller', 'address');
        return view('admin.orders.detail', compact('order'));
    }

    public function refundOrder(Order $order)
    {
        $order->update(['status' => 'refunded', 'payment_status' => 'refunded']);
        return back()->with('success', 'Order refunded.');
    }

    // Category Management
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->only('name', 'description', 'parent_id', 'sort_order');
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        Category::create($data);
        return back()->with('success', 'Category created.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->only('name', 'description', 'parent_id', 'is_active', 'sort_order');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // Banner Management
    public function banners()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function storeBanner(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);
        $data = $request->only('title', 'link', 'sort_order');
        $data['image'] = $request->file('image')->store('banners', 'public');
        Banner::create($data);
        return back()->with('success', 'Banner added.');
    }

    public function deleteBanner(Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Banner deleted.');
    }

    // Payment / Commission
    public function payments()
    {
        $sellers = Seller::with('user')->get();
        $withdrawRequests = WithdrawRequest::with('seller.user')->latest()->paginate(15);
        return view('admin.payments.index', compact('sellers', 'withdrawRequests'));
    }

    public function updateCommission(Request $request, Seller $seller)
    {
        $request->validate(['commission_rate' => 'required|numeric|min:0|max:50']);
        $seller->update(['commission_rate' => $request->commission_rate]);
        return back()->with('success', 'Commission updated.');
    }

    public function approveWithdraw(WithdrawRequest $withdrawRequest)
    {
        $withdrawRequest->update(['status' => 'approved']);
        $withdrawRequest->seller->decrement('balance', $withdrawRequest->amount);
        return back()->with('success', 'Withdrawal approved.');
    }

    public function rejectWithdraw(WithdrawRequest $withdrawRequest)
    {
        $withdrawRequest->update(['status' => 'rejected']);
        return back()->with('success', 'Withdrawal rejected.');
    }

    // Settings
    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Settings updated.');
    }

    // Reports
    public function reports()
    {
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->selectRaw('strftime("%Y-%m", created_at) as month, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('month')->orderByDesc('month')->take(12)->get();
        $topSellers = Seller::withCount('orderItems')->orderByDesc('order_items_count')->take(10)->get();
        $topCategories = Category::withCount('products')->orderByDesc('products_count')->take(10)->get();

        return view('admin.reports', compact('monthlyRevenue', 'topSellers', 'topCategories'));
    }
}
