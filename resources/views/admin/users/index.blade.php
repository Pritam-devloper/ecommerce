@extends('layouts.dashboard')
@section('title', 'Manage Users')
@section('page-title', 'Users')

@section('sidebar')
@include('admin.partials.sidebar')
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
