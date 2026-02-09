<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AbhiShop - Online Shopping')</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col" style="font-family: Roboto, Arial, sans-serif;">

    {{-- Flipkart-style Header --}}
    <header class="bg-flipblue sticky top-0 z-50 shadow-md">
        <div class="max-w-[1440px] mx-auto px-4">
            <div class="flex items-center h-14 gap-4">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0 flex flex-col items-center leading-none mr-2">
                    <span class="text-white text-xl font-bold italic tracking-tight">Abhi<span class="text-flipyellow">Shop</span></span>
                    <span class="flex items-center gap-0.5 text-[10px] text-yellow-300 italic -mt-0.5">
                        Explore <span class="text-yellow-200">Plus</span> <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/header/header_logo_plusYellow-ea498f.svg" class="h-2.5 w-auto ml-0.5 inline opacity-80" alt="">
                    </span>
                </a>

                {{-- Search Bar --}}
                <form action="{{ route('search') }}" method="GET" class="flex-1 max-w-2xl">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search for products, brands and more"
                            class="w-full pl-4 pr-12 py-2 rounded-sm text-sm focus:outline-none shadow-inner" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 h-full px-4 text-flipblue hover:text-flipdark">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                {{-- Nav Items --}}
                <nav class="hidden md:flex items-center gap-6 text-white text-sm font-medium ml-4">
                    @auth
                        {{-- Account Dropdown --}}
                        <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="flex items-center gap-1 hover:text-yellow-200 py-4">
                                <i class="fas fa-user text-xs"></i>
                                <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div x-show="open" x-cloak x-transition
                                class="absolute right-0 top-full w-60 bg-white rounded shadow-xl text-gray-700 text-sm z-50">
                                <div class="py-2">
                                    @if(auth()->user()->isBuyer())
                                        <a href="{{ route('buyer.profile') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-user w-5 text-center text-flipblue"></i>My Profile</a>
                                        <a href="{{ route('buyer.orders') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-box w-5 text-center text-flipblue"></i>Orders</a>
                                        <a href="{{ route('buyer.wishlist') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-heart w-5 text-center text-flipblue"></i>Wishlist</a>
                                        <a href="{{ route('buyer.addresses') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-map-marker-alt w-5 text-center text-flipblue"></i>Addresses</a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-tachometer-alt w-5 text-center text-flipblue"></i>Admin Panel</a>
                                    @endif
                                    @if(auth()->user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50"><i class="fas fa-store w-5 text-center text-flipblue"></i>Seller Dashboard</a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">@csrf
                                        <button class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 w-full text-left text-red-500"><i class="fas fa-power-off w-5 text-center"></i>Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->isBuyer())
                        {{-- Cart --}}
                        <a href="{{ route('cart') }}" class="flex items-center gap-1 hover:text-yellow-200 relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Cart</span>
                            @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1.5 -right-3 bg-flipyellow text-flipdark text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-flipblue px-8 py-1.5 rounded-sm font-bold text-sm hover:bg-gray-100">Login</a>
                        <a href="{{ route('seller.register') }}" class="hover:text-yellow-200">Become a Seller</a>
                    @endauth
                </nav>

                {{-- Mobile Menu --}}
                <button class="md:hidden text-white text-xl" x-data x-on:click="$dispatch('toggle-mobile-menu')">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile Slide Menu --}}
    <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open">
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 z-50" @click="open = false"></div>
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
            class="fixed left-0 top-0 h-full w-72 bg-white z-50 overflow-y-auto shadow-xl">
            <div class="bg-flipblue p-4 text-white">
                @auth
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-sm opacity-80">{{ auth()->user()->email }}</p>
                @else
                    <a href="{{ route('login') }}" class="font-medium">Login & Signup</a>
                @endauth
            </div>
            <nav class="py-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-home w-6 text-flipblue"></i>Home</a>
                <a href="{{ route('search') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-search w-6 text-flipblue"></i>All Products</a>
                @auth
                    <a href="{{ route('cart') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-shopping-cart w-6 text-flipblue"></i>My Cart</a>
                    <a href="{{ route('buyer.orders') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-box w-6 text-flipblue"></i>My Orders</a>
                    <a href="{{ route('buyer.wishlist') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-heart w-6 text-flipblue"></i>My Wishlist</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="block w-full text-left px-4 py-3 border-b hover:bg-gray-50 text-red-500"><i class="fas fa-power-off w-6"></i>Logout</button></form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-sign-in-alt w-6 text-flipblue"></i>Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 border-b hover:bg-gray-50"><i class="fas fa-user-plus w-6 text-flipblue"></i>Register</a>
                @endauth
            </nav>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-[1440px] mx-auto px-4 mt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded flex justify-between items-center text-sm">
                <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-700 text-lg">&times;</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-[1440px] mx-auto px-4 mt-3">
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-[1440px] mx-auto px-4 mt-3">
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Flipkart-style Footer --}}
    <footer class="bg-flipdark text-gray-400 text-xs mt-8">
        <div class="max-w-[1440px] mx-auto px-4 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pb-8 border-b border-gray-600">
                <div>
                    <h4 class="text-gray-300 font-medium text-sm mb-3 uppercase tracking-wider">About</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="{{ route('seller.register') }}" class="hover:text-white">Become a Seller</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 font-medium text-sm mb-3 uppercase tracking-wider">Help</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Payments</a></li>
                        <li><a href="#" class="hover:text-white">Shipping</a></li>
                        <li><a href="#" class="hover:text-white">Cancellation & Returns</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 font-medium text-sm mb-3 uppercase tracking-wider">Policy</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Return Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms Of Use</a></li>
                        <li><a href="#" class="hover:text-white">Security</a></li>
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-300 font-medium text-sm mb-3 uppercase tracking-wider">Connect</h4>
                    <div class="flex gap-4 text-lg mb-4">
                        <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                    <h4 class="text-gray-300 font-medium text-sm mb-2 uppercase tracking-wider">Mail Us</h4>
                    <p>support@abhishop.com</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between pt-6 gap-4">
                <div class="flex items-center gap-6 text-gray-500">
                    <span class="flex items-center gap-1"><i class="fas fa-store"></i> Sell On AbhiShop</span>
                    <span class="flex items-center gap-1"><i class="fas fa-star"></i> Advertise</span>
                    <span class="flex items-center gap-1"><i class="fas fa-gift"></i> Gift Cards</span>
                </div>
                <p>&copy; {{ date('Y') }} AbhiShop. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
