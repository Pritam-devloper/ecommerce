@extends('layouts.dashboard')
@section('title', 'Manage Banners')
@section('page-title', 'Banners')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Add Banner -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="font-semibold mb-4">Add New Banner</h3>
    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data" class="grid md:grid-cols-4 gap-4 items-end">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded-lg px-4 py-2" placeholder="Banner Title">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Link URL</label>
            <input type="text" name="link" class="w-full border rounded-lg px-4 py-2" placeholder="https://...">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Image *</label>
            <input type="file" name="image" accept="image/*" required class="w-full border rounded-lg px-4 py-2">
        </div>
        <button class="bg-flipblue text-white py-2 rounded-lg hover:bg-blue-700 h-[42px]"><i class="fas fa-plus mr-2"></i>Add</button>
    </form>
</div>

<!-- Banners Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($banners as $banner)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="aspect-[16/6] bg-gray-100">
            <img src="{{ asset('storage/'.$banner->image) }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4 flex justify-between items-center">
            <div>
                <p class="font-medium">{{ $banner->title ?? 'No Title' }}</p>
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $banner->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $banner->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            <form method="POST" action="{{ route('admin.banners.delete', $banner) }}" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-8 text-gray-500">No banners yet.</div>
    @endforelse
</div>
@endsection
