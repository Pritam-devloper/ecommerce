<div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider" x-show="sidebarOpen">My Store</div>
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-tachometer-alt w-8"></i>
    <span x-show="sidebarOpen">Dashboard</span>
</a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.products*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-gem w-8"></i>
    <span x-show="sidebarOpen">My Products</span>
</a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-tags w-8"></i>
    <span x-show="sidebarOpen">Categories</span>
</a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-shopping-bag w-8"></i>
    <span x-show="sidebarOpen">Orders</span>
</a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.banners*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-image w-8"></i>
    <span x-show="sidebarOpen">Banners</span>
</a>

<div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider mt-4" x-show="sidebarOpen">Management</div>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-users w-8"></i>
    <span x-show="sidebarOpen">Customers</span>
</a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-cog w-8"></i>
    <span x-show="sidebarOpen">Settings</span>
</a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports*') ? 'text-white bg-amber-600' : 'text-gray-300 hover:bg-white/10' }}">
    <i class="fas fa-chart-line w-8"></i>
    <span x-show="sidebarOpen">Reports</span>
</a>
