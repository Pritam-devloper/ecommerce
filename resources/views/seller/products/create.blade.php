@extends('layouts.dashboard')
@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Basic Information</h3>
            <div>
                <label class="block text-sm font-medium mb-1">Product Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-flipblue">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Category *</label>
                    <select name="category_id" required class="w-full border rounded-lg px-4 py-2">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description *</label>
                <textarea name="description" rows="5" required class="w-full border rounded-lg px-4 py-2">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Pricing & Stock</h3>
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Price (₹) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full border rounded-lg px-4 py-2">
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Discount Price (₹)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full border rounded-lg px-4 py-2">
                    @error('stock')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">SKU</label>
                <input type="text" name="sku" value="{{ old('sku') }}" class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Images</h3>
            <div>
                <label class="block text-sm font-medium mb-1">Thumbnail *</label>
                <input type="file" name="thumbnail" accept="image/*" required class="w-full border rounded-lg px-4 py-2">
                @error('thumbnail')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Additional Images (Max 5)</label>
                <input type="file" name="images[]" accept="image/*" multiple class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-save mr-2"></i>Save Product</button>
            <a href="{{ route('seller.products') }}" class="bg-gray-200 px-6 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
@endsection
