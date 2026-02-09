@extends('layouts.app')
@section('title', 'Shopping Cart - AbhiShop')
@section('content')
<div class="max-w-[1440px] mx-auto px-4 py-4">
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
        <a href="{{ route('home') }}" class="hover:text-flipblue">Home</a>
        <i class="fas fa-angle-right"></i>
        <span class="text-gray-600">My Cart</span>
    </div>

    @if($cartItems->count())
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-0">
            <div class="bg-white rounded-sm shadow-sm">
                <div class="px-5 py-4 border-b">
                    <h1 class="text-lg font-bold text-gray-900">My Cart ({{ $cartItems->count() }})</h1>
                </div>

                @foreach($cartItems as $item)
                <div class="px-5 py-4 border-b last:border-0 flex gap-4">
                    <div class="w-28 h-28 shrink-0 flex items-center justify-center">
                        @if($item->product->thumbnail)
                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="max-h-full max-w-full object-contain">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300"><i class="fas fa-image text-3xl"></i></div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('product.show', $item->product) }}" class="text-sm text-gray-800 hover:text-flipblue font-medium line-clamp-1">{{ $item->product->name }}</a>
                        <p class="text-xs text-gray-400 mt-1">Seller: {{ $item->product->seller->shop_name ?? 'N/A' }}</p>

                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-lg font-bold text-gray-900">₹{{ number_format($item->product->final_price, 0) }}</span>
                            @if($item->product->discount_price)
                                <span class="text-sm text-gray-400 line-through">₹{{ number_format($item->product->price, 0) }}</span>
                                <span class="text-sm text-flipgreen font-medium">{{ $item->product->discount_percent }}% off</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 mt-3">
                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center border rounded-sm">
                                @csrf @method('PATCH')
                                <select name="quantity" onchange="this.form.submit()" class="px-2 py-1.5 text-sm border-0 focus:ring-0 bg-transparent appearance-none cursor-pointer">
                                    @for($i = 1; $i <= min($item->product->stock, 10); $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>Qty: {{ $i }}</option>
                                    @endfor
                                </select>
                            </form>
                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf @method('DELETE')
                                <button class="text-sm font-bold text-gray-600 hover:text-flipblue uppercase">Remove</button>
                            </form>
                        </div>
                    </div>
                    <div class="shrink-0 text-right">
                        <span class="font-bold text-gray-900">₹{{ number_format($item->quantity * $item->product->final_price, 0) }}</span>
                    </div>
                </div>
                @endforeach

                <div class="px-5 py-4 flex justify-end">
                    <a href="{{ route('checkout') }}" class="bg-fliporange text-white px-12 py-3 rounded-sm font-bold text-sm hover:bg-orange-600">
                        PLACE ORDER
                    </a>
                </div>
            </div>
        </div>

        {{-- Price Details --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-sm shadow-sm sticky top-16">
                <div class="px-5 py-4 border-b">
                    <h3 class="text-sm font-bold text-gray-500 uppercase">Price Details</h3>
                </div>
                <div class="px-5 py-4 space-y-3 text-sm">
                    {{-- Coupon --}}
                    @if(session('coupon'))
                        <div class="bg-green-50 border border-green-200 rounded-sm p-3 flex justify-between items-center">
                            <span class="text-green-700 text-xs"><i class="fas fa-tag mr-1"></i>"{{ session('coupon.code') }}" applied</span>
                            <form method="POST" action="{{ route('cart.coupon.remove') }}">@csrf @method('DELETE')
                                <button class="text-red-500 text-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('cart.coupon.apply') }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Enter coupon code" class="flex-1 border rounded-sm px-3 py-2 text-sm">
                            <button type="submit" class="text-flipblue font-bold text-sm px-3 hover:underline">APPLY</button>
                        </form>
                    @endif

                    <hr>
                    <div class="flex justify-between"><span>Price ({{ $cartItems->count() }} items)</span><span>₹{{ number_format($subtotal, 0) }}</span></div>
                    @if(session('coupon'))
                    <div class="flex justify-between text-flipgreen"><span>Discount</span><span>−₹{{ number_format(session('coupon.discount'), 0) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span>Delivery Charges</span><span class="{{ $subtotal > 500 ? 'text-flipgreen' : '' }}">{{ $subtotal > 500 ? 'FREE' : '₹50' }}</span></div>
                    <hr class="border-dashed">
                    <div class="flex justify-between text-base font-bold">
                        <span>Total Amount</span>
                        <span>₹{{ number_format($subtotal - (session('coupon.discount') ?? 0) + ($subtotal > 500 ? 0 : 50), 0) }}</span>
                    </div>
                    @if(session('coupon') || $subtotal > 500)
                    <p class="text-flipgreen text-xs font-medium">You will save ₹{{ number_format((session('coupon.discount') ?? 0) + ($subtotal > 500 ? 50 : 0), 0) }} on this order</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20 bg-white rounded-sm shadow-sm">
        <i class="fas fa-shopping-cart text-gray-200 text-6xl mb-4"></i>
        <h2 class="text-lg text-gray-500 mb-1">Your cart is empty!</h2>
        <p class="text-gray-400 text-sm mb-4">Add items to it now.</p>
        <a href="{{ route('home') }}" class="bg-flipblue text-white px-10 py-3 rounded-sm font-bold text-sm hover:bg-blue-700">Shop Now</a>
    </div>
    @endif
</div>
@endsection
