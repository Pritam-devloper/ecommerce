@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div><p class="text-gray-500 text-sm">Total Revenue</p><p class="text-2xl font-bold">₹{{ number_format($totalRevenue, 0) }}</p></div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center"><i class="fas fa-rupee-sign text-green-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div><p class="text-gray-500 text-sm">Total Orders</p><p class="text-2xl font-bold">{{ $totalOrders }}</p></div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center"><i class="fas fa-shopping-bag text-blue-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div><p class="text-gray-500 text-sm">Total Users</p><p class="text-2xl font-bold">{{ $totalUsers }}</p></div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center"><i class="fas fa-users text-purple-600 text-xl"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div><p class="text-gray-500 text-sm">Total Products</p><p class="text-2xl font-bold">{{ $totalProducts }}</p></div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center"><i class="fas fa-box text-orange-600 text-xl"></i></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-500 text-sm">Pending Orders</p>
        <p class="text-xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-500 text-sm">Active Sellers</p>
        <p class="text-xl font-bold text-green-600">{{ $activeSellers }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-500 text-sm">Pending Sellers</p>
        <p class="text-xl font-bold text-orange-600">{{ $pendingSellers }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-500 text-sm">Pending Products</p>
        <p class="text-xl font-bold text-red-600">{{ $pendingProducts }}</p>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h3 class="font-semibold">Recent Orders</h3>
        <a href="{{ route('admin.orders') }}" class="text-flipblue text-sm hover:underline">View All</a>
    </div>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Order #</th><th class="p-4">Customer</th><th class="p-4">Total</th><th class="p-4">Status</th><th class="p-4">Date</th></tr></thead>
        <tbody>
        @foreach($recentOrders as $order)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-mono">{{ $order->order_number }}</td>
            <td class="p-4">{{ $order->user->name }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($order->total, 0) }}</td>
            <td class="p-4">
                @php $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'gray']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700">{{ ucfirst($order->status) }}</span>
            </td>
            <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
