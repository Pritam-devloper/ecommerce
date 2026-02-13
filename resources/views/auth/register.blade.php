@extends('layouts.app')
@section('title', 'Create Account - AETHER')
@section('content')

<div class="min-h-screen flex items-center justify-center px-6 py-12 bg-stone-50">
    <div class="w-full max-w-6xl grid md:grid-cols-2 gap-0 bg-white shadow-xl overflow-hidden">
        
        {{-- Left Panel - Image --}}
        <div class="hidden md:block relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800');">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 to-slate-800/60"></div>
            <div class="relative h-full flex flex-col justify-between p-12 text-white">
                <div>
                    <h1 class="jewelry-serif text-4xl font-light mb-4">Join AETHER</h1>
                    <p class="text-gray-200 leading-relaxed">
                        Create an account to unlock exclusive access to our handcrafted jewelry collections and personalized shopping experience.
                    </p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Member Benefits</p>
                            <p class="text-sm text-gray-300">Exclusive offers and early access</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-gift text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Special Rewards</p>
                            <p class="text-sm text-gray-300">Earn points on every purchase</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-amber-400"></i>
                        </div>
                        <div>
                            <p class="font-medium">Secure Shopping</p>
                            <p class="text-sm text-gray-300">Protected transactions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel - Form --}}
        <div class="p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-2">Create Account</h2>
                <p class="text-gray-600 text-sm">Fill in your details to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
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
                        placeholder="John Doe">
                    @error('name')
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
                    Create Account
                </button>

                {{-- Terms --}}
                <p class="text-xs text-gray-500 text-center">
                    By creating an account, you agree to AETHER's 
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
                    <span class="px-4 bg-white text-gray-500">Already have an account?</span>
                </div>
            </div>

            {{-- Login Link --}}
            <a href="{{ route('login') }}" 
                class="block w-full border-2 border-gray-900 text-gray-900 py-4 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition text-center">
                Sign In
            </a>
        </div>
    </div>
</div>

@endsection
