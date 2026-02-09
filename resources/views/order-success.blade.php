@extends('layouts.app')
@section('title', 'Order Placed! - AbhiShop')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10 text-center">
    <div class="bg-white rounded-sm shadow-sm p-10">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-check-circle text-flipgreen text-5xl"></i>
        </div>
        <h1 class="text-xl font-bold text-gray-800 mb-1">Order Placed Successfully!</h1>
        <p class="text-sm text-gray-500 mb-5">Your order has been confirmed</p>
        <div class="bg-gray-50 rounded-sm p-4 text-sm mb-5">
            <p class="text-gray-500 mb-1">Order ID</p>
            <p class="text-lg font-bold text-flipblue">{{ $order->order_number }}</p>
        </div>
        <div class="bg-gray-50 rounded-sm p-4 text-left text-sm space-y-2 mb-6">
            <div class="flex justify-between"><span class="text-gray-500">Items</span><span class="font-medium">{{ $order->items->count() }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Payment</span><span class="font-medium capitalize">{{ $order->payment_method }}</span></div>
            <hr class="border-dashed">
            <div class="flex justify-between font-bold text-base"><span>Total Amount</span><span>₹{{ number_format($order->total, 0) }}</span></div>
        </div>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('buyer.orders') }}" class="bg-flipblue text-white px-6 py-2.5 rounded-sm font-bold text-sm hover:bg-blue-700">
                <i class="fas fa-box mr-1"></i> View Orders
            </a>
            <a href="{{ route('home') }}" class="bg-flipyellow text-white px-6 py-2.5 rounded-sm font-bold text-sm hover:bg-yellow-600">
                <i class="fas fa-home mr-1"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
