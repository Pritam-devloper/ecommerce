@extends('layouts.app')
@section('title', 'AbhiShop - Handcrafted Vintage Designer Jewellery')
@section('content')

<style>
    .jewelry-serif { font-family: 'Playfair Display', Georgia, serif; }
    .jewelry-sans { font-family: 'Montserrat', 'Roboto', sans-serif; }
</style>

{{-- Hero Section --}}
<section class="relative h-[70vh] min-h-[500px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1600');">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-6 md:px-12 text-white">
            <p class="text-sm md:text-base tracking-[0.3em] uppercase mb-4 text-amber-200">Unique Handcrafted</p>
            <h1 class="jewelry-serif text-4xl md:text-6xl lg:text-7xl font-light leading-tight mb-6">
                VINTAGE DESIGNER<br>JEWELLERY
            </h1>
            <a href="{{ route('search') }}" class="inline-block bg-white text-gray-900 px-8 py-3 text-sm tracking-wider uppercase hover:bg-amber-100 transition">
                Shop Now
            </a>
        </div>
    </div>
</section>

{{-- New Collections --}}
<section class="py-16 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-12">
            <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-800 mb-3">Look at our new collections</h2>
            <p class="text-gray-600 text-sm">Discover timeless pieces meticulously crafted with love and attention to detail</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories->take(3) as $cat)
            <a href="{{ route('category', $cat) }}" class="group relative overflow-hidden bg-white">
                <div class="aspect-[3/4] overflow-hidden">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @endif
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-white/95 p-6 text-center">
                    <h3 class="jewelry-serif text-xl font-light text-gray-800">{{ $cat->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Story Section --}}
<section class="py-20 bg-slate-700 text-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="aspect-square rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800" class="w-full h-full object-cover">
                </div>
            </div>
            <div>
                <p class="text-amber-300 text-sm tracking-[0.3em] uppercase mb-4">Our Story</p>
                <h2 class="jewelry-serif text-3xl md:text-4xl font-light mb-6">Amber Jewels, Handcrafted Elegance</h2>
                <p class="text-gray-300 leading-relaxed mb-4">
                    Each piece in our collection tells a story of timeless elegance and meticulous craftsmanship. From the initial sketch to the final polish, every detail is carefully considered to create jewellery that transcends trends.
                </p>
                <p class="text-gray-300 leading-relaxed mb-6">
                    Our artisans blend traditional techniques with contemporary design, ensuring each creation is as unique as the person who wears it.
                </p>
                <a href="{{ route('search') }}" class="inline-block border border-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-white hover:text-slate-700 transition">
                    Explore Collection
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Discover New Arrivals --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-12">
            <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-800 mb-3">Discover New Arrivals</h2>
            <p class="text-gray-600 text-sm">Handpicked pieces that define elegance and style</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($latest->take(4) as $product)
            <div class="group">
                <a href="{{ route('product.show', $product) }}" class="block">
                    <div class="aspect-square bg-stone-50 mb-4 overflow-hidden relative">
                        @if($product->thumbnail)
                            @if(str_starts_with($product->thumbnail, 'http'))
                                <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @endif
                        @else
                            <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                        @if($product->discount_price)
                        <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1">SALE</span>
                        @endif
                    </div>
                    <h3 class="jewelry-sans text-sm text-gray-800 mb-2">{{ $product->name }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-amber-700 font-medium">₹{{ number_format($product->final_price) }}</span>
                        @if($product->discount_price)
                        <span class="text-gray-400 text-sm line-through">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Limited Edition Banner --}}
<section class="relative h-[60vh] min-h-[400px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1603561591411-07134e71a2a9?w=1600');">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative h-full flex items-center justify-center text-center">
        <div class="max-w-2xl px-6">
            <p class="text-amber-300 text-sm tracking-[0.3em] uppercase mb-4">Limited Collection</p>
            <h2 class="jewelry-serif text-4xl md:text-5xl font-light text-white mb-6">
                LIMITED EDITION &<br>EXCLUSIVE
            </h2>
            <a href="{{ route('search') }}" class="inline-block bg-white text-gray-900 px-8 py-3 text-sm tracking-wider uppercase hover:bg-amber-100 transition">
                Shop Now
            </a>
        </div>
    </div>
</section>

{{-- Newsletter Section --}}
<section class="py-16 bg-slate-700 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="jewelry-serif text-3xl md:text-4xl font-light mb-4">Let's Stay in Touch</h2>
        <p class="text-gray-300 mb-8">Be the first to know about new collections and exclusive offers</p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-amber-300">
            <button type="submit" class="bg-amber-600 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-amber-700 transition">
                Subscribe
            </button>
        </form>
    </div>
</section>

{{-- Store Section --}}
<section class="py-16 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-800 mb-6">
                    We're Here for You, In<br>Person and Online
                </h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Visit our boutique to experience the beauty of our collections firsthand, or explore our complete range online from the comfort of your home. Our expert team is always ready to help you find the perfect piece.
                </p>
                <a href="{{ route('search') }}" class="inline-block border border-gray-800 text-gray-800 px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 hover:text-white transition">
                    Shop Online
                </a>
            </div>
            <div class="relative">
                <div class="aspect-[4/3] rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Categories --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories->take(3) as $cat)
            <a href="{{ route('category', $cat) }}" class="group relative overflow-hidden">
                <div class="aspect-[3/4] overflow-hidden bg-stone-100">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=600" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @endif
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                    <div class="text-white">
                        <h3 class="jewelry-serif text-2xl font-light mb-2">{{ $cat->name }}</h3>
                        <p class="text-sm text-gray-200">Explore Collection →</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Brand Footer --}}
<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="jewelry-serif text-6xl md:text-8xl font-light text-gray-800 mb-8 tracking-wider">AbhiShop</h2>
        <div class="flex justify-center gap-8 text-gray-600">
            <a href="#" class="hover:text-gray-900"><i class="fab fa-facebook-f text-xl"></i></a>
            <a href="#" class="hover:text-gray-900"><i class="fab fa-instagram text-xl"></i></a>
            <a href="#" class="hover:text-gray-900"><i class="fab fa-pinterest text-xl"></i></a>
            <a href="#" class="hover:text-gray-900"><i class="fab fa-twitter text-xl"></i></a>
        </div>
    </div>
</section>

@endsection
