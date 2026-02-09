@extends('layouts.app')
@section('title', 'Checkout - AbhiShop')
@section('content')
<div class="max-w-[1440px] mx-auto px-4 py-4">
    <form method="POST" action="{{ route('checkout.place') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 space-y-3">
                {{-- Step 1: Delivery Address --}}
                <div class="bg-white rounded-sm shadow-sm">
                    <div class="bg-flipblue text-white px-5 py-3 flex items-center gap-2 text-sm font-bold">
                        <span class="bg-white text-flipblue rounded-sm w-5 h-5 flex items-center justify-center text-xs font-bold">1</span>
                        DELIVERY ADDRESS
                    </div>
                    <div class="p-5">
                        @if($addresses->count())
                            <div class="space-y-3">
                                @foreach($addresses as $address)
                                <label class="flex items-start gap-3 p-3 border rounded-sm cursor-pointer hover:bg-blue-50 {{ $address->is_default ? 'border-flipblue bg-blue-50' : 'border-gray-200' }}">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} class="mt-1">
                                    <div>
                                        <span class="font-bold text-sm">{{ $address->name }}</span>
                                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-sm ml-2 uppercase">{{ $address->type ?? 'Home' }}</span>
                                        <p class="text-sm text-gray-600 mt-1">{{ $address->full_address }}</p>
                                        <p class="text-sm text-gray-900 mt-1 font-medium"><i class="fas fa-phone text-xs mr-1"></i>{{ $address->phone }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No saved addresses. <a href="{{ route('buyer.addresses') }}" class="text-flipblue font-medium">+ Add New Address</a></p>
                        @endif
                    </div>
                </div>

                {{-- Step 2: Payment --}}
                <div class="bg-white rounded-sm shadow-sm">
                    <div class="bg-flipblue text-white px-5 py-3 flex items-center gap-2 text-sm font-bold">
                        <span class="bg-white text-flipblue rounded-sm w-5 h-5 flex items-center justify-center text-xs font-bold">2</span>
                        PAYMENT METHOD
                    </div>
                    <div class="p-5 space-y-3">
                        <label class="flex items-center gap-3 p-3 border rounded-sm cursor-pointer hover:bg-blue-50 border-flipblue bg-blue-50">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <i class="fas fa-money-bill-wave text-flipgreen text-lg"></i>
                            <div>
                                <p class="text-sm font-bold">Cash on Delivery</p>
                                <p class="text-xs text-gray-400">Pay when you receive</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 border rounded-sm cursor-pointer hover:bg-blue-50">
                            <input type="radio" name="payment_method" value="online">
                            <i class="fas fa-credit-card text-flipblue text-lg"></i>
                            <div>
                                <p class="text-sm font-bold">Online Payment</p>
                                <p class="text-xs text-gray-400">UPI / Card / NetBanking</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-sm shadow-sm p-5">
                    <label class="text-sm font-bold text-gray-700 block mb-2">Order Notes (Optional)</label>
                    <textarea name="notes" rows="2" placeholder="Any special instructions..." class="w-full border rounded-sm px-3 py-2 text-sm"></textarea>
                </div>
            </div>

            {{-- Price Details --}}
            <div>
                <div class="bg-white rounded-sm shadow-sm sticky top-16">
                    <div class="px-5 py-4 border-b">
                        <h3 class="text-sm font-bold text-gray-500 uppercase">Price Details</h3>
                    </div>
                    <div class="px-5 py-4">
                        <div class="space-y-3 mb-4 max-h-48 overflow-y-auto">
                            @foreach($cartItems as $item)
                            <div class="flex gap-2 text-sm">
                                <div class="w-10 h-10 shrink-0 bg-gray-50 rounded-sm overflow-hidden flex items-center justify-center">
                                    @if($item->product->thumbnail)
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="max-h-full max-w-full object-contain">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-700 line-clamp-1">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->quantity }} × ₹{{ number_format($item->product->final_price, 0) }}</p>
                                </div>
                                <span class="text-sm font-medium">₹{{ number_format($item->quantity * $item->product->final_price, 0) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="space-y-2 text-sm mt-3">
                            <div class="flex justify-between"><span>Price ({{ $cartItems->count() }} items)</span><span>₹{{ number_format($subtotal, 0) }}</span></div>
                            @if($discount > 0)
                            <div class="flex justify-between text-flipgreen"><span>Discount</span><span>−₹{{ number_format($discount, 0) }}</span></div>
                            @endif
                            <div class="flex justify-between"><span>Delivery Charges</span><span class="{{ $shipping == 0 ? 'text-flipgreen' : '' }}">{{ $shipping > 0 ? '₹'.number_format($shipping, 0) : 'FREE' }}</span></div>
                            <hr class="border-dashed">
                            <div class="flex justify-between text-base font-bold">
                                <span>Total Amount</span><span>₹{{ number_format($total, 0) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 pb-4">
                        <button type="submit" class="w-full bg-fliporange text-white py-3 rounded-sm font-bold text-sm hover:bg-orange-600">
                            CONFIRM ORDER
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
