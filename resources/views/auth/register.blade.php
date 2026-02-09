@extends('layouts.app')
@section('title', 'Register - AbhiShop')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[750px] bg-white rounded-sm shadow-lg overflow-hidden flex">
        {{-- Left Panel --}}
        <div class="hidden md:flex flex-col justify-between bg-flipblue p-8 w-[300px] text-white">
            <div>
                <h2 class="text-2xl font-bold mb-3">Looks like you're new here!</h2>
                <p class="text-sm text-blue-100">Sign up with your email to get started</p>
            </div>
            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/login_img-03dd.png" alt="" class="w-full opacity-90">
        </div>
        {{-- Right Panel --}}
        <div class="flex-1 p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-5">
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Enter Full Name">
                </div>
                <div class="mb-5">
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Enter Email">
                </div>
                <div class="mb-5">
                    <input type="password" name="password" required
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Password">
                </div>
                <div class="mb-5">
                    <input type="password" name="password_confirmation" required
                        class="w-full px-0 py-2 border-0 border-b-2 border-gray-200 focus:border-flipblue focus:ring-0 text-sm" placeholder="Confirm Password">
                </div>
                <p class="text-xs text-gray-400 mb-4">By continuing, you agree to AbhiShop's Terms of Use and Privacy Policy.</p>
                <button type="submit" class="w-full bg-fliporange text-white py-3 rounded-sm font-bold text-sm hover:bg-orange-600">
                    CONTINUE
                </button>
            </form>
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-flipblue text-sm font-medium hover:underline">Existing User? Log in</a>
            </div>
        </div>
    </div>
</div>
@endsection
