@extends('layouts.app')
@section('title', 'AbhiShop - Online Shopping India')
@section('content')

{{-- Category Nav Strip --}}
@if($categories->count())
<div class="bg-white shadow-sm">
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex items-center gap-8 overflow-x-auto scrollbar-hide py-3">
            @foreach($categories as $cat)
            <a href="{{ route('category', $cat) }}" class="shrink-0 flex flex-col items-center gap-1.5 group min-w-[64px]">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-50 flex items-center justify-center border-2 border-transparent group-hover:border-flipblue transition">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-tag text-flipblue text-lg"></i>
                    @endif
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-flipblue text-center leading-tight">{{ $cat->name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Banner Slider --}}
<div class="max-w-[1440px] mx-auto px-4 mt-3">
    @if($banners->count())
    <div class="relative rounded-sm overflow-hidden" x-data="{ current: 0, total: {{ $banners->count() }} }" x-init="setInterval(() => current = (current + 1) % total, 4000)">
        <div class="overflow-hidden relative h-52 md:h-72 bg-flipblue">
            @foreach($banners as $i => $banner)
            <div x-show="current === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0"
                class="absolute inset-0">
                @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-flipblue to-blue-700 flex items-center justify-center text-white">
                        <div class="text-center">
                            <h2 class="text-3xl md:text-5xl font-bold mb-3">{{ $banner->title ?? 'Big Savings Days' }}</h2>
                            @if($banner->link)<a href="{{ $banner->link }}" class="inline-block bg-white text-flipblue px-6 py-2 rounded-sm font-bold text-sm hover:bg-gray-100 mt-2">Shop Now</a>@endif
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        <button @click="current = (current - 1 + total) % total" class="absolute left-0 top-0 h-full w-12 bg-white/20 hover:bg-white/40 flex items-center justify-center text-gray-700">
            <i class="fas fa-chevron-left text-lg"></i>
        </button>
        <button @click="current = (current + 1) % total" class="absolute right-0 top-0 h-full w-12 bg-white/20 hover:bg-white/40 flex items-center justify-center text-gray-700">
            <i class="fas fa-chevron-right text-lg"></i>
        </button>
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
            @foreach($banners as $i => $banner)
            <button @click="current = {{ $i }}" class="w-2 h-2 rounded-full transition" :class="current === {{ $i }} ? 'bg-white' : 'bg-white/50'"></button>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-gradient-to-r from-flipblue to-blue-700 h-52 md:h-72 rounded-sm flex items-center justify-center text-white text-center">
        <div>
            <h1 class="text-3xl md:text-5xl font-bold mb-3">Welcome to AbhiShop</h1>
            <p class="text-lg mb-4 opacity-90">Discover amazing products at best prices</p>
            <a href="{{ route('search') }}" class="bg-flipyellow text-white px-8 py-2.5 rounded-sm font-bold text-sm hover:bg-yellow-600 inline-block">Explore Now</a>
        </div>
    </div>
    @endif
</div>

<div class="max-w-[1440px] mx-auto px-4">

    {{-- Flash Sale Section --}}
    @if($flashSale->count())
    <section class="bg-white rounded-sm shadow-sm mt-3 p-4">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-900">Flash Deals</h2>
                <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/flashSaleEtc-a498f3.png" class="h-5 opacity-60" alt="">
            </div>
            <a href="{{ route('search') }}?flash=1" class="bg-flipblue text-white px-5 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">VIEW ALL</a>
        </div>
        <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2">
            @foreach($flashSale as $product)
            <div class="min-w-[180px] max-w-[200px] shrink-0">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Featured Products --}}
    @if($featured->count())
    <section class="bg-white rounded-sm shadow-sm mt-3 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Best of Electronics</h2>
            <a href="{{ route('search') }}" class="bg-flipblue text-white px-5 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">VIEW ALL</a>
        </div>
        <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2">
            @foreach($featured as $product)
            <div class="min-w-[180px] max-w-[200px] shrink-0">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Mid Banner --}}
    <section class="mt-3 bg-gradient-to-r from-blue-600 to-flipblue rounded-sm shadow-sm p-6 md:p-8 flex items-center justify-between text-white">
        <div>
            <p class="text-sm font-medium opacity-80 uppercase tracking-widest">AbhiShop Exclusive</p>
            <h2 class="text-2xl md:text-3xl font-bold mt-1">Top Offers on Fashion & More</h2>
            <p class="text-sm opacity-80 mt-1">Get extra discounts with coupons</p>
        </div>
        <a href="{{ route('search') }}" class="shrink-0 bg-white text-flipblue px-6 py-2.5 rounded-sm font-bold text-sm hover:bg-gray-100">SHOP NOW</a>
    </section>

    {{-- Trending Products --}}
    @if($trending->count())
    <section class="bg-white rounded-sm shadow-sm mt-3 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Trending Now <i class="fas fa-fire text-red-500 ml-1"></i></h2>
            <a href="{{ route('search') }}?sort=popular" class="bg-flipblue text-white px-5 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">VIEW ALL</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
            @foreach($trending as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    {{-- Latest Products --}}
    @if($latest->count())
    <section class="bg-white rounded-sm shadow-sm mt-3 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Recently Added</h2>
            <a href="{{ route('search') }}?sort=newest" class="bg-flipblue text-white px-5 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">VIEW ALL</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
            @foreach($latest as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    {{-- Become a Seller CTA --}}
    <section class="mt-3 mb-4">
        <div class="bg-white rounded-sm shadow-sm p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-flipblue text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Sell on AbhiShop</h2>
                    <p class="text-gray-500 text-sm">Join thousands of sellers already growing their business</p>
                </div>
            </div>
            <a href="{{ route('seller.register') }}" class="bg-flipyellow text-white px-8 py-3 rounded-sm font-bold text-sm hover:bg-yellow-600 shrink-0">
                Start Selling
            </a>
        </div>
    </section>
</div>
@endsection
