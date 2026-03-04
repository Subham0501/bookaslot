<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50 dark:bg-[#0f172a]" x-data="{ mobileMenuOpen: false, showUpgradeModal: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Hamro Yaad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @include('partials.analytics')
</head>
<body class="h-full">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         class="fixed inset-0 z-40 lg:hidden" 
         role="dialog" 
         aria-modal="true">
        <!-- Backdrop -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" 
             @click="mobileMenuOpen = false"></div>

        <!-- Sidebar Panel -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform" 
             x-transition:enter-start="-translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transition ease-in-out duration-300 transform" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-1 flex-col bg-white dark:bg-[#1e293b] pt-5 pb-4">
            
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="mobileMenuOpen = false" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <span class="text-white text-2xl">✕</span>
                </button>
            </div>

            <div class="flex flex-shrink-0 items-center px-4">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('assets/bookinglogo.jpeg') }}" alt="BookingArc Logo" class="h-10 w-auto object-contain">
                    <span class="text-2xl font-black text-[#ff6b6b] uppercase italic tracking-tighter">BookingArc</span>
                </a>
            </div>
            
            <div class="mt-8 h-0 flex-1 overflow-y-auto px-4">
                <nav class="space-y-2">
                    @if(Auth::user()->business)
                    @php $is_personal = Auth::user()->business->category == 'personal'; @endphp
                    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.index') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>📊</span> Overview
                    </a>
                    <a href="{{ route('dashboard.products') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.products') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>{{ $is_personal ? '🏆' : '🛍️' }}</span> {{ $is_personal ? 'Milestones' : 'Products' }}
                    </a>
                    <a href="{{ route('dashboard.banners') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.banners') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🖼️</span> {{ $is_personal ? 'Hero Banners' : 'Banners & Offers' }}
                    </a>
                    @endif

                    @if(Auth::user()->is_admin)
                    <div class="pt-6 pb-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4">Administrative</span>
                    </div>
                    <a href="{{ route('admin.businesses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.businesses.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🏢</span> Manage Businesses
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>⚙️</span> System Settings
                    </a>
                    @endif

                    <a @click="showUpgradeModal = true" class="flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold transition-all shadow-lg shadow-blue-500/20 cursor-pointer group mt-8">
                        <div class="flex items-center gap-3">
                            <span>🚀</span>
                            <span class="text-sm">Full Website</span>
                        </div>
                        <span class="bg-white/20 text-[8px] uppercase tracking-widest px-1.5 py-0.5 rounded-lg group-hover:bg-white/30 transition-colors">PRO</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-[#334155]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 font-bold hover:bg-red-50 rounded-2xl transition-all">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="min-h-full flex flex-col">
        <!-- Sidebar and Content grid -->
        <div class="flex-grow flex">
            <!-- Desktop Sidebar -->
            <div class="w-64 bg-white dark:bg-[#1e293b] border-r border-gray-100 dark:border-[#334155] hidden lg:flex flex-col sticky top-0 h-screen">
                <div class="p-8">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('assets/bookinglogo.jpeg') }}" alt="BookingArc Logo" class="h-12 w-auto object-contain">
                        <span class="text-2xl font-black text-[#ff6b6b] uppercase italic tracking-tighter">BookingArc</span>
                    </a>
                </div>
                <nav class="flex-grow px-6 space-y-2">
                    @if(Auth::user()->business)
                    @php $is_personal = Auth::user()->business->category == 'personal'; @endphp
                    <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.index') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>📊</span> Overview
                    </a>
                    <a href="{{ route('dashboard.products') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.products') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>{{ $is_personal ? '🏆' : '🛍️' }}</span> {{ $is_personal ? 'Milestones' : 'Products' }}
                    </a>
                    <a href="{{ route('dashboard.banners') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.banners') ? 'bg-[#ff6b6b] text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🖼️</span> {{ $is_personal ? 'Hero Banners' : 'Banners & Offers' }}
                    </a>
                    @endif

                    @if(Auth::user()->is_admin)
                    <div class="pt-6 pb-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4">Administrative</span>
                    </div>
                    <a href="{{ route('admin.businesses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.businesses.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>🏢</span> Manage Businesses
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-[#94a3b8] hover:bg-gray-50 dark:hover:bg-[#0f172a]' }} font-bold transition-all">
                        <span>⚙️</span> System Settings
                    </a>
                    @endif

                    <!-- Premium Upgrade Section Link -->
                    <div class="mt-auto px-4 mb-6">
                        <a @click="showUpgradeModal = true" class="flex items-center justify-between w-full px-4 py-3 rounded-2xl bg-gradient-to-r from-[#1e293b] to-[#0f172a] text-white font-bold transition-all shadow-xl hover:shadow-blue-500/10 cursor-pointer group border border-white/5">
                            <div class="flex items-center gap-3">
                                <span>🌐</span>
                                <span class="text-sm">Get Full Website</span>
                            </div>
                            <span class="bg-blue-500/40 text-blue-100 text-[8px] uppercase tracking-widest px-2 py-0.5 rounded-lg group-hover:bg-blue-500 transition-colors">NEW</span>
                        </a>
                    </div>
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
            <div class="flex-grow flex flex-col">
                <!-- Mobile Navbar -->
                <div class="lg:hidden bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-[#334155] p-4 flex justify-between items-center sticky top-0 z-30">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/bookinglogo.jpeg') }}" alt="BookingArc Logo" class="h-8 w-auto object-contain">
                        <span class="text-xl font-black text-[#ff6b6b] uppercase italic tracking-tighter">BookingArc</span>
                    </div>
                    <button @click="mobileMenuOpen = true" class="p-2 bg-gray-50 dark:bg-[#0f172a] rounded-xl text-2xl">🍔</button>
                </div>

                <!-- Page Header -->
                <div class="p-6 sm:p-12 flex-grow">
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

    <!-- Full Function Website Modal -->
    <div x-show="showUpgradeModal" 
         x-cloak 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showUpgradeModal" 
                 x-transition:enter="transition-opacity ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition-opacity ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/90 backdrop-blur-xl transition-opacity" 
                 @click="showUpgradeModal = false"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showUpgradeModal" 
                 x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="transition ease-in duration-200 transform" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white dark:bg-[#1e293b] rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-800">
                
                <div class="relative h-48 bg-gradient-to-br from-[#ff6b6b] to-[#ee5253] p-8 overflow-hidden">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-white">Full Upgrade</span>
                            <h3 class="mt-4 text-3xl font-black text-white leading-tight">Professional <br>Full Function Website</h3>
                        </div>
                        <button @click="showUpgradeModal = false" class="bg-black/20 hover:bg-black/40 text-white p-2 rounded-full transition-colors">
                            <span class="text-xl">✕</span>
                        </button>
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                </div>

                <div class="p-8 sm:p-10 space-y-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800">
                            <span class="text-2xl mb-2 block">🌍</span>
                            <h5 class="text-xs font-black uppercase tracking-widest text-gray-400">Identity</h5>
                            <p class="text-sm font-bold dark:text-white">Custom Domain (.com)</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800">
                            <span class="text-2xl mb-2 block">💎</span>
                            <h5 class="text-xs font-black uppercase tracking-widest text-gray-400">Design</h5>
                            <p class="text-sm font-bold dark:text-white">Premium UI/UX</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800">
                            <span class="text-2xl mb-2 block">🛠️</span>
                            <h5 class="text-xs font-black uppercase tracking-widest text-gray-400">Control</h5>
                            <p class="text-sm font-bold dark:text-white">Dedicated Admin Panel</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800">
                            <span class="text-2xl mb-2 block">🚀</span>
                            <h5 class="text-xs font-black uppercase tracking-widest text-gray-400">SEO</h5>
                            <p class="text-sm font-bold dark:text-white">Google Optimized</p>
                        </div>
                    </div>

                    <div class="space-y-4">


                        <div class="p-8 bg-gray-900 rounded-[2rem] text-center text-white relative overflow-hidden">
                            <span class="block text-[10px] font-black uppercase tracking-[0.3em] opacity-40 mb-2">Total Package Investment</span>
                            <h4 class="text-4xl font-black italic">Rs 99,000</h4>
                            <p class="mt-2 text-[10px] font-bold opacity-60">Includes 1 year maintenance & hosting support</p>
                        </div>
                    </div>

                    <a href="https://wa.me/{{ config('app.contact_whatsapp', '977981504104') }}?text=Hello! I am viewing my dashboard on HamroYaad and I want to upgrade to the Professional Full Function Website (Package: Rs 99,000). Please let me know the process." 
                       target="_blank" 
                       class="w-full flex items-center justify-center gap-3 py-6 bg-[#ff6b6b] text-white rounded-[2rem] font-black text-xl hover:shadow-2xl hover:shadow-[#ff6b6b]/40 transition-all active:scale-95 group">
                        Inquiry on WhatsApp
                        <span class="group-hover:translate-x-2 transition-transform">➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
