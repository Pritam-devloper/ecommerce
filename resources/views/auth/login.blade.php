@extends('layouts.app')
@section('title', 'Login - AETHER')
@section('content')

<div class="min-h-screen flex items-center justify-center px-6 py-12 bg-stone-50">
    <div class="w-full max-w-6xl grid md:grid-cols-2 gap-0 bg-white shadow-xl overflow-hidden">
        
        {{-- Left Panel - Image --}}
        <div class="hidden md:block relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=800');">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 to-slate-800/60"></div>
            <div class="relative h-full flex flex-col justify-between p-12 text-white">
                <div>
                    <h1 class="jewelry-serif text-4xl font-light mb-4">Welcome Back</h1>
                    <p class="text-gray-200 leading-relaxed">
                        Sign in to access your account and explore our exquisite collection of handcrafted jewelry.
                    </p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-gem text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Exclusive Collections</p>
                            <p class="text-sm text-gray-300">Access limited edition pieces</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-heart text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Wishlist & Favorites</p>
                            <p class="text-sm text-gray-300">Save your favorite pieces</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-truck text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Order Tracking</p>
                            <p class="text-sm text-gray-300">Track your purchases</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel - Form --}}
        <div class="p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-2">Sign In</h2>
                <p class="text-gray-600 text-sm">Enter your credentials to access your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Email Address</label>
                    <input type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('email') border-red-500 @enderror"
                        placeholder="your@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Password</label>
                    <input type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('password') border-red-500 @enderror"
                        placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" 
                            name="remember" 
                            class="mr-2 border-gray-300 text-amber-600 focus:ring-amber-600 focus:ring-offset-0">
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-amber-700 hover:text-amber-800">Forgot password?</a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                    class="w-full bg-gray-900 text-white py-4 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                    Sign In
                </button>

                {{-- Terms --}}
                <p class="text-xs text-gray-500 text-center">
                    By continuing, you agree to AETHER's 
                    <a href="#" class="text-amber-700 hover:underline">Terms of Service</a> and 
                    <a href="#" class="text-amber-700 hover:underline">Privacy Policy</a>
                </p>
            </form>

            {{-- Divider --}}
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">New to AETHER?</span>
                </div>
            </div>

            {{-- Register Links --}}
            <div class="space-y-3">
                <a href="{{ route('register') }}" 
                    class="block w-full border-2 border-gray-900 text-gray-900 py-4 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition text-center">
                    Create Account
                </a>
                <a href="{{ route('seller.register') }}" 
                    class="block text-center text-sm text-gray-600 hover:text-amber-700 transition">
                    <i class="fas fa-store mr-2"></i>Register as a Seller
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
