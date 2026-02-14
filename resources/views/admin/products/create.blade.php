@extends('layouts.dashboard')
@section('title', 'Add Product - Shiivaraa')
@section('page-title', 'Add New Product')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        {{-- Basic Information --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2 text-gray-800">Basic Information</h3>
            
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Product Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    placeholder="e.g., Citrine Money Magnet Stone">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Category *</label>
                    <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                        placeholder="e.g., Natural Crystals">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Description *</label>
                <textarea name="description" rows="5" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                    placeholder="Describe your money magnet stone, its properties, and benefits...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Pricing & Stock --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2 text-gray-800">Pricing & Stock</h3>
            
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Price (₹) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                        placeholder="999">
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Discount Price (₹)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                        placeholder="799">
                    <p class="text-xs text-gray-500 mt-1">Leave empty if no discount</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Stock Quantity *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                        placeholder="50">
                    @error('stock')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">SKU (Stock Keeping Unit)</label>
                <input type="text" name="sku" value="{{ old('sku') }}" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500"
                    placeholder="e.g., CIT-001">
                <p class="text-xs text-gray-500 mt-1">Optional: Unique identifier for inventory tracking</p>
            </div>
        </div>

        {{-- Images --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2 text-gray-800">Product Images</h3>
            
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Main Product Image (Thumbnail) *</label>
                <input type="file" name="thumbnail" accept="image/*" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500">
                <p class="text-xs text-gray-500 mt-1">This will be the main image shown in product listings</p>
                @error('thumbnail')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700">Additional Images (Optional)</label>
                <input type="file" name="images[]" accept="image/*" multiple 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500">
                <p class="text-xs text-gray-500 mt-1">You can upload up to 5 additional images</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3">
            <button type="submit" class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition font-medium">
                <i class="fas fa-save mr-2"></i>Add Product to Store
            </button>
            <a href="{{ route('admin.products') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
