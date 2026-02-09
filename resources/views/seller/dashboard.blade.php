@extends('layouts.dashboard')
@section('title', 'Seller Dashboard')
@section('page-title', 'Dashboard')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div><p class="text-sm text-gray-500">Total Products</p><p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p></div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-box text-blue-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div><p class="text-sm text-gray-500">Total Orders</p><p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p></div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-shopping-bag text-green-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div><p class="text-sm text-gray-500">Pending Orders</p><p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p></div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center"><i class="fas fa-clock text-yellow-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div><p class="text-sm text-gray-500">Revenue</p><p class="text-2xl font-bold text-flipblue">₹{{ number_format($totalRevenue, 0) }}</p></div>
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center"><i class="fas fa-rupee-sign text-flipblue text-xl"></i></div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <a href="{{ route('seller.products.create') }}" class="bg-gradient-to-r from-flipblue to-blue-700 text-white rounded-xl p-6 hover:shadow-lg transition">
        <i class="fas fa-plus-circle text-3xl mb-2"></i>
        <h3 class="text-lg font-semibold">Add New Product</h3>
        <p class="text-sm opacity-80">List a new product for sale</p>
    </a>
    <a href="{{ route('seller.orders') }}?status=pending" class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl p-6 hover:shadow-lg transition">
        <i class="fas fa-bell text-3xl mb-2"></i>
        <h3 class="text-lg font-semibold">Pending Orders ({{ $pendingOrders }})</h3>
        <p class="text-sm opacity-80">Review and process new orders</p>
    </a>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
    @if($recentOrders->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 border-b"><th class="pb-3">Order</th><th class="pb-3">Customer</th><th class="pb-3">Product</th><th class="pb-3">Amount</th><th class="pb-3">Status</th></tr></thead>
            <tbody>
            @foreach($recentOrders as $item)
            <tr class="border-b">
                <td class="py-3 font-mono text-xs">{{ $item->order->order_number }}</td>
                <td class="py-3">{{ $item->order->user->name }}</td>
                <td class="py-3">{{ Str::limit($item->product->name ?? '', 25) }}</td>
                <td class="py-3 font-semibold">₹{{ number_format($item->total, 0) }}</td>
                <td class="py-3"><span class="px-2 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">{{ ucfirst($item->order->status) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-center py-8">No orders yet.</p>
    @endif
</div>
@endsection
