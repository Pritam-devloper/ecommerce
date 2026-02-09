@extends('layouts.dashboard')
@section('title', 'Manage Orders')
@section('page-title', 'Orders')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.orders') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">All</a>
    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
    <a href="{{ route('admin.orders', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === $s ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">{{ ucfirst($s) }}</a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Order #</th><th class="p-4">Customer</th><th class="p-4">Items</th><th class="p-4">Total</th><th class="p-4">Payment</th><th class="p-4">Status</th><th class="p-4">Date</th><th class="p-4">Action</th></tr></thead>
        <tbody>
        @forelse($orders as $order)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-mono">{{ $order->order_number }}</td>
            <td class="p-4">{{ $order->user->name }}</td>
            <td class="p-4">{{ $order->items->count() }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($order->total, 0) }}</td>
            <td class="p-4"><span class="px-2 py-1 rounded text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($order->payment_status) }}</span></td>
            <td class="p-4">
                @php $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'gray']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700">{{ ucfirst($order->status) }}</span>
            </td>
            <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
            <td class="p-4"><a href="{{ route('admin.orders.detail', $order) }}" class="text-flipblue hover:underline">View</a></td>
        </tr>
        @empty
        <tr><td colspan="8" class="p-8 text-center text-gray-500">No orders found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
