@extends('layouts.app')
@section('title', 'Become a Seller - Shiivaraa')
@section('content')

<div class="min-h-screen flex items-center justify-center px-6 py-12 bg-stone-50">
    <div class="w-full max-w-6xl grid md:grid-cols-2 gap-0 bg-white shadow-xl overflow-hidden">
        
        {{-- Left Panel - Image --}}
        <div class="hidden md:block relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800');">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 to-slate-800/60"></div>
            <div class="relative h-full flex flex-col justify-between p-12 text-white">
                <div>
                    <h1 class="jewelry-serif text-4xl font-light mb-4">Sell on Shiivaraa</h1>
                    <p class="text-gray-200 leading-relaxed mb-6">
                        Join our curated marketplace and showcase your exquisite jewelry to discerning customers worldwide.
                    </p>
                    <div class="space-y-3 text-sm">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-amber-400"></i>
                            Reach premium customers
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-amber-400"></i>
                            Low commission rates
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-amber-400"></i>
                            Secure payment processing
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-amber-400"></i>
                            Marketing support
                        </p>
                    </div>
                </div>
                <div class="text-center">
                    <i class="fas fa-store text-white/20 text-8xl"></i>
                </div>
            </div>
        </div>

        {{-- Right Panel - Form --}}
        <div class="p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-2">Seller Registration</h2>
                <p class="text-gray-600 text-sm">Start your journey as an Shiivaraa seller</p>
            </div>

            <form method="POST" action="{{ route('seller.register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Full Name</label>
                    <input type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('name') border-red-500 @enderror"
                        placeholder="Your full name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Shop Name --}}
                <div>
                    <label for="shop_name" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Shop Name</label>
                    <input type="text" 
                        id="shop_name" 
                        name="shop_name" 
                        value="{{ old('shop_name') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('shop_name') border-red-500 @enderror"
                        placeholder="Your business name">
                    @error('shop_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Email Address</label>
                    <input type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('email') border-red-500 @enderror"
                        placeholder="business@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Phone Number</label>
                    <input type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition @error('phone') border-red-500 @enderror"
                        placeholder="+91 1234567890">
                    @error('phone')
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
                        placeholder="Minimum 8 characters">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Confirm Password</label>
                    <input type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600 transition"
                        placeholder="Re-enter password">
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                    class="w-full bg-gray-900 text-white py-4 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                    Register & Start Selling
                </button>

                {{-- Terms --}}
                <p class="text-xs text-gray-500 text-center">
                    By registering, you agree to Shiivaraa's 
                    <a href="#" class="text-amber-700 hover:underline">Seller Terms</a> and 
                    <a href="#" class="text-amber-700 hover:underline">Privacy Policy</a>
                </p>
            </form>

            {{-- Login Link --}}
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-amber-700 transition">
                    Already a seller? <span class="font-medium">Sign In</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
