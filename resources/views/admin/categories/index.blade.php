@extends('layouts.dashboard')
@section('title', 'Manage Categories')
@section('page-title', 'Categories')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Add Category -->
    <div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Add Category</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-4 py-2">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Parent Category</label>
                    <select name="parent_id" class="w-full border rounded-lg px-4 py-2">
                        <option value="">None (Top Level)</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                </div>
                <button class="w-full bg-flipblue text-white py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-plus mr-2"></i>Add Category</button>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Category</th><th class="p-4">Parent</th><th class="p-4">Products</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr></thead>
                <tbody>
                @forelse($categories as $cat)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            @if($cat->image)<div class="w-8 h-8 rounded overflow-hidden shrink-0"><img src="{{ asset('storage/'.$cat->image) }}" class="w-full h-full object-cover"></div>@endif
                            <span class="font-medium">{{ $cat->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-500">{{ $cat->parent->name ?? '-' }}</td>
                    <td class="p-4">{{ $cat->products->count() }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded text-xs font-semibold {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('admin.categories.delete', $cat) }}" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">No categories yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
