@extends('layouts.dashboard')
@section('title', 'Manage Sellers')
@section('page-title', 'Sellers')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<!-- Tab Filters -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.sellers') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">All</a>
    @foreach(['pending','approved','suspended'] as $s)
    <a href="{{ route('admin.sellers', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === $s ? 'bg-flipblue text-white' : 'bg-white text-gray-600' }}">{{ ucfirst($s) }}</a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Shop</th><th class="p-4">Owner</th><th class="p-4">Products</th><th class="p-4">Balance</th><th class="p-4">Commission</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr></thead>
        <tbody>
        @forelse($sellers as $seller)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-100 rounded-full overflow-hidden shrink-0">
                        @if($seller->logo)<img src="{{ asset('storage/'.$seller->logo) }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-store"></i></div>@endif
                    </div>
                    <span class="font-medium">{{ $seller->shop_name }}</span>
                </div>
            </td>
            <td class="p-4 text-gray-500">{{ $seller->user->name }}</td>
            <td class="p-4">{{ $seller->products->count() }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($seller->balance, 0) }}</td>
            <td class="p-4">{{ $seller->commission_rate }}%</td>
            <td class="p-4">
                @php $c = ['pending'=>'yellow','approved'=>'green','suspended'=>'red']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $c[$seller->status] }}-100 text-{{ $c[$seller->status] }}-700">{{ ucfirst($seller->status) }}</span>
            </td>
            <td class="p-4">
                <div class="flex gap-2">
                    @if($seller->status === 'pending')
                    <form method="POST" action="{{ route('admin.sellers.approve', $seller) }}">@csrf @method('PATCH')<button class="text-green-600 hover:underline text-sm">Approve</button></form>
                    @endif
                    @if($seller->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.sellers.suspend', $seller) }}">@csrf @method('PATCH')<button class="text-red-600 hover:underline text-sm">Suspend</button></form>
                    @else
                    <form method="POST" action="{{ route('admin.sellers.approve', $seller) }}">@csrf @method('PATCH')<button class="text-green-600 hover:underline text-sm">Reactivate</button></form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="p-8 text-center text-gray-500">No sellers found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $sellers->links() }}</div>
@endsection
