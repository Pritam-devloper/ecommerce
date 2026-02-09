@extends('layouts.dashboard')
@section('title', 'Manage Users')
@section('page-title', 'Users')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">User</th><th class="p-4">Email</th><th class="p-4">Role</th><th class="p-4">Joined</th><th class="p-4">Status</th><th class="p-4">Action</th></tr></thead>
        <tbody>
        @foreach($users as $user)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-medium">{{ $user->name }}</td>
            <td class="p-4 text-gray-500">{{ $user->email }}</td>
            <td class="p-4"><span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'seller' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">{{ ucfirst($user->role) }}</span></td>
            <td class="p-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
            <td class="p-4"><span class="px-2 py-1 rounded text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Active' : 'Blocked' }}</span></td>
            <td class="p-4">
                @if($user->role !== 'admin')
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf @method('PATCH')
                    <button class="text-sm {{ $user->is_active ? 'text-red-600' : 'text-green-600' }} hover:underline">{{ $user->is_active ? 'Block' : 'Unblock' }}</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
