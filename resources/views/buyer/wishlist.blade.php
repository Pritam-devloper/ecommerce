@extends('layouts.app')
@section('title', 'My Wishlist - Shiivaraa')
@section('content')

<div class="bg-stone-50 min-h-screen">
    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-2">
                        <i class="fas fa-heart text-amber-600 mr-3"></i>My Wishlist
                    </h1>
                    <p class="text-gray-600">Your favorite pieces saved for later</p>
                </div>
                @if($items->count())
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $items->total() }} {{ Str::plural('item', $items->total()) }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
        @if($items->count())
            {{-- Wishlist Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($items as $item)
                <div class="group relative bg-white">
                    {{-- Remove from Wishlist Button --}}
                    <form method="POST" action="{{ route('buyer.wishlist.toggle', $item->product) }}" class="absolute top-3 right-3 z-10">
                        @csrf
                        <button type="submit" 
                            class="w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-md transition">
                            <i class="fas fa-times text-gray-600 hover:text-red-600"></i>
                        </button>
                    </form>

                    <a href="{{ route('product.show', $item->product) }}" class="block">
                        {{-- Product Image --}}
                        <div class="aspect-square bg-stone-100 overflow-hidden relative">
                            @if($item->product->thumbnail)
                                @if(str_starts_with($item->product->thumbnail, 'http'))
                                    <img src="{{ $item->product->thumbnail }}" 
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" 
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-stone-200">
                                    <i class="fas fa-gem text-gray-400 text-4xl"></i>
                                </div>
                            @endif

                            @if($item->product->discount_price)
                            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 uppercase tracking-wider">
                                Sale
                            </span>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="p-4">
                            <h3 class="text-sm text-gray-800 mb-2 line-clamp-2 group-hover:text-amber-700 transition">
                                {{ $item->product->name }}
                            </h3>

                            {{-- Rating --}}
                            @php 
                                $rating = $item->product->averageRating(); 
                                $reviewCount = $item->product->reviews->count(); 
                            @endphp
                            @if($reviewCount > 0)
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex text-amber-500 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - $rating < 1)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">({{ $reviewCount }})</span>
                            </div>
                            @endif

                            {{-- Price --}}
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-900 font-medium">₹{{ number_format($item->product->final_price) }}</span>
                                @if($item->product->discount_price)
                                    <span class="text-sm text-gray-400 line-through">₹{{ number_format($item->product->price) }}</span>
                                @endif
                            </div>

                            {{-- Stock Status --}}
                            @if($item->product->stock > 0)
                                <p class="text-xs text-green-600 mb-3">
                                    <i class="fas fa-check-circle mr-1"></i>In Stock
                                </p>
                            @else
                                <p class="text-xs text-red-600 mb-3">
                                    <i class="fas fa-times-circle mr-1"></i>Out of Stock
                                </p>
                            @endif
                        </div>
                    </a>

                    {{-- Add to Cart Button --}}
                    <div class="px-4 pb-4">
                        <form method="POST" action="{{ route('cart.add', $item->product) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" 
                                class="w-full bg-gray-900 text-white py-2 text-xs tracking-wider uppercase hover:bg-gray-800 transition {{ $item->product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $item->product->stock < 1 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-bag mr-1"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                {{ $items->links() }}
            </div>

        @else
            {{-- Empty Wishlist --}}
            <div class="bg-white p-16 text-center">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-heart text-gray-300 text-7xl mb-6"></i>
                    <h2 class="jewelry-serif text-2xl font-light text-gray-900 mb-3">Your Wishlist is Empty</h2>
                    <p class="text-gray-600 mb-8">
                        Save your favorite pieces here to easily find them later. Start exploring our collections!
                    </p>
                    <a href="{{ route('search') }}" 
                        class="inline-block bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                        Explore Collections
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
