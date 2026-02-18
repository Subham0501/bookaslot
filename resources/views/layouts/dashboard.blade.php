<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50 dark:bg-[#0f172a]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Hamro Yaad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
    @include('partials.analytics')
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col">
        <!-- Sidebar and Content grid -->
        <div class="flex-grow flex">
            <!-- Sidebar -->
            <div class="w-64 bg-white dark:bg-[#1e293b] border-r border-gray-100 dark:border-[#334155] hidden lg:flex flex-col">
                <div class="p-8">
                    <a href="/" class="text-2xl font-black text-[#ff6b6b]">HamroYaad</a>
                </div>
                <nav class="flex-grow px-6 space-y-2">
                    @if(Auth::user()->business)
                    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.index') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>📊</span> Overview
                    </a>
                    <a href="{{ route('dashboard.products') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.products') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🛍️</span> Products
                    </a>
                    <a href="{{ route('dashboard.banners') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.banners') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🖼️</span> Banners & Offers
                    </a>
                    @endif

                    @if(Auth::user()->is_admin)
                    <div class="pt-6 pb-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4">Administrative</span>
                    </div>
                    <a href="{{ route('admin.businesses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.businesses.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🏢</span> Manage Businesses
                    </a>
                    <a href="{{ route('admin.templates.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.templates.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>📝</span> Verify Templates
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>⚙️</span> System Settings
                    </a>
                    @endif
                </nav>
                <div class="p-6 border-t border-gray-100 dark:border-[#334155]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 font-bold hover:bg-red-50 rounded-2xl transition-all">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow">
                <!-- Mobile Navbar -->
                <div class="lg:hidden bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-[#334155] p-4 flex justify-between items-center">
                    <span class="text-xl font-black text-[#ff6b6b]">HamroYaad</span>
                    <button class="p-2 bg-gray-50 dark:bg-[#0f172a] rounded-xl">🍔</button>
                </div>

                <!-- Page Header -->
                <div class="p-8 sm:p-12">
                    <div class="max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="fixed bottom-10 right-10 bg-green-500 text-white px-8 py-4 rounded-2xl shadow-2xl animate-bounce z-50">
        {{ session('success') }}
    </div>
    @endif
</body>
</html>
