<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shiivaraa - Money Magnet Stones & Spiritual Crystals')</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('logo.jpg') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo.jpg') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        flipblue: '#2874f0',
                        flipdark: '#172b4d',
                        flipyellow: '#ff9f00',
                        flipgreen: '#388e3c',
                        fliporange: '#fb641b',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .jewelry-serif { font-family: 'Playfair Display', Georgia, serif; }
        .jewelry-sans { font-family: 'Montserrat', 'Roboto', sans-serif; }
        
        /* Animated Logo Shimmer */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .logo-shimmer {
            background: linear-gradient(90deg, #d97706 0%, #fbbf24 50%, #f59e0b 75%, #d97706 100%);
            background-size: 1000px 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s infinite linear;
        }
        
        /* Pulse animation for logo */
        @keyframes pulse-glow {
            0%, 100% { text-shadow: 0 0 10px rgba(217, 119, 6, 0.3); }
            50% { text-shadow: 0 0 20px rgba(217, 119, 6, 0.6); }
        }
        
        .logo-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-stone-50 min-h-screen flex flex-col jewelry-sans" style="font-family: 'Montserrat', 'Roboto', Arial, sans-serif;">

    {{-- Elegant Jewelry Header --}}
    <header class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-200">
        {{-- Top Bar --}}
        <div class="bg-slate-700 text-white text-xs">
            <div class="max-w-7xl mx-auto px-6 py-2 flex justify-between items-center">
                <div class="flex items-center gap-6">
                    <span class="hidden sm:inline"><i class="fas fa-phone-alt mr-2"></i>+91 1800-123-4567</span>
                    <span class="hidden md:inline"><i class="fas fa-envelope mr-2"></i>support@AbhiShop.com</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-amber-300 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-amber-300 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-amber-300 transition"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>

        {{-- Main Navigation --}}
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex flex-col leading-none group">
                    <span class="jewelry-serif text-3xl font-light tracking-wider logo-shimmer transition-all duration-300 group-hover:scale-105">
                        Shiivaraa
                    </span>
                    <span class="text-[9px] tracking-widest text-gray-500 uppercase">Crystal & gems stone</span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-8 text-sm tracking-wider uppercase">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-amber-700 transition font-medium">Home</a>
                    <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-gray-700 hover:text-amber-700 transition font-medium flex items-center gap-1">
                            Collections <i class="fas fa-chevron-down text-[10px]"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition
                            class="absolute top-full left-0 mt-2 w-56 bg-white shadow-xl border border-gray-100">
                            <div class="py-2">
                                @if(isset($categories))
                                    @foreach($categories->take(6) as $cat)
                                        <a href="{{ route('category', $cat) }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition">{{ $cat->name }}</a>
                                    @endforeach
                                @endif
                                <a href="{{ route('search') }}" class="block px-6 py-3 text-amber-700 font-medium hover:bg-stone-50 transition">View All →</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('search') }}" class="text-gray-700 hover:text-amber-700 transition font-medium">Shop</a>
                    <a href="#" class="text-gray-700 hover:text-amber-700 transition font-medium">About</a>
                    <a href="#" class="text-gray-700 hover:text-amber-700 transition font-medium">Contact</a>
                </nav>

                {{-- Right Icons --}}
                <div class="flex items-center gap-6">
                    {{-- Search Icon --}}
                    <button x-data x-on:click="$dispatch('toggle-search')" class="text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    @auth
                        {{-- Account Dropdown --}}
                        <div x-data="{ open: false }" class="relative hidden md:block" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="text-gray-700 hover:text-amber-700 transition">
                                <i class="fas fa-user text-lg"></i>
                            </button>
                            <div x-show="open" x-cloak x-transition
                                class="absolute right-0 top-full mt-2 w-56 bg-white shadow-xl border border-gray-100">
                                <div class="py-2">
                                    <div class="px-6 py-3 border-b border-gray-100">
                                        <p class="font-medium text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    @if(auth()->user()->isBuyer())
                                        <a href="{{ route('buyer.profile') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">My Profile</a>
                                        <a href="{{ route('buyer.orders') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">Orders</a>
                                        <a href="{{ route('buyer.wishlist') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">Wishlist</a>
                                        <a href="{{ route('buyer.addresses') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">Addresses</a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">Admin Panel</a>
                                    @endif
                                    @if(auth()->user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-stone-50 hover:text-amber-700 transition text-sm">Seller Dashboard</a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">@csrf
                                        <button class="block w-full text-left px-6 py-3 text-red-600 hover:bg-stone-50 transition text-sm">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->isBuyer())
                        {{-- Wishlist --}}
                        <a href="{{ route('buyer.wishlist') }}" class="text-gray-700 hover:text-amber-700 transition hidden md:block">
                            <i class="fas fa-heart text-lg"></i>
                        </a>

                        {{-- Cart --}}
                        <a href="{{ route('cart') }}" class="text-gray-700 hover:text-amber-700 transition relative">
                            <i class="fas fa-shopping-bag text-lg"></i>
                            @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-amber-600 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-700 transition hidden md:block">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                        <a href="{{ route('cart') }}" class="text-gray-700 hover:text-amber-700 transition">
                            <i class="fas fa-shopping-bag text-lg"></i>
                        </a>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button class="lg:hidden text-gray-700 text-xl" x-data x-on:click="$dispatch('toggle-mobile-menu')">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Search Overlay with Live Suggestions --}}
    <div x-data="{ 
        open: false, 
        query: '', 
        suggestions: [],
        recentSearches: [],
        loading: false,
        async loadRecentSearches() {
            try {
                const response = await fetch('/api/recent-searches');
                const data = await response.json();
                this.recentSearches = data;
            } catch (error) {
                console.error('Error loading recent searches:', error);
            }
        },
        async searchSuggestions() {
            if (this.query.length < 2) {
                this.suggestions = [];
                return;
            }
            this.loading = true;
            try {
                const response = await fetch(`/api/search-suggestions?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                this.suggestions = data;
            } catch (error) {
                console.error('Search error:', error);
            }
            this.loading = false;
        }
    }" 
    @toggle-search.window="open = !open; if(open) { $nextTick(() => { $refs.searchInput.focus(); loadRecentSearches(); }) }">
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/70 z-50 flex items-start justify-center pt-20" @click="open = false">
            <div class="w-full max-w-3xl px-6" @click.stop>
                {{-- Search Box --}}
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <div class="flex items-center px-6 py-4 border-b">
                            <i class="fas fa-search text-gray-400 text-xl mr-4"></i>
                            <input 
                                type="text" 
                                name="q" 
                                x-ref="searchInput"
                                x-model="query"
                                @input.debounce.300ms="searchSuggestions()"
                                value="{{ request('q') }}" 
                                placeholder="Search for crystals, gemstones, money magnets..."
                                class="flex-1 text-lg focus:outline-none"
                                autocomplete="off">
                            <button type="submit" class="ml-4 bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition text-sm font-medium">
                                Search
                            </button>
                        </div>
                    </form>
                    
                    {{-- Live Suggestions --}}
                    <div x-show="suggestions.length > 0 || loading" class="max-h-96 overflow-y-auto">
                        {{-- Loading State --}}
                        <div x-show="loading" class="p-8 text-center">
                            <i class="fas fa-spinner fa-spin text-amber-600 text-2xl"></i>
                            <p class="text-gray-500 mt-2 text-sm">Searching...</p>
                        </div>
                        
                        {{-- Products --}}
                        <div x-show="!loading && suggestions.products && suggestions.products.length > 0">
                            <div class="px-6 py-3 bg-gray-50 border-b">
                                <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Available Products</h3>
                            </div>
                            <template x-for="product in suggestions.products" :key="product.id">
                                <a :href="product.url" class="flex items-center gap-4 px-6 py-3 hover:bg-stone-50 transition border-b border-gray-100">
                                    <img :src="product.image" :alt="product.name" class="w-12 h-12 object-cover rounded">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900" x-text="product.name"></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500" x-text="product.category"></span>
                                            <span class="text-xs text-green-600 font-medium" x-text="'• ' + product.stock + ' in stock'"></span>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-amber-600" x-text="'₹' + product.price"></p>
                                </a>
                            </template>
                        </div>
                        
                        {{-- Categories --}}
                        <div x-show="!loading && suggestions.categories && suggestions.categories.length > 0">
                            <div class="px-6 py-3 bg-gray-50 border-b">
                                <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Categories</h3>
                            </div>
                            <template x-for="category in suggestions.categories" :key="category.id">
                                <a :href="category.url" class="flex items-center gap-3 px-6 py-3 hover:bg-stone-50 transition border-b border-gray-100">
                                    <i class="fas fa-tag text-amber-600"></i>
                                    <span class="text-gray-900" x-text="category.name"></span>
                                    <span class="text-xs text-gray-500" x-text="category.count + ' available'"></span>
                                </a>
                            </template>
                        </div>
                        
                        {{-- No Results --}}
                        <div x-show="!loading && suggestions.products && suggestions.products.length === 0 && query.length >= 2" class="p-8 text-center">
                            <i class="fas fa-search text-gray-300 text-3xl mb-3"></i>
                            <p class="text-gray-600">No available products found for "<span x-text="query"></span>"</p>
                            <p class="text-sm text-gray-500 mt-2">Try different keywords or check back later</p>
                        </div>
                    </div>
                    
                    {{-- Recent & Popular Searches --}}
                    <div x-show="query.length === 0" class="p-6 space-y-6">
                        {{-- Recent Searches --}}
                        <div x-show="recentSearches.length > 0">
                            <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i class="fas fa-history"></i>
                                Recent Searches
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="search in recentSearches" :key="search">
                                    <a :href="`{{ route('search') }}?q=${encodeURIComponent(search)}`" 
                                        class="px-4 py-2 bg-stone-100 hover:bg-stone-200 rounded-full text-sm text-gray-700 transition flex items-center gap-2">
                                        <i class="fas fa-clock text-xs text-gray-400"></i>
                                        <span x-text="search"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                        
                        {{-- Popular Searches --}}
                        <div>
                            <h3 class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i class="fas fa-fire"></i>
                                Popular Searches
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('search', ['q' => 'citrine']) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 rounded-full text-sm text-gray-700 transition">Citrine</a>
                                <a href="{{ route('search', ['q' => 'pyrite']) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 rounded-full text-sm text-gray-700 transition">Pyrite</a>
                                <a href="{{ route('search', ['q' => 'green aventurine']) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 rounded-full text-sm text-gray-700 transition">Green Aventurine</a>
                                <a href="{{ route('search', ['q' => 'tiger eye']) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 rounded-full text-sm text-gray-700 transition">Tiger's Eye</a>
                                <a href="{{ route('search', ['q' => 'money magnet']) }}" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 rounded-full text-sm text-gray-700 transition">Money Magnet</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Close Button --}}
                <button @click="open = false" class="absolute top-4 right-4 text-white text-3xl hover:text-amber-300 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Slide Menu --}}
    <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open">
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 z-50" @click="open = false"></div>
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
            class="fixed left-0 top-0 h-full w-80 bg-white z-50 overflow-y-auto shadow-2xl">
            <div class="bg-slate-700 p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="jewelry-serif text-2xl">AbhiShop</h3>
                    <button @click="open = false" class="text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @auth
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-sm opacity-80">{{ auth()->user()->email }}</p>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-amber-600 text-white px-6 py-2 text-sm tracking-wider uppercase hover:bg-amber-700 transition">Login</a>
                @endauth
            </div>
            <nav class="py-4">
                <a href="{{ route('home') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                    <i class="fas fa-home w-6 text-amber-600"></i>Home
                </a>
                <a href="{{ route('search') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                    <i class="fas fa-gem w-6 text-amber-600"></i>Shop All
                </a>
                
                @if(isset($categories) && $categories->count())
                <div class="border-b border-gray-100">
                    <div class="px-6 py-3 bg-stone-50 text-xs uppercase tracking-wider text-gray-600 font-medium">Collections</div>
                    @foreach($categories->take(5) as $cat)
                        <a href="{{ route('category', $cat) }}" class="block px-6 py-3 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition text-sm">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                @auth
                    <a href="{{ route('cart') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-shopping-bag w-6 text-amber-600"></i>My Cart
                    </a>
                    <a href="{{ route('buyer.orders') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-box w-6 text-amber-600"></i>My Orders
                    </a>
                    <a href="{{ route('buyer.wishlist') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-heart w-6 text-amber-600"></i>My Wishlist
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                            <i class="fas fa-tachometer-alt w-6 text-amber-600"></i>Admin Panel
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button class="block w-full text-left px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-red-600 transition">
                            <i class="fas fa-power-off w-6"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-sign-in-alt w-6 text-amber-600"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-6 py-4 border-b border-gray-100 hover:bg-stone-50 text-gray-700 hover:text-amber-700 transition">
                        <i class="fas fa-user-plus w-6 text-amber-600"></i>Register
                    </a>
                @endauth
            </nav>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded flex justify-between items-center">
                <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-800 text-xl hover:text-green-900">&times;</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Elegant Footer --}}
    <footer class="bg-slate-800 text-gray-300 text-sm">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-slate-700">
                <div>
                    <h3 class="jewelry-serif text-2xl text-white mb-2 logo-shimmer">Shiivaraa</h3>
                    <p class="text-xs text-amber-400 uppercase tracking-wider mb-4">Crystal & gems stone Marketplace</p>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Your trusted marketplace for authentic Crystal & gems stone, healing crystals, and spiritual gemstones from verified sellers worldwide.
                    </p>
                    <div class="flex gap-4 text-lg">
                        <a href="#" class="hover:text-amber-400 transition transform hover:scale-110"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-amber-400 transition transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-amber-400 transition transform hover:scale-110"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="hover:text-amber-400 transition transform hover:scale-110"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-6 uppercase tracking-wider text-xs">Shop</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('search') }}" class="hover:text-amber-400 transition">All Collections</a></li>
                        <li><a href="{{ route('search') }}?sort=newest" class="hover:text-amber-400 transition">New Arrivals</a></li>
                        <li><a href="{{ route('search') }}?sort=popular" class="hover:text-amber-400 transition">Best Sellers</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Limited Edition</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-6 uppercase tracking-wider text-xs">Customer Care</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-amber-400 transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Shipping & Returns</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Size Guide</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Care Instructions</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-medium mb-6 uppercase tracking-wider text-xs">About</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-amber-400 transition">Our Story</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Craftsmanship</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Authenticity</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between pt-8 gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} AbhiShop. All rights reserved. Handcrafted with love.</p>
                <div class="flex items-center gap-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-6 opacity-60" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6 opacity-60" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-6 opacity-60" alt="PayPal">
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
