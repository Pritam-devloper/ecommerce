@extends('layouts.app')
@section('title', 'Track Order')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('buyer.orders') }}" class="text-flipblue hover:underline text-sm mb-4 inline-block"><i class="fas fa-arrow-left mr-1"></i>Back to Orders</a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h1 class="text-xl font-bold mb-2">Track Order</h1>
        <p class="text-gray-500 text-sm mb-8">{{ $order->order_number }}</p>

        @php
            $steps = ['pending' => 'Order Placed', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
            $statuses = array_keys($steps);
            $currentIndex = array_search($order->status, $statuses);
            if ($order->status === 'cancelled') $currentIndex = -1;
        @endphp

        @if($order->status === 'cancelled')
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                </div>
                <p class="text-xl font-bold text-red-600">Order Cancelled</p>
            </div>
        @else
            <div class="flex items-center justify-between relative">
                <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 -z-0"></div>
                <div class="absolute top-5 left-0 h-1 bg-flipblue -z-0" style="width: {{ $currentIndex !== false ? ($currentIndex / (count($steps) - 1)) * 100 : 0 }}%"></div>
                @foreach($steps as $key => $label)
                    @php $index = array_search($key, $statuses); @endphp
                    <div class="flex flex-col items-center z-10">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                            {{ $index <= $currentIndex ? 'bg-flipblue text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if($index < $currentIndex) <i class="fas fa-check"></i>
                            @elseif($index === $currentIndex) <i class="fas fa-circle text-xs"></i>
                            @else {{ $index + 1 }} @endif
                        </div>
                        <span class="text-xs mt-2 font-medium {{ $index <= $currentIndex ? 'text-flipblue' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                @if($order->shipped_at)<p>Shipped at: {{ $order->shipped_at->format('d M Y, h:i A') }}</p>@endif
                @if($order->delivered_at)<p>Delivered at: {{ $order->delivered_at->format('d M Y, h:i A') }}</p>@endif
            </div>
        @endif
    </div>
</div>
@endsection
