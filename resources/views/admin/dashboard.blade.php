@extends('layouts.dashboard')
@section('title', 'My Store Dashboard - Shiivaraa')
@section('page-title', 'My Store Overview')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-slate-700 to-slate-600 rounded-xl shadow-lg p-8 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Welcome to Your Shiivaraa Store</h2>
            <p class="text-gray-200">Manage your money magnet stones and spiritual crystals business</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-gem text-amber-400 text-6xl opacity-20"></i>
        </div>
    </div>
</div>

<!-- Main Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-rupee-sign text-green-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">₹{{ number_format($totalRevenue, 0) }}</p>
        <p class="text-xs text-gray-500 mt-2">All time earnings</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-600 text-sm font-medium">Total Orders</p>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
        <p class="text-xs text-gray-500 mt-2">
            <span class="text-yellow-600 font-semibold">{{ $pendingOrders }}</span> pending
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-600 text-sm font-medium">Total Products</p>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-gem text-purple-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
        <p class="text-xs text-gray-500 mt-2">Money magnet stones</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-600 text-sm font-medium">Total Customers</p>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-amber-600 text-xl"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
        <p class="text-xs text-gray-500 mt-2">Registered buyers</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.products') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition text-center">
        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-plus text-purple-600 text-xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-700">Add Product</p>
    </a>
    
    <a href="{{ route('admin.categories') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition text-center">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-tags text-blue-600 text-xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-700">Manage Categories</p>
    </a>
    
    <a href="{{ route('admin.banners') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition text-center">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-image text-green-600 text-xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-700">Add Banner</p>
    </a>
    
    <a href="{{ route('admin.orders') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition text-center">
        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-list text-amber-600 text-xl"></i>
        </div>
        <p class="text-sm font-medium text-gray-700">View Orders</p>
    </a>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
        <a href="{{ route('admin.orders') }}" class="text-amber-600 text-sm font-medium hover:text-amber-700">View All →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-gray-600 border-b">
                    <th class="p-4 font-medium">Order ID</th>
                    <th class="p-4 font-medium">Customer</th>
                    <th class="p-4 font-medium">Amount</th>
                    <th class="p-4 font-medium">Status</th>
                    <th class="p-4 font-medium">Date</th>
                    <th class="p-4 font-medium">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentOrders as $order)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="p-4 font-mono text-gray-900">#{{ $order->order_number }}</td>
                <td class="p-4">
                    <div class="font-medium text-gray-900">{{ $order->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                </td>
                <td class="p-4 font-semibold text-gray-900">₹{{ number_format($order->total, 0) }}</td>
                <td class="p-4">
                    @php 
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'confirmed' => 'bg-blue-100 text-blue-700',
                            'processing' => 'bg-purple-100 text-purple-700',
                            'shipped' => 'bg-indigo-100 text-indigo-700',
                            'delivered' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            'refunded' => 'bg-gray-100 text-gray-700'
                        ];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="p-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                <td class="p-4">
                    <a href="{{ route('admin.orders.detail', $order) }}" class="text-amber-600 hover:text-amber-700 font-medium">
                        View →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                    <p>No orders yet</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
