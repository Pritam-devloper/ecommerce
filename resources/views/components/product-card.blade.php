{{-- Flipkart-style Product Card --}}
<div class="bg-white border border-gray-100 hover:shadow-xl transition-all duration-200 group relative">
    <a href="{{ route('product.show', $product) }}" class="block p-3">
        {{-- Image --}}
        <div class="relative h-44 flex items-center justify-center mb-2 overflow-hidden">
            @if($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                    class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                    <i class="fas fa-image text-4xl"></i>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="px-1">
            <h3 class="text-sm text-gray-700 mb-1 line-clamp-1 group-hover:text-flipblue">{{ $product->name }}</h3>

            {{-- Rating Badge --}}
            @php $rating = $product->averageRating(); $reviewCount = $product->reviews->count(); @endphp
            @if($reviewCount > 0)
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1 bg-green-700 text-white text-xs font-bold px-1.5 py-0.5 rounded-sm">
                    {{ number_format($rating, 1) }} <i class="fas fa-star text-[8px]"></i>
                </span>
                <span class="text-gray-400 text-xs font-medium">({{ $reviewCount }})</span>
            </div>
            @endif

            {{-- Price --}}
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-base font-bold text-gray-900">₹{{ number_format($product->final_price, 0) }}</span>
                @if($product->discount_price)
                    <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->price, 0) }}</span>
                    <span class="text-xs font-medium text-green-600">{{ $product->discount_percent }}% off</span>
                @endif
            </div>

            <p class="text-[11px] text-gray-400 mt-1">Free delivery</p>
        </div>
    </a>

    {{-- Quick Add to Cart (hover) --}}
    @auth
    <div class="absolute bottom-0 left-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity">
        <form method="POST" action="{{ route('cart.add', $product) }}">
            @csrf
            <button type="submit" class="w-full bg-flipyellow text-white py-2 text-xs font-bold uppercase tracking-wide hover:bg-yellow-600">
                <i class="fas fa-cart-plus mr-1"></i> Add to Cart
            </button>
        </form>
    </div>
    @endauth
</div>
