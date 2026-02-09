@extends('layouts.app')
@section('title', $category->name . ' - AbhiShop')
@section('content')
<div class="max-w-[1440px] mx-auto px-4 py-4">
    {{-- Breadcrumb --}}
    <div class="flex items-center text-xs text-gray-400 mb-3">
        <a href="{{ route('home') }}" class="hover:text-flipblue">Home</a>
        <i class="fas fa-angle-right mx-2"></i>
        <span class="text-gray-600 font-medium">{{ $category->name }}</span>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        {{-- Filters Sidebar --}}
        <aside class="w-full md:w-64 shrink-0">
            <div class="bg-white rounded-sm shadow-sm sticky top-16">
                <div class="px-4 py-3 border-b">
                    <h3 class="text-sm font-bold text-gray-900 uppercase">Filters</h3>
                </div>
                <form method="GET" action="{{ route('category', $category) }}" class="p-4 space-y-4">
                    {{-- Price --}}
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 uppercase mb-2">Price Range</h4>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-2 py-1.5 border rounded-sm text-sm">
                            <span class="text-gray-400 self-center">to</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full px-2 py-1.5 border rounded-sm text-sm">
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 uppercase mb-2">Customer Rating</h4>
                        @for($i = 4; $i >= 1; $i--)
                        <label class="flex items-center gap-2 text-sm py-1 cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" {{ request('rating') == $i ? 'checked' : '' }} class="text-flipblue focus:ring-flipblue">
                            <span class="inline-flex items-center gap-0.5 text-xs">{{ $i }}<i class="fas fa-star text-flipgreen"></i> & above</span>
                        </label>
                        @endfor
                    </div>

                    {{-- Brand --}}
                    @if($brands->count())
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 uppercase mb-2">Brand</h4>
                        <select name="brand" class="w-full px-2 py-1.5 border rounded-sm text-sm">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Sort --}}
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 uppercase mb-2">Sort By</h4>
                        <select name="sort" class="w-full px-2 py-1.5 border rounded-sm text-sm">
                            <option value="">Relevance</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price -- Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price -- High to Low</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popularity</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-flipblue text-white py-2 rounded-sm text-sm font-bold hover:bg-blue-700">APPLY</button>
                    <a href="{{ route('category', $category) }}" class="block text-center text-xs text-flipblue hover:underline">Clear All</a>
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1">
            <div class="bg-white rounded-sm shadow-sm p-4 mb-3 flex items-center justify-between">
                <h1 class="text-lg font-bold text-gray-900">{{ $category->name }}</h1>
                <span class="text-xs text-gray-400">(Showing {{ $products->count() }} of {{ $products->total() }} products)</span>
            </div>

            @if($products->count())
                <div class="bg-white rounded-sm shadow-sm p-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    <div class="mt-6">{{ $products->links() }}</div>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-sm shadow-sm">
                    <i class="fas fa-box-open text-gray-200 text-5xl mb-3"></i>
                    <p class="text-gray-500">No products found in this category.</p>
                    <a href="{{ route('home') }}" class="mt-3 inline-block text-flipblue text-sm font-medium hover:underline">Browse other categories</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
