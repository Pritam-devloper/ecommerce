@extends('layouts.app')
@section('title', 'My Orders - AbhiShop')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-box text-flipblue mr-2"></i>My Orders</h1>

    @forelse($orders as $order)
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
            <div>
                <span class="font-mono font-bold text-flipblue">{{ $order->order_number }}</span>
                <span class="text-sm text-gray-500 ml-3">{{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <div class="flex items-center gap-3 mt-2 md:mt-0">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                       ($order->status === 'shipped' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')) }}">
                    {{ ucfirst($order->status) }}
                </span>
                <a href="{{ route('buyer.order.detail', $order) }}" class="text-flipblue hover:underline text-sm">View Details</a>
                <a href="{{ route('buyer.order.track', $order) }}" class="text-gray-500 hover:text-flipblue text-sm"><i class="fas fa-map-marker-alt mr-1"></i>Track</a>
            </div>
        </div>
        <div class="flex flex-wrap gap-3 mb-3">
            @foreach($order->items->take(3) as $item)
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2 text-sm">
                <span>{{ Str::limit($item->product_name, 25) }}</span>
                <span class="text-gray-400">×{{ $item->quantity }}</span>
            </div>
            @endforeach
            @if($order->items->count() > 3)
            <span class="text-sm text-gray-400">+{{ $order->items->count() - 3 }} more</span>
            @endif
        </div>
        <div class="flex justify-between items-center border-t pt-3 text-sm">
            <span class="text-gray-500">Payment: <span class="capitalize">{{ $order->payment_method }}</span> ({{ ucfirst($order->payment_status) }})</span>
            <span class="text-lg font-bold text-flipblue">₹{{ number_format($order->total, 0) }}</span>
        </div>
    </div>
    @empty
    <div class="text-center py-16 bg-white rounded-xl">
        <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
        <p class="text-gray-500">No orders yet. <a href="{{ route('home') }}" class="text-flipblue hover:underline">Start shopping</a></p>
    </div>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection
