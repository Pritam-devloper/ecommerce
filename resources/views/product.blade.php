@extends('layouts.app')
@section('title', $product->name . ' - AbhiShop')
@section('content')
<div class="max-w-[1440px] mx-auto px-4 py-4">
    {{-- Breadcrumb --}}
    <div class="flex items-center text-xs text-gray-400 mb-3 bg-white p-3 rounded-sm shadow-sm">
        <a href="{{ route('home') }}" class="hover:text-flipblue">Home</a>
        <i class="fas fa-angle-right mx-2"></i>
        <a href="{{ route('category', $product->category) }}" class="hover:text-flipblue">{{ $product->category->name }}</a>
        <i class="fas fa-angle-right mx-2"></i>
        <span class="text-gray-600">{{ Str::limit($product->name, 50) }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Left: Product Images --}}
        <div class="bg-white rounded-sm shadow-sm p-4" x-data="{ mainImage: '{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : '' }}' }">
            <div class="border rounded-sm flex items-center justify-center h-[400px] mb-4 overflow-hidden">
                <template x-if="mainImage">
                    <img :src="mainImage" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain p-4">
                </template>
                <template x-if="!mainImage">
                    <div class="text-gray-300"><i class="fas fa-image text-7xl"></i></div>
                </template>
            </div>

            {{-- Thumbnails --}}
            @if(($product->images && count($product->images)) || $product->thumbnail)
            <div class="flex gap-2 overflow-x-auto scrollbar-hide">
                @if($product->thumbnail)
                <button @click="mainImage = '{{ asset('storage/' . $product->thumbnail) }}'" class="w-16 h-16 border-2 rounded-sm overflow-hidden shrink-0 hover:border-flipblue focus:border-flipblue">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-contain p-1">
                </button>
                @endif
                @if($product->images)
                @foreach($product->images as $img)
                <button @click="mainImage = '{{ asset('storage/' . $img) }}'" class="w-16 h-16 border-2 rounded-sm overflow-hidden shrink-0 hover:border-flipblue focus:border-flipblue">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-contain p-1">
                </button>
                @endforeach
                @endif
            </div>
            @endif

            {{-- Buttons --}}
            <div class="flex gap-3 mt-4">
                @auth
                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-flipyellow text-white py-4 rounded-sm font-bold text-base hover:bg-yellow-600 flex items-center justify-center gap-2 {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->stock < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i> ADD TO CART
                    </button>
                </form>
                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-fliporange text-white py-4 rounded-sm font-bold text-base hover:bg-orange-600 flex items-center justify-center gap-2 {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->stock < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-bolt"></i> BUY NOW
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="flex-1 bg-flipyellow text-white py-4 rounded-sm font-bold text-base hover:bg-yellow-600 text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Buy
                </a>
                @endauth
            </div>
        </div>

        {{-- Right: Product Info --}}
        <div class="space-y-3">
            <div class="bg-white rounded-sm shadow-sm p-5">
                <h1 class="text-lg text-gray-700 font-medium leading-snug mb-2">{{ $product->name }}</h1>

                {{-- Rating --}}
                <div class="flex items-center gap-3 mb-3">
                    @php $rating = $product->averageRating(); $rCount = $product->reviews->count(); @endphp
                    @if($rCount > 0)
                    <span class="inline-flex items-center gap-1 bg-flipgreen text-white text-sm font-bold px-2 py-0.5 rounded-sm">
                        {{ number_format($rating, 1) }} <i class="fas fa-star text-[10px]"></i>
                    </span>
                    <span class="text-gray-400 text-sm">{{ $rCount }} Ratings & Reviews</span>
                    @endif
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <span class="text-3xl font-bold text-gray-900">₹{{ number_format($product->final_price, 0) }}</span>
                    @if($product->discount_price)
                        <span class="text-lg text-gray-400 line-through ml-2">₹{{ number_format($product->price, 0) }}</span>
                        <span class="text-base font-medium text-flipgreen ml-2">{{ $product->discount_percent }}% off</span>
                    @endif
                </div>

                {{-- Stock --}}
                <p class="text-sm mb-2">
                    @if($product->stock > 0)
                        <span class="text-flipgreen font-medium"><i class="fas fa-check-circle mr-1"></i>In Stock</span>
                        <span class="text-gray-400 ml-1">({{ $product->stock }} available)</span>
                    @else
                        <span class="text-red-500 font-medium"><i class="fas fa-times-circle mr-1"></i>Out of Stock</span>
                    @endif
                </p>

                @if($product->brand)
                <p class="text-sm text-gray-600"><span class="text-gray-400">Brand:</span> <span class="font-medium">{{ $product->brand }}</span></p>
                @endif
                <p class="text-sm text-gray-600"><span class="text-gray-400">Seller:</span> <span class="font-medium text-flipblue">{{ $product->seller->shop_name ?? 'AbhiShop' }}</span></p>
            </div>

            {{-- Offers --}}
            <div class="bg-white rounded-sm shadow-sm p-5">
                <h3 class="font-bold text-sm text-gray-900 mb-3">Available Offers</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><i class="fas fa-tag text-flipgreen mr-2"></i><span class="font-medium">Bank Offer:</span> 10% off on HDFC Credit Card</p>
                    <p><i class="fas fa-tag text-flipgreen mr-2"></i><span class="font-medium">Special Price:</span> Get extra discount on orders above ₹1000</p>
                    <p><i class="fas fa-tag text-flipgreen mr-2"></i><span class="font-medium">Free Delivery:</span> On orders above ₹500</p>
                </div>
            </div>

            {{-- Delivery & Services --}}
            <div class="bg-white rounded-sm shadow-sm p-5">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center text-sm">
                    <div class="flex flex-col items-center gap-1">
                        <i class="fas fa-truck text-flipblue text-xl"></i>
                        <span class="text-gray-600 font-medium">Free Delivery</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <i class="fas fa-undo text-flipblue text-xl"></i>
                        <span class="text-gray-600 font-medium">7 Day Return</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <i class="fas fa-money-bill-wave text-flipblue text-xl"></i>
                        <span class="text-gray-600 font-medium">Cash on Delivery</span>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="bg-white rounded-sm shadow-sm p-5">
                <h3 class="font-bold text-gray-900 mb-3">Product Description</h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="mt-4 bg-white rounded-sm shadow-sm p-5">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Ratings & Reviews</h2>

        @auth
        <div class="border-b pb-5 mb-5">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Rate this product</h3>
            <form method="POST" action="{{ route('review.store', $product) }}" class="space-y-3">
                @csrf
                <div class="flex items-center gap-3">
                    <select name="rating" class="border rounded-sm px-3 py-2 text-sm">
                        <option value="5">★★★★★ Excellent</option>
                        <option value="4">★★★★ Good</option>
                        <option value="3">★★★ Average</option>
                        <option value="2">★★ Poor</option>
                        <option value="1">★ Bad</option>
                    </select>
                    <input type="text" name="comment" placeholder="Describe your experience (optional)" class="flex-1 border rounded-sm px-3 py-2 text-sm">
                    <button type="submit" class="bg-flipblue text-white px-5 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">SUBMIT</button>
                </div>
            </form>
        </div>
        @endauth

        <div class="space-y-4">
            @forelse($product->reviews as $review)
            <div class="border-b pb-4 last:border-0">
                <div class="flex items-center gap-3 mb-2">
                    <span class="inline-flex items-center gap-1 text-xs font-bold px-1.5 py-0.5 rounded-sm text-white {{ $review->rating >= 4 ? 'bg-flipgreen' : ($review->rating >= 3 ? 'bg-yellow-500' : 'bg-red-500') }}">
                        {{ $review->rating }} <i class="fas fa-star text-[8px]"></i>
                    </span>
                    @if($review->comment)<span class="text-sm text-gray-700">{{ $review->comment }}</span>@endif
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <span class="font-medium text-gray-600">{{ $review->user->name }}</span>
                    <span>•</span>
                    <span>{{ $review->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm py-4">No reviews yet. Be the first to review this product!</p>
            @endforelse
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mt-4 bg-white rounded-sm shadow-sm p-4">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Similar Products</h2>
        <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2">
            @foreach($related as $product)
            <div class="min-w-[180px] max-w-[200px] shrink-0">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
