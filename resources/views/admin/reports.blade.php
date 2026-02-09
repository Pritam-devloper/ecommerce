@extends('layouts.dashboard')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<!-- Monthly Revenue -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="font-semibold mb-4">Monthly Revenue (Last 12 Months)</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-3">Month</th><th class="p-3">Orders</th><th class="p-3">Revenue</th></tr></thead>
            <tbody>
            @foreach($monthlyRevenue as $data)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ \Carbon\Carbon::create($data->year, $data->month)->format('M Y') }}</td>
                <td class="p-3">{{ $data->orders }}</td>
                <td class="p-3 font-semibold text-green-600">₹{{ number_format($data->revenue, 0) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Top Sellers -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold mb-4">Top 10 Sellers by Revenue</h3>
        <div class="space-y-3">
            @foreach($topSellers as $i => $seller)
            <div class="flex items-center gap-3 p-2 {{ $i < 3 ? 'bg-yellow-50 rounded-lg' : '' }}">
                <span class="w-6 text-center font-bold text-gray-400">#{{ $i+1 }}</span>
                <div class="flex-1">
                    <p class="font-medium">{{ $seller->shop_name }}</p>
                    <p class="text-xs text-gray-500">{{ $seller->total_orders }} orders</p>
                </div>
                <span class="font-semibold text-green-600">₹{{ number_format($seller->total_revenue, 0) }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top Categories -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold mb-4">Top Categories by Sales</h3>
        <div class="space-y-3">
            @foreach($topCategories as $i => $cat)
            <div class="flex items-center gap-3 p-2 {{ $i < 3 ? 'bg-blue-50 rounded-lg' : '' }}">
                <span class="w-6 text-center font-bold text-gray-400">#{{ $i+1 }}</span>
                <div class="flex-1">
                    <p class="font-medium">{{ $cat->name }}</p>
                    <p class="text-xs text-gray-500">{{ $cat->products_count }} products</p>
                </div>
                <span class="font-semibold text-blue-600">{{ $cat->total_sold }} sold</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
