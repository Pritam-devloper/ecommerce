@extends('layouts.app')
@section('title', 'Order #' . $order->order_number)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <a href="{{ route('buyer.orders') }}" class="text-flipblue hover:underline text-sm mb-4 inline-block"><i class="fas fa-arrow-left mr-1"></i>Back to Orders</a>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-xl font-bold">Order {{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        {{-- Items --}}
        <div class="border rounded-lg overflow-hidden mb-6">
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr><th class="text-left p-3">Product</th><th class="p-3">Price</th><th class="p-3">Qty</th><th class="text-right p-3">Total</th></tr></thead>
                <tbody>
                @foreach($order->items as $item)
                <tr class="border-t">
                    <td class="p-3">{{ $item->product_name }}</td>
                    <td class="p-3 text-center">₹{{ number_format($item->price, 0) }}</td>
                    <td class="p-3 text-center">{{ $item->quantity }}</td>
                    <td class="p-3 text-right font-semibold">₹{{ number_format($item->total, 0) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Delivery Address</h3>
                @if($order->address)
                <p class="text-sm text-gray-600">{{ $order->address->name }}<br>{{ $order->address->full_address }}<br>{{ $order->address->phone }}</p>
                @endif
            </div>
            <div class="text-right">
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>₹{{ number_format($order->subtotal, 0) }}</span></div>
                    @if($order->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-₹{{ number_format($order->discount, 0) }}</span></div>@endif
                    <div class="flex justify-between"><span class="text-gray-500">Shipping</span><span>{{ $order->shipping > 0 ? '₹'.number_format($order->shipping, 0) : 'FREE' }}</span></div>
                    <hr>
                    <div class="flex justify-between text-lg font-bold"><span>Total</span><span class="text-flipblue">₹{{ number_format($order->total, 0) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
