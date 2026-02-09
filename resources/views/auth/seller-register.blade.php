@extends('layouts.app')
@section('title', 'Become a Seller - AbhiShop')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[750px] bg-white rounded-sm shadow-lg overflow-hidden flex">
        {{-- Left Panel --}}
        <div class="hidden md:flex flex-col justify-between bg-flipblue p-8 w-[300px] text-white">
            <div>
                <h2 class="text-2xl font-bold mb-3">Sell Online</h2>
                <p class="text-sm text-blue-100">Start your business on AbhiShop and reach millions of customers</p>
            </div>
            <div class="text-center">
                <i class="fas fa-store text-white/30 text-6xl"></i>
            </div>
        </div>
        {{-- Right Panel --}}
        <div class="flex-1 p-8">
            <form method="POST" action="{{ route('seller.register') }}">
                @csrf
                <div class="mb-4">
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Your Full Name">
                </div>
                <div class="mb-4">
                    <input type="text" name="shop_name" value="{{ old('shop_name') }}" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Shop / Business Name">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Email Address">
                </div>
                <div class="mb-4">
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Phone Number">
                </div>
                <div class="mb-4">
                    <input type="password" name="password" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Create Password">
                </div>
                <div class="mb-5">
                    <input type="password" name="password_confirmation" required class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Confirm Password">
                </div>
                <p class="text-xs text-gray-400 mb-4">By continuing, you agree to AbhiShop's Seller Terms and Privacy Policy.</p>
                <button type="submit" class="w-full bg-fliporange text-white py-3 rounded-sm font-bold text-sm hover:bg-orange-600">
                    REGISTER & START SELLING
                </button>
            </form>
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-flipblue text-sm font-medium hover:underline">Already a seller? Log in</a>
            </div>
        </div>
    </div>
</div>
@endsection
