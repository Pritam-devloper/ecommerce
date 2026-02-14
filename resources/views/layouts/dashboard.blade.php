<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100" style="font-family: Roboto, Arial, sans-serif;" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-60' : 'w-16'" class="bg-flipdark text-white transition-all duration-300 fixed h-full z-40">
            <div class="h-14 flex items-center justify-between px-4 border-b border-white/10">
                <a href="{{ route('home') }}" class="text-lg font-bold" x-show="sidebarOpen">
                    <span class="text-amber-400">Shiivaraa</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
                    <i class="fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>

            <nav class="mt-2 space-y-0.5 px-2">
                @yield('sidebar')
            </nav>

            <div class="absolute bottom-0 w-full p-3 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center text-gray-400 hover:text-white w-full text-sm">
                        <i class="fas fa-sign-out-alt w-8 text-center"></i>
                        <span x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div :class="sidebarOpen ? 'ml-60' : 'ml-16'" class="flex-1 transition-all duration-300">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm h-14 flex items-center justify-between px-6 sticky top-0 z-30">
                <h1 class="text-base font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-xs text-flipblue hover:underline font-medium">
                        <i class="fas fa-external-link-alt mr-1"></i>Visit Store
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-flipblue rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden md:inline">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="px-6 pt-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                    <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-sm flex justify-between text-sm">
                        <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                        <button @click="show = false">&times;</button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="px-6 pt-3">
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-sm text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="px-6 pt-3">
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-sm text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
