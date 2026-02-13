{{-- Elegant Jewelry Product Card --}}
<div class="group relative">
    <a href="{{ route('product.show', $product) }}" class="block">
        {{-- Image --}}
        <div class="relative aspect-square bg-stone-100 mb-3 overflow-hidden">
            @if($product->thumbnail)
                @if(str_starts_with($product->thumbnail, 'http'))
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @endif
            @else
                <div class="w-full h-full flex items-center justify-center bg-stone-200 text-gray-400">
                    <i class="fas fa-gem text-4xl"></i>
                </div>
            @endif
            
            {{-- Sale Badge --}}
            @if($product->discount_price)
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1 uppercase tracking-wider">
                Sale
            </span>
            @endif

            {{-- Wishlist Button --}}
            @auth
                @php
                    $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->exists();
                @endphp
                <form method="POST" action="{{ route('buyer.wishlist.toggle', $product) }}" 
                    class="absolute top-3 left-3 z-10"
                    onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                    @csrf
                    <button type="submit" 
                        class="w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-md transition group/wishlist">
                        <i class="fas fa-heart {{ $isInWishlist ? 'text-red-500' : 'text-gray-400' }} group-hover/wishlist:text-red-500 transition"></i>
                    </button>
                </form>
            @endauth

            {{-- Quick View Overlay --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 flex items-center justify-center">
                <span class="text-white text-sm uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    View Details
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div>
            <h3 class="text-sm text-gray-800 mb-2 line-clamp-2 group-hover:text-amber-700 transition-colors">
                {{ $product->name }}
            </h3>

            {{-- Rating --}}
            @php $rating = $product->averageRating(); $reviewCount = $product->reviews->count(); @endphp
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
            <div class="flex items-center gap-2">
                <span class="text-gray-900 font-medium">₹{{ number_format($product->final_price, 0) }}</span>
                @if($product->discount_price)
                    <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
                @endif
            </div>
        </div>
    </a>

    {{-- Quick Add to Cart Button --}}
    @auth
    <div class="mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <form method="POST" action="{{ route('cart.add', $product) }}" onclick="event.stopPropagation();">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" 
                class="w-full bg-gray-900 text-white py-2 text-xs tracking-wider uppercase hover:bg-gray-800 transition {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $product->stock < 1 ? 'disabled' : '' }}>
                <i class="fas fa-shopping-bag mr-1"></i> Add to Cart
            </button>
        </form>
    </div>
    @endauth
</div>

