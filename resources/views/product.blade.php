@extends('layouts.app')
@section('title', $product->name . ' - AETHER')
@section('content')

<div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center text-xs text-gray-500 mb-8 uppercase tracking-wider">
        <a href="{{ route('home') }}" class="hover:text-amber-700">Home</a>
        <i class="fas fa-chevron-right mx-3 text-[8px]"></i>
        <a href="{{ route('category', $product->category) }}" class="hover:text-amber-700">{{ $product->category->name }}</a>
        <i class="fas fa-chevron-right mx-3 text-[8px]"></i>
        <span class="text-gray-700">{{ Str::limit($product->name, 40) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        {{-- Left: Product Images --}}
        <div x-data="{ mainImage: '{{ $product->thumbnail ?? 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=800' }}' }">
            {{-- Main Image --}}
            <div class="bg-stone-100 flex items-center justify-center aspect-square mb-4 overflow-hidden sticky top-24">
                <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>

            {{-- Thumbnails --}}
            @if(($product->images && count($product->images)) || $product->thumbnail)
            <div class="flex gap-3">
                @if($product->thumbnail)
                <button @click="mainImage = '{{ $product->thumbnail }}'" 
                    class="w-20 h-20 bg-stone-100 overflow-hidden border-2 border-transparent hover:border-amber-600 focus:border-amber-600 transition">
                    <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover">
                </button>
                @endif
                @if($product->images)
                @foreach($product->images as $img)
                <button @click="mainImage = '{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}'" 
                    class="w-20 h-20 bg-stone-100 overflow-hidden border-2 border-transparent hover:border-amber-600 focus:border-amber-600 transition">
                    <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover">
                </button>
                @endforeach
                @endif
            </div>
            @endif
        </div>

        {{-- Right: Product Info --}}
        <div class="space-y-6">
            {{-- Title --}}
            <div>
                <h1 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-3">{{ $product->name }}</h1>
                
                {{-- Rating --}}
                @php $rating = $product->averageRating(); $rCount = $product->reviews->count(); @endphp
                @if($rCount > 0)
                <div class="flex items-center gap-2 text-sm">
                    <div class="flex text-amber-500">
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
                    <span class="text-gray-600">({{ $rCount }} {{ Str::plural('review', $rCount) }})</span>
                </div>
                @endif
            </div>

            {{-- Price --}}
            <div class="border-t border-b border-gray-200 py-6">
                <div class="flex items-baseline gap-3">
                    <span class="text-3xl font-medium text-gray-900">₹{{ number_format($product->final_price, 0) }}</span>
                    @if($product->discount_price)
                        <span class="text-xl text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
                        <span class="text-sm font-medium text-red-600 bg-red-50 px-2 py-1">{{ $product->discount_percent }}% OFF</span>
                    @endif
                </div>
            </div>

            {{-- Quantity Selector --}}
            <div x-data="{ quantity: 1 }">
                <label class="block text-sm text-gray-700 mb-2 uppercase tracking-wider">Quantity</label>
                <div class="flex items-center gap-3 mb-6">
                    <button @click="quantity = Math.max(1, quantity - 1)" 
                        class="w-10 h-10 border border-gray-300 hover:border-gray-400 flex items-center justify-center">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <input type="number" x-model="quantity" min="1" max="{{ $product->stock }}"
                        class="w-16 h-10 border border-gray-300 text-center focus:outline-none focus:border-amber-600">
                    <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" 
                        class="w-10 h-10 border border-gray-300 hover:border-gray-400 flex items-center justify-center">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                    <span class="text-sm text-gray-500 ml-2">
                        @if($product->stock > 0)
                            {{ $product->stock }} available
                        @else
                            Out of stock
                        @endif
                    </span>
                </div>

                {{-- Action Buttons --}}
                @auth
                <div class="space-y-3">
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <input type="hidden" name="quantity" :value="quantity">
                        <button type="submit" 
                            class="w-full bg-gray-900 text-white py-4 text-sm tracking-wider uppercase hover:bg-gray-800 transition {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                            {{ $product->stock < 1 ? 'disabled' : '' }}>
                            Add to Cart
                        </button>
                    </form>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <input type="hidden" name="quantity" :value="quantity">
                            <button type="submit" 
                                class="w-full border-2 border-gray-900 text-gray-900 py-4 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                {{ $product->stock < 1 ? 'disabled' : '' }}>
                                Buy Now
                            </button>
                        </form>

                        {{-- Wishlist Button --}}
                        @php
                            $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                ->where('product_id', $product->id)
                                ->exists();
                        @endphp
                        <form method="POST" action="{{ route('buyer.wishlist.toggle', $product) }}">
                            @csrf
                            <button type="submit" 
                                class="w-full border-2 {{ $isInWishlist ? 'border-red-500 text-red-500 bg-red-50' : 'border-gray-300 text-gray-700' }} py-4 text-sm tracking-wider uppercase hover:border-red-500 hover:text-red-500 hover:bg-red-50 transition">
                                <i class="fas fa-heart mr-2"></i>{{ $isInWishlist ? 'Saved' : 'Save' }}
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" 
                    class="block w-full bg-gray-900 text-white py-4 text-sm tracking-wider uppercase hover:bg-gray-800 transition text-center">
                    Login to Purchase
                </a>
                @endauth
            </div>

            {{-- Description --}}
            <div class="border-t border-gray-200 pt-6">
                <p class="text-gray-700 leading-relaxed mb-6">{{ $product->description }}</p>
                
                @if($product->brand)
                <p class="text-sm text-gray-600 mb-2">
                    <span class="font-medium">Brand:</span> {{ $product->brand }}
                </p>
                @endif
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Seller:</span> {{ $product->seller->shop_name ?? 'AETHER' }}
                </p>
            </div>

            {{-- Collapsible Sections --}}
            <div class="border-t border-gray-200">
                {{-- Materials --}}
                <div x-data="{ open: false }" class="border-b border-gray-200">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between py-4 text-left hover:text-amber-700 transition">
                        <span class="flex items-center gap-2 text-sm uppercase tracking-wider">
                            <i class="fas fa-gem text-amber-600"></i> Materials
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="pb-4 text-sm text-gray-600 leading-relaxed">
                        Crafted from premium materials including sterling silver, 18k gold plating, and ethically sourced gemstones. Each piece is carefully inspected for quality and durability.
                    </div>
                </div>

                {{-- Dimensions --}}
                <div x-data="{ open: false }" class="border-b border-gray-200">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between py-4 text-left hover:text-amber-700 transition">
                        <span class="flex items-center gap-2 text-sm uppercase tracking-wider">
                            <i class="fas fa-ruler text-amber-600"></i> Dimensions
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="pb-4 text-sm text-gray-600 leading-relaxed">
                        Please refer to the size guide for detailed measurements. Contact our customer service for personalized sizing assistance.
                    </div>
                </div>

                {{-- Care Instructions --}}
                <div x-data="{ open: false }" class="border-b border-gray-200">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between py-4 text-left hover:text-amber-700 transition">
                        <span class="flex items-center gap-2 text-sm uppercase tracking-wider">
                            <i class="fas fa-heart text-amber-600"></i> Care Instructions
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="pb-4 text-sm text-gray-600 leading-relaxed">
                        Store in a cool, dry place away from direct sunlight. Clean gently with a soft cloth. Avoid contact with perfumes, lotions, and harsh chemicals to maintain the piece's beauty.
                    </div>
                </div>

                {{-- Share --}}
                <div x-data="{ open: false }" class="border-b border-gray-200">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between py-4 text-left hover:text-amber-700 transition">
                        <span class="flex items-center gap-2 text-sm uppercase tracking-wider">
                            <i class="fas fa-share-alt text-amber-600"></i> Share
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="pb-4">
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 border border-gray-300 hover:border-amber-600 flex items-center justify-center transition">
                                <i class="fab fa-facebook-f text-gray-600"></i>
                            </a>
                            <a href="#" class="w-10 h-10 border border-gray-300 hover:border-amber-600 flex items-center justify-center transition">
                                <i class="fab fa-twitter text-gray-600"></i>
                            </a>
                            <a href="#" class="w-10 h-10 border border-gray-300 hover:border-amber-600 flex items-center justify-center transition">
                                <i class="fab fa-pinterest text-gray-600"></i>
                            </a>
                            <a href="#" class="w-10 h-10 border border-gray-300 hover:border-amber-600 flex items-center justify-center transition">
                                <i class="fas fa-envelope text-gray-600"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services --}}
            <div class="grid grid-cols-3 gap-4 pt-6 text-center text-xs">
                <div class="flex flex-col items-center gap-2">
                    <i class="fas fa-truck text-2xl text-amber-600"></i>
                    <span class="text-gray-700 uppercase tracking-wider">Free Shipping</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <i class="fas fa-undo text-2xl text-amber-600"></i>
                    <span class="text-gray-700 uppercase tracking-wider">Easy Returns</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <i class="fas fa-shield-alt text-2xl text-amber-600"></i>
                    <span class="text-gray-700 uppercase tracking-wider">Secure Payment</span>
                </div>
            </div>
        </div>
    </div>


    {{-- You May Also Like Section --}}
    @if($related->count())
    <section class="mt-16 pt-16 border-t border-gray-200">
        <h2 class="jewelry-serif text-3xl font-light text-gray-900 text-center mb-12">You May Also Like</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($related->take(4) as $relatedProduct)
            <div class="group">
                <a href="{{ route('product.show', $relatedProduct) }}" class="block">
                    <div class="aspect-square bg-stone-100 mb-4 overflow-hidden relative">
                        @if($relatedProduct->thumbnail)
                            @if(str_starts_with($relatedProduct->thumbnail, 'http'))
                                <img src="{{ $relatedProduct->thumbnail }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="{{ asset('storage/' . $relatedProduct->thumbnail) }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                        @else
                            <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                        @if($relatedProduct->discount_price)
                        <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1 uppercase tracking-wider">Sale</span>
                        @endif
                    </div>
                    <h3 class="text-sm text-gray-800 mb-2 group-hover:text-amber-700 transition">{{ $relatedProduct->name }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-900 font-medium">₹{{ number_format($relatedProduct->final_price) }}</span>
                        @if($relatedProduct->discount_price)
                        <span class="text-gray-400 text-sm line-through">₹{{ number_format($relatedProduct->price) }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Reviews Section --}}
    <section class="mt-16 pt-16 border-t border-gray-200">
        <h2 class="jewelry-serif text-3xl font-light text-gray-900 mb-8">Customer Reviews</h2>

        @auth
        <div class="bg-stone-50 p-6 mb-8">
            <h3 class="text-sm uppercase tracking-wider text-gray-700 mb-4">Write a Review</h3>
            <form method="POST" action="{{ route('review.store', $product) }}" class="space-y-4">
                @csrf
                <div class="flex items-center gap-4">
                    <label class="text-sm text-gray-700">Rating:</label>
                    <select name="rating" class="border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-amber-600">
                        <option value="5">★★★★★ Excellent</option>
                        <option value="4">★★★★☆ Good</option>
                        <option value="3">★★★☆☆ Average</option>
                        <option value="2">★★☆☆☆ Poor</option>
                        <option value="1">★☆☆☆☆ Terrible</option>
                    </select>
                </div>
                <div>
                    <textarea name="comment" rows="3" placeholder="Share your experience with this product..." 
                        class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-amber-600"></textarea>
                </div>
                <button type="submit" 
                    class="bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                    Submit Review
                </button>
            </form>
        </div>
        @else
        <div class="bg-stone-50 p-6 mb-8 text-center">
            <p class="text-gray-600 mb-4">Please log in to write a review</p>
            <a href="{{ route('login') }}" 
                class="inline-block border-2 border-gray-900 text-gray-900 px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-900 hover:text-white transition">
                Login
            </a>
        </div>
        @endauth

        <div class="space-y-6">
            @forelse($product->reviews as $review)
            <div class="border-b border-gray-200 pb-6 last:border-0">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="flex text-amber-500 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-sm"></i>
                                @else
                                    <i class="far fa-star text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $review->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
                @if($review->comment)
                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                @endif
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-star text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No reviews yet. Be the first to share your experience!</p>
            </div>
            @endforelse
        </div>
    </section>
</div>

@endsection
