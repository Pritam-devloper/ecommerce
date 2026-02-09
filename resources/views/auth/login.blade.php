@extends('layouts.app')
@section('title', 'Login - AbhiShop')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[750px] bg-white rounded-sm shadow-lg overflow-hidden flex">
        {{-- Left Panel --}}
        <div class="hidden md:flex flex-col justify-between bg-flipblue p-8 w-[300px] text-white">
            <div>
                <h2 class="text-2xl font-bold mb-3">Login</h2>
                <p class="text-sm text-blue-100">Get access to your Orders, Wishlist and Recommendations</p>
            </div>
            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/login_img-03dd.png" alt="" class="w-full opacity-90">
        </div>
        {{-- Right Panel --}}
        <div class="flex-1 p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Enter Email">
                </div>
                <div class="mb-5">
                    <label class="block text-xs text-gray-500 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Enter Password">
                </div>
                <div class="flex items-center mb-6">
                    <label class="flex items-center text-xs text-gray-500">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-flipblue focus:ring-flipblue">
                        Remember me
                    </label>
                </div>
                <p class="text-xs text-gray-400 mb-4">By continuing, you agree to AbhiShop's Terms of Use and Privacy Policy.</p>
                <button type="submit" class="w-full bg-fliporange text-white py-3 rounded-sm font-bold text-sm hover:bg-orange-600">
                    Login
                </button>
            </form>
            <div class="text-center mt-8">
                <a href="{{ route('register') }}" class="text-flipblue text-sm font-medium hover:underline">New to AbhiShop? Create an account</a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('seller.register') }}" class="text-xs text-gray-400 hover:text-flipblue">
                    <i class="fas fa-store mr-1"></i>Register as Seller
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
