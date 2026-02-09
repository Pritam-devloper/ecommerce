@extends('layouts.dashboard')
@section('title', 'Manage Products')
@section('page-title', 'Products')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.products') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">All</a>
    @foreach(['pending','approved','rejected'] as $s)
    <a href="{{ route('admin.products', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === $s ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">{{ ucfirst($s) }}</a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Product</th><th class="p-4">Seller</th><th class="p-4">Category</th><th class="p-4">Price</th><th class="p-4">Stock</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden shrink-0">
                        @if($product->thumbnail)<img src="{{ asset('storage/'.$product->thumbnail) }}" class="w-full h-full object-cover">@endif
                    </div>
                    <span class="font-medium">{{ Str::limit($product->name, 25) }}</span>
                </div>
            </td>
            <td class="p-4 text-gray-500">{{ $product->seller->shop_name ?? '-' }}</td>
            <td class="p-4">{{ $product->category->name ?? '-' }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($product->price, 0) }}</td>
            <td class="p-4">{{ $product->stock }}</td>
            <td class="p-4">
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $product->status === 'approved' ? 'bg-green-100 text-green-700' : ($product->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ ucfirst($product->status) }}</span>
            </td>
            <td class="p-4">
                <div class="flex gap-2">
                    @if($product->status !== 'approved')
                    <form method="POST" action="{{ route('admin.products.approve', $product) }}">@csrf @method('PATCH')<button class="text-green-600 hover:underline text-sm">Approve</button></form>
                    @endif
                    @if($product->status !== 'rejected')
                    <form method="POST" action="{{ route('admin.products.reject', $product) }}">@csrf @method('PATCH')<button class="text-yellow-600 hover:underline text-sm">Reject</button></form>
                    @endif
                    <form method="POST" action="{{ route('admin.products.delete', $product) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-sm">Delete</button></form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="p-8 text-center text-gray-500">No products found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
