@extends('layouts.app')
@section('title', 'Shiivaraa - Money Magnet Stones, Spiritual Crystals & Healing Gemstones Marketplace')
@section('content')

<style>
    .jewelry-serif { font-family: 'Playfair Display', Georgia, serif; }
    .jewelry-sans { font-family: 'Montserrat', 'Roboto', sans-serif; }
    
    /* Animated Logo */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    .logo-shimmer {
        background: linear-gradient(90deg, #d97706 0%, #fbbf24 50%, #d97706 100%);
        background-size: 1000px 100%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 3s infinite linear;
    }
    
    /* Fade in animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    /* Floating animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

{{-- Hero Banner Carousel --}}
@if($banners->count())
<section class="relative" x-data="{ current: 0, total: {{ $banners->count() }} }" x-init="setInterval(() => current = (current + 1) % total, 5000)">
    <div class="relative overflow-hidden">
        @foreach($banners as $i => $banner)
        <div x-show="current === {{ $i }}" 
            x-transition:enter="transition ease-out duration-700" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100"
            class="relative h-[400px] md:h-[500px] bg-cover bg-center"
            style="background-image: url('{{ $banner->image ? asset('storage/' . $banner->image) : 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1600' }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
            <div class="relative h-full max-w-7xl mx-auto px-6 md:px-12 flex items-center">
                <div class="text-white max-w-xl">
                    @if($banner->title)
                    <h1 class="jewelry-serif text-4xl md:text-6xl font-light mb-4">{{ $banner->title }}</h1>
                    @endif
                    @if($banner->subtitle)
                    <p class="text-lg md:text-xl mb-6 text-gray-200">{{ $banner->subtitle }}</p>
                    @endif
                    @if($banner->link)
                    <a href="{{ $banner->link }}" class="inline-block bg-white text-gray-900 px-8 py-3 text-sm tracking-wider uppercase hover:bg-amber-100 transition">
                        Shop Now
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    {{-- Navigation Dots --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        @foreach($banners as $i => $banner)
        <button @click="current = {{ $i }}" 
            class="w-2 h-2 rounded-full transition" 
            :class="current === {{ $i }} ? 'bg-white w-8' : 'bg-white/50'"></button>
        @endforeach
    </div>
</section>
@endif

{{-- Categories Grid --}}
@if($categories->count())
<section class="py-12 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-10 animate-fade-in-up">
            <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-3">Shop Money Magnet Stones</h2>
            <p class="text-gray-600">Browse crystals and stones by category - All added by our trusted sellers</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories->take(6) as $cat)
            <a href="{{ route('category', $cat) }}" class="group transform hover:scale-105 transition-all duration-300">
                <div class="aspect-square bg-white rounded-lg overflow-hidden mb-3 shadow-sm hover:shadow-xl transition-all duration-300">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-stone-100">
                            <i class="fas fa-gem text-amber-600 text-3xl animate-float"></i>
                        </div>
                    @endif
                </div>
                <h3 class="text-center text-sm font-medium text-gray-800 group-hover:text-amber-700 transition">
                    {{ $cat->name }}
                </h3>
                <p class="text-center text-xs text-gray-500">{{ $cat->products_count }} items</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Flash Sale / Featured Products --}}
@if($flashSale->count())
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-2">
                    <i class="fas fa-bolt text-amber-600 mr-2"></i>Flash Sale
                </h2>
                <p class="text-gray-600">Limited time offers on spiritual stones</p>
            </div>
            <a href="{{ route('search', ['flash' => 1]) }}" 
                class="hidden md:inline-block border-2 border-gray-900 text-gray-900 px-6 py-2 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition">
                View All
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($flashSale->take(5) as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Collections --}}
@if($featured->count())
<section class="py-12 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-10">
            <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-3">Featured Money Magnet Stones</h2>
            <p class="text-gray-600">Powerful crystals for wealth, prosperity and abundance</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featured->take(8) as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('search') }}" 
                class="inline-block bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                Explore All Products
            </a>
        </div>
    </div>
</section>
@endif

{{-- Trending Products --}}
@if($trending->count())
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-2">
                    <i class="fas fa-fire text-red-500 mr-2"></i>Trending Now
                </h2>
                <p class="text-gray-600">Most popular spiritual items</p>
            </div>
            <a href="{{ route('search', ['sort' => 'popular']) }}" 
                class="hidden md:inline-block border-2 border-gray-900 text-gray-900 px-6 py-2 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition">
                View All
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($trending->take(6) as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- New Arrivals --}}
@if($latest->count())
<section class="py-12 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-10">
            <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-3">New Arrivals</h2>
            <p class="text-gray-600">Latest additions to our spiritual collection</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($latest->take(8) as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- About Section --}}
<section class="py-16 bg-slate-700 text-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="aspect-[4/3] rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800" 
                        class="w-full h-full object-cover">
                </div>
            </div>
            <div>
                <p class="text-amber-300 text-sm tracking-[0.3em] uppercase mb-4 animate-fade-in-up">About Our Marketplace</p>
                <h2 class="jewelry-serif text-3xl md:text-4xl font-light mb-6 logo-shimmer">Money Magnet Stones & Healing Crystals</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Welcome to the ultimate marketplace for money magnet stones, healing crystals, and spiritual gemstones. Our platform connects you with trusted sellers offering authentic crystals that attract wealth, prosperity, and positive energy.
                </p>
                <p class="text-gray-300 leading-relaxed mb-6">
                    Each seller carefully curates their collection of powerful stones including Citrine, Pyrite, Green Aventurine, Tiger's Eye, and more - all designed to help you manifest abundance and financial success.
                </p>
                <a href="{{ route('search') }}" 
                    class="inline-block border border-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-white hover:text-slate-700 transition">
                    Explore Collection
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Newsletter --}}
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-4">Stay Connected</h2>
        <p class="text-gray-600 mb-8">Subscribe to receive updates on new arrivals and exclusive offers</p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email" 
                placeholder="Enter your email" 
                class="flex-1 px-4 py-3 border border-gray-300 focus:outline-none focus:border-amber-600">
            <button type="submit" 
                class="bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                Subscribe
            </button>
        </form>
    </div>
</section>

@endsection
