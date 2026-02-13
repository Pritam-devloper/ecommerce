@extends('layouts.app')
@section('title', $category->name . ' - AETHER')
@section('content')

<div class="bg-stone-50 min-h-screen">
    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
            {{-- Breadcrumb --}}
            <div class="flex items-center text-xs text-gray-500 mb-4 uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-amber-700">Home</a>
                <i class="fas fa-chevron-right mx-3 text-[8px]"></i>
                <span class="text-gray-700">{{ $category->name }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-2">
                        {{ $category->name }}
                    </h1>
                    @if($category->description)
                    <p class="text-gray-600">{{ $category->description }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('piece', $products->total()) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Sidebar Filters --}}
            <aside class="lg:w-64 shrink-0">
                <div class="bg-white p-6 sticky top-24">
                    <h3 class="text-sm uppercase tracking-wider text-gray-900 font-medium mb-4">Refine By</h3>
                    
                    <form method="GET" action="{{ route('category', $category) }}" class="space-y-6">
                        {{-- Price Range --}}
                        <div class="pb-6 border-b border-gray-200">
                            <h4 class="text-sm text-gray-700 mb-3 font-medium">Price Range</h4>
                            <div class="space-y-2">
                                <div class="flex gap-2">
                                    <input type="number" 
                                        name="min_price" 
                                        value="{{ request('min_price') }}" 
                                        placeholder="Min" 
                                        class="w-full px-3 py-2 border border-gray-300 text-sm focus:outline-none focus:border-amber-600">
                                    <input type="number" 
                                        name="max_price" 
                                        value="{{ request('max_price') }}" 
                                        placeholder="Max" 
                                        class="w-full px-3 py-2 border border-gray-300 text-sm focus:outline-none focus:border-amber-600">
                                </div>
                            </div>
                        </div>

                        {{-- Brand --}}
                        @if($brands->count())
                        <div class="pb-6 border-b border-gray-200">
                            <h4 class="text-sm text-gray-700 mb-3 font-medium">Brand</h4>
                            <div class="space-y-2">
                                @foreach($brands as $brand)
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-amber-700">
                                    <input type="radio" 
                                        name="brand" 
                                        value="{{ $brand }}" 
                                        {{ request('brand') == $brand ? 'checked' : '' }}
                                        class="border-gray-300 text-amber-600 focus:ring-amber-600">
                                    {{ $brand }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Rating --}}
                        <div class="pb-6 border-b border-gray-200">
                            <h4 class="text-sm text-gray-700 mb-3 font-medium">Customer Rating</h4>
                            <div class="space-y-2">
                                @for($i = 4; $i >= 1; $i--)
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-amber-700">
                                    <input type="radio" 
                                        name="rating" 
                                        value="{{ $i }}" 
                                        {{ request('rating') == $i ? 'checked' : '' }}
                                        class="border-gray-300 text-amber-600 focus:ring-amber-600">
                                    <div class="flex text-amber-500 text-xs">
                                        @for($j = 1; $j <= $i; $j++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="text-gray-500">& up</span>
                                </label>
                                @endfor
                            </div>
                        </div>

                        {{-- Sort By --}}
                        <div class="pb-6">
                            <h4 class="text-sm text-gray-700 mb-3 font-medium">Sort By</h4>
                            <select name="sort" 
                                class="w-full px-3 py-2 border border-gray-300 text-sm focus:outline-none focus:border-amber-600">
                                <option value="">Relevance</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="space-y-2">
                            <button type="submit" 
                                class="w-full bg-gray-900 text-white py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                                Apply Filters
                            </button>
                            <a href="{{ route('category', $category) }}" 
                                class="block w-full text-center border border-gray-300 text-gray-700 py-3 text-sm hover:border-gray-400 transition">
                                Clear All
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Products Grid --}}
            <main class="flex-1">
                @if($products->count())
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white p-12 text-center">
                        <i class="fas fa-box-open text-gray-300 text-6xl mb-6"></i>
                        <h2 class="jewelry-serif text-2xl font-light text-gray-900 mb-3">No Products Found</h2>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any products matching your filters. Try adjusting your criteria.
                        </p>
                        <a href="{{ route('category', $category) }}" 
                            class="inline-block bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

@endsection
