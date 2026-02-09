@extends('layouts.dashboard')
@section('title', 'My Orders')
@section('page-title', 'Manage Orders')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<!-- Status Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('seller.orders') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-flipblue text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">All</a>
    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
    <a href="{{ route('seller.orders', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === $s ? 'bg-flipblue text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">{{ ucfirst($s) }}</a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Order #</th><th class="p-4">Customer</th><th class="p-4">Items</th><th class="p-4">Total</th><th class="p-4">Status</th><th class="p-4">Date</th><th class="p-4">Action</th></tr></thead>
        <tbody>
        @forelse($orders as $order)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-mono text-sm">{{ $order->order_number }}</td>
            <td class="p-4">{{ $order->user->name }}</td>
            <td class="p-4">{{ $order->items->where('seller_id', auth()->user()->seller->id)->count() }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($order->items->where('seller_id', auth()->user()->seller->id)->sum('total'), 0) }}</td>
            <td class="p-4">
                @php $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'gray']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700">{{ ucfirst($order->status) }}</span>
            </td>
            <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
            <td class="p-4">
                <a href="{{ route('seller.orders.detail', $order) }}" class="text-flipblue hover:underline">View</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="p-8 text-center text-gray-500">No orders found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
