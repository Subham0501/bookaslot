@extends('layouts.app')

@section('content')
    <!-- Fonts & Global Styles (Needed for Templates) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-sans: 'Outfit', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }
        body { font-family: var(--font-sans); }
        .font-serif { font-family: var(--font-serif); }
        
        /* Smooth scrolling for anchor links */
        html { scroll-behavior: smooth; }
    </style>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-xl z-50 border-b border-gray-200 dark:border-[#334155] shadow-sm dark:shadow-[#1e293b]/50">
        <div class="w-full px-5 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex justify-between items-center h-20">
                <!-- Logo - Left Aligned -->
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="hover:opacity-80 transition-opacity flex items-center gap-3">
                        <img src="{{ asset('assets/logo.png') }}" alt="Hamro Yaad" class="h-16 md:h-20 w-auto">
                        <span class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] bg-clip-text text-transparent">Hamro Yaad</span>
                    </a>
                </div>
                
                <!-- Navigation Links - Right Aligned -->
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="#how-to-use" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide relative group py-2">
                        How It Works
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#ff6b6b] group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#faq" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide relative group py-2">
                        FAQ
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#ff6b6b] group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <button id="theme-toggle" type="button" class="p-2 rounded-lg bg-gray-100 dark:bg-[#1e293b] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-200 dark:hover:bg-[#334155] transition-all ml-2 cursor-pointer" aria-label="Toggle dark mode">
                        <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                    @auth
                        @if(auth()->user()->is_admin || auth()->user()->business)
                        <a href="{{ route('dashboard.index') }}" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-all">
                            Dashboard
                        </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-all ml-2">
                                Logout
                            </button>
                        </form>
                    @endauth
                    <a href="{{ auth()->check() ? route('dashboard.index') : route('create') }}" class="bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-2.5 rounded-lg hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-[15px] font-semibold tracking-wide ml-2">
                        Get Started
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-toggle" type="button" onclick="toggleMobileMenu()" class="md:hidden text-gray-600 dark:text-[#cbd5e1] p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-colors" aria-label="Toggle mobile menu">
                    <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden fixed top-20 left-0 right-0 bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-xl border-b border-gray-200 dark:border-[#334155] shadow-lg z-40">
            <div class="px-5 sm:px-6 lg:px-8 xl:px-12 py-4 space-y-3">
                <a href="#gifts" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">Gifts</a>
                <a href="#how-to-use" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">How It Works</a>
                <a href="#faq" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">FAQ</a>
                <button id="theme-toggle-mobile" type="button" onclick="if(window.toggleTheme) window.toggleTheme(event);" class="w-full text-left p-2 rounded-lg bg-gray-100 dark:bg-[#1e293b] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-200 dark:hover:bg-[#334155] transition-all flex items-center gap-3">
                    <svg id="moon-icon-mobile" class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg id="sun-icon-mobile" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="text-[15px] font-medium">Toggle Theme</span>
                </button>
                @auth
                    @if(auth()->user()->is_admin || auth()->user()->business)
                    <a href="{{ route('dashboard.index') }}" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" onclick="toggleMobileMenu()" class="w-full text-left p-2 rounded-lg text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-all text-[15px] font-medium tracking-wide">
                            Logout
                        </button>
                    </form>
                @endauth
                <a href="{{ auth()->check() ? route('dashboard.index') : route('create') }}" class="block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-2.5 rounded-lg hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-[15px] font-semibold tracking-wide text-center" onclick="toggleMobileMenu()">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20 bg-white dark:bg-[#0f172a]">
        <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Side - Dual Images -->
                <div class="order-2 lg:order-1 flex justify-center lg:justify-start relative">
                    <!-- Decor Blobs -->
                    <div class="absolute top-0 right-0 w-72 h-72 bg-[#ff6b6b]/20 rounded-full blur-3xl -z-10 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl -z-10 animate-pulse delay-700"></div>

                    <div class="relative w-full max-w-lg aspect-square">
                        <!-- Memory Card (Hamro Yaad) -->
                        <div class="absolute top-0 left-0 w-2/3 shadow-2xl rounded-3xl transform -rotate-6 hover:rotate-0 transition-transform duration-500 z-10 hover:z-30 cursor-pointer group">
                             <div class="absolute -top-4 -left-4 bg-blue-500 text-white px-4 py-1 rounded-full text-xs font-bold shadow-lg transform -rotate-12 group-hover:rotate-0 transition-transform">Memories</div>
                            <img src="{{ asset('assets/image_1_1765817075593.jpg') }}" alt="Hamro Yaad Memory" class="w-full h-auto object-cover rounded-3xl border-4 border-white dark:border-gray-800">
                        </div>

                        <!-- Business Card (Hamro Business) -->
                        <div class="absolute bottom-0 right-0 w-2/3 shadow-2xl rounded-3xl transform rotate-6 hover:rotate-0 transition-transform duration-500 z-20 hover:z-30 cursor-pointer group">
                            <div class="absolute -top-4 -right-4 bg-[#ff6b6b] text-white px-4 py-1 rounded-full text-xs font-bold shadow-lg transform rotate-12 group-hover:rotate-0 transition-transform">Business</div>
                            <div class="bg-gray-900 dark:bg-black p-6 rounded-3xl text-white h-[280px] flex flex-col justify-between border-4 border-white dark:border-gray-700 relative overflow-hidden">
                                <!-- Card Design -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] opacity-20 rounded-bl-full"></div>
                                
                                <div class="flex justify-between items-start z-10">
                                    <div>
                                        <h3 class="font-bold text-xl">Hamro Yaad</h3>
                                        <p class="text-[10px] uppercase tracking-widest text-[#ff6b6b] font-bold">Solutions</p>
                                    </div>
                                    <div class="bg-white p-1 rounded-lg">
                                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 3h3v-2h-3v2z"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="space-y-1 z-10 opacity-80">
                                    <div class="h-2 w-24 bg-gray-700 rounded-full"></div>
                                    <div class="h-2 w-32 bg-gray-700 rounded-full"></div>
                                </div>
                                
                                <div class="flex justify-between items-end z-10">
                                    <div class="text-xs text-gray-400">
                                        Kathmandu, Nepal<br>
                                        +977 9800000000
                                    </div>
                                    <div class="text-[#ff6b6b] font-black text-xs uppercase tracking-widest">
                                        Scan Me
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Right Side - Content -->
                <div class="order-1 lg:order-2 text-center lg:text-left space-y-8">
                    <!-- Main Heading -->
                    <div class="space-y-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-400 dark:text-gray-500 tracking-wide uppercase">
                            Make every scan meaningful.
                        </h2>
                        <h1 class="text-6xl md:text-8xl lg:text-9xl font-black leading-[0.9] tracking-tighter">
                            <span class="block text-gray-900 dark:text-white">One QR.</span>
                            <span class="block text-[#ff6b6b]">Two Worlds.</span>
                        </h1>
                    </div>
                    
                    <!-- Subheading -->
                    <div class="space-y-6 max-w-2xl mx-auto lg:mx-0">
                        <p class="text-xl md:text-2xl text-gray-600 dark:text-[#cbd5e1] leading-relaxed font-light">
                            <span class="font-bold text-gray-900 dark:text-white">Scan to Feel. Scan to Connect.</span> <br>
                            From personal memories to professional growth, all in one place.
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-5 pt-6">
                        <a href="#how-to-use" class="w-full sm:w-auto px-8 py-4 bg-[#ff6b6b] text-white rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-[#ff6b6b]/30 hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group ring-4 ring-[#ff6b6b]/20">
                            Create Yours
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="#categories" class="w-full sm:w-auto px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:bg-gray-200 dark:hover:bg-gray-700 hover:-translate-y-1 transition-all flex items-center justify-center border border-transparent hover:border-gray-300 dark:hover:border-gray-600">
                            For Business
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


        <style>
            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }
            .animate-scroll {
                animation: scroll 30s linear infinite;
                display: flex;
                width: max-content;
            }
            .animate-scroll:hover {
                animation-play-state: paused;
            }
            @keyframes gradientShift {
                0%, 100% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
            }
            nav a span {
                background-size: 200% 200%;
                animation: gradientShift 3s ease infinite;
            }
        </style>
    </section>

    </section>

    <!-- Business Categories Section -->
    <section id="categories" class="py-32 bg-white dark:bg-[#0f172a]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <!-- Business Value Proposition -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20 md:mb-32">
                <!-- Left: Content & Features -->
                <div>
                     <span class="text-[#ff6b6b] font-black uppercase tracking-[0.2em] text-sm mb-4 block">For Professionals & Brands</span>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight">
                        One Scan. <br>
                        <span class="text-[#ff6b6b]">Everything Connected.</span>
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1] mb-8 leading-relaxed">
                        Transform your physical presence into a powerful digital hub. Share your products, location, and contact details instantly.
                    </p>

                    <!-- Feature List -->
                    <div class="space-y-6 mb-10">
                        <!-- Feature 1 -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                                🛍️
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">Mini Website & Products</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Showcase your products or services in a beautiful digital catalog.</p>
                            </div>
                        </div>
                        <!-- Feature 2 -->
                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                                💬
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">WhatsApp & Maps Integration</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Direct WhatsApp ordering and one-tap Google Maps navigation.</p>
                            </div>
                        </div>
                        <!-- Feature 3 -->
                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                                �
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">Powerful Admin Panel</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Update your banner, details, and products anytime from your dashboard.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dashboard Preview Showcase -->
                    <!-- Dashboard Browser Mockups -->
                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mockup 1 -->
                        <div class="relative group perspective-1000">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-[1rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                            <div class="relative bg-white dark:bg-[#0f172a] rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden hover:-translate-y-1 transition-transform duration-500">
                                <!-- Browser Header -->
                                <div class="bg-gray-100 dark:bg-[#1e293b] px-3 py-2 border-b border-gray-200 dark:border-slate-700 flex items-center gap-2">
                                    <div class="flex gap-1">
                                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="flex-1 text-[10px] text-gray-400 font-mono text-center">dashboard/analytics</div>
                                </div>
                                <img src="{{ asset('assets/Screenshot 2026-02-17 at 22.08.08.png') }}" class="w-full h-auto" alt="Analytics" loading="lazy">
                            </div>
                        </div>

                        <!-- Mockup 2 -->
                        <div class="relative group perspective-1000">
                            <div class="absolute -inset-1 bg-gradient-to-r from-[#ff6b6b] to-orange-500 rounded-[1rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                            <div class="relative bg-white dark:bg-[#0f172a] rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden hover:-translate-y-1 transition-transform duration-500">
                                <!-- Browser Header -->
                                <div class="bg-gray-100 dark:bg-[#1e293b] px-3 py-2 border-b border-gray-200 dark:border-slate-700 flex items-center gap-2">
                                    <div class="flex gap-1">
                                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="flex-1 text-[10px] text-gray-400 font-mono text-center">dashboard/products</div>
                                </div>
                                <img src="{{ asset('assets/Screenshot 2026-02-17 at 22.07.54.png') }}" class="w-full h-auto" alt="Product Management" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual Pricing & Card Showcase -->
                 <div class="relative flex flex-col justify-center items-center lg:items-end">
                     
                     <!-- 3D Rotating Business Card -->
                     <div class="group perspective-1000 w-80 h-48 cursor-pointer mb-12 relative z-20">
                         <div class="relative w-full h-full duration-1000 transform-style-3d group-hover:rotate-y-180 animate-float">
                             <!-- Front Side -->
                             <div class="absolute w-full h-full backface-hidden rounded-2xl overflow-hidden shadow-2xl border border-white/10 bg-gray-900 text-white p-6 flex flex-col justify-between">
                                 <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] opacity-20 rounded-bl-full"></div>
                                 <div class="flex justify-between items-start">
                                     <div class="space-y-1">
                                         <h3 class="font-bold text-lg">Hamro Yaad</h3>
                                         <p class="text-[10px] uppercase tracking-widest text-[#ff6b6b] font-bold">Normal Business Card</p>
                                     </div>
                                     <div class="w-12 h-12 bg-white rounded-lg p-1">
                                         <svg class="w-full h-full text-gray-900" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 3h3v-2h-3v2z"/>
                                        </svg>
                                     </div>
                                 </div>
                                 <div class="text-xs space-y-1 text-gray-300">
                                     <p>Samakhusi, Kathmandu</p>
                                     <p>+977 9800000000</p>
                                 </div>
                             </div>
                             
                             <!-- Back Side -->
                             <div class="absolute w-full h-full backface-hidden rotate-y-180 rounded-2xl overflow-hidden shadow-2xl border border-white/10 bg-white text-gray-900 p-6 flex flex-col items-center justify-center text-center">
                                 <div class="absolute bottom-0 left-0 w-24 h-24 bg-gray-100 rounded-tr-full"></div>
                                 <div class="w-20 h-20 bg-gray-900 rounded-xl p-2 mb-3 shadow-lg">
                                     <svg class="w-full h-full text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 3h3v-2h-3v2z"/>
                                    </svg>
                                 </div>
                                 <p class="font-bold text-sm">Scan to Connect</p>
                                 <p class="text-[10px] text-gray-500 mt-1">hamroyaad.com</p>
                             </div>
                         </div>
                         
                         <!-- Card Price Tag -->
                         <div class="absolute -right-4 -bottom-4 bg-[#ff6b6b] text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg transform rotate-3">
                             Rs 3 <span class="text-[10px] font-normal opacity-90">/ piece</span>
                         </div>
                     </div>

                     <!-- Annual Subscription Details -->
                    <div class="bg-gray-50 dark:bg-[#1e293b] rounded-[2rem] p-8 w-full max-w-sm border border-gray-200 dark:border-slate-700 relative hover:shadow-xl transition-shadow">
                         <div class="flex justify-between items-center mb-6">
                             <h3 class="text-xl font-black text-gray-900 dark:text-white">Business Pro</h3>
                             <span class="bg-gray-900 dark:bg-white text-white dark:text-black px-3 py-1 rounded-full text-[10px] font-bold uppercase">Yearly</span>
                         </div>

                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black text-[#ff6b6b]">Rs 2000</span>
                            <span class="text-gray-500 font-bold text-sm">/ year</span>
                        </div>

                         <ul class="space-y-4 mb-8 text-sm text-gray-600 dark:text-gray-300">
                             <li class="flex items-center gap-3">
                                 <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 text-xs">✓</div>
                                 Mini Website with Unlimited Updates
                             </li>
                             <li class="flex items-center gap-3">
                                 <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 text-xs">✓</div>
                                 Full Admin Dashboard Access
                             </li>
                             <li class="flex items-center gap-3">
                                 <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 text-xs">✓</div>
                                 Priority Support & Analytics
                             </li>
                         </ul>
                    </div>
                </div>
            </div>

            <style>
                .perspective-1000 { perspective: 1000px; }
                .transform-style-3d { transform-style: preserve-3d; }
                .backface-hidden { backface-visibility: hidden; }
                .rotate-y-180 { transform: rotateY(180deg); }
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotateY(0deg); }
                    50% { transform: translateY(-10px) rotateY(5deg); }
                }
                .animate-float { animation: float 6s ease-in-out infinite; }
            </style>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $categories = [

                    [
                        'id' => 'travel',
                        'title' => 'Travel & Tour',
                        'subtitle' => 'Global 🌍',
                        'desc' => 'Travel agencies, tour guides, and trekking services.',
                        'why' => 'Showcase packages, pricing, and destinations with easy WhatsApp inquiry.',
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3.05 11c.5 4.45 4.25 8 8.95 8 4.7 0 8.45-3.55 8.95-8H3.05zm17.9-2a9.96Scale 9.96 0 00-1.95-3.8l-1.4 1.4c.5.5.9 1.1 1.25 1.75L19 9h1.95zM12 2a9.96 9.96 0 00-8.95 5.5l1.75 1C5.4 7.65 6.4 6.7 7.55 6l1.2-1.75c.95-.5 2-.9 3.25-.95V2zm0 18v2c1.25-.05 2.3-.45 3.25-.95l-1.2-1.75c-1.15.7-2.15 1.65-2.75 2.5l-1.75-1c-.55 1-.95 2.1-1.25 3.2z"></path></svg>',
                        'color' => 'bg-sky-600',
                        'gradient' => 'from-sky-600 to-blue-500',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800'
                    ],
                    [
                        'id' => 'ecommerce',
                        'title' => 'Ecommerce Portfolio',
                        'subtitle' => 'Selling 🔥',
                        'desc' => 'Instagram sellers and small online shop portfolios.',
                        'why' => 'No website needed. High conversion with WhatsApp product detail sharing.',
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                        'color' => 'bg-cyan-600',
                        'gradient' => 'from-cyan-600 to-blue-600',
                        'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800'
                    ],
                    [
                        'id' => 'consultancy',
                        'title' => 'Consultancy',
                        'subtitle' => 'Professional',
                        'desc' => 'Education consultants, legal advisors, and specialized experts.',
                        'why' => 'Present services clearly, share credentials, and book appointments via WhatsApp.',
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3v4a3 3 0 106 0v-4c0-1.657-1.343-3-3-3z"></path><path d="M12 2a10 10 0 100 20 10 10 0 000-20z"></path></svg>',
                        'color' => 'bg-indigo-600',
                        'gradient' => 'from-indigo-600 to-blue-700',
                        'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800'
                    ],
                    [
                        'id' => 'hotels',
                        'title' => 'Hotels & Restaurants',
                        'subtitle' => 'Hospitality',
                        'desc' => 'Boutique hotels, luxury resorts, and popular local restaurants.',
                        'why' => 'Showcase premium rooms or mouth-watering menus with direct WhatsApp booking/ordering.',
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                        'color' => 'bg-amber-600',
                        'gradient' => 'from-amber-600 to-orange-700',
                        'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800'
                    ],
                    [
                        'id' => 'photo',
                        'title' => 'Events & Photo',
                        'subtitle' => 'Premium 📸',
                        'desc' => 'Wedding photographers and professional videographers.',
                        'why' => 'High-quality portfolio showcase designed for high-value clients.',
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2v11zM12 9a5 5 0 100 10 5 5 0 000-10z"></path></svg>',
                        'color' => 'bg-emerald-600',
                        'gradient' => 'from-emerald-600 to-teal-700',
                        'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800'
                    ]
                ];
                @endphp

                @foreach($categories as $category)
                <div class="group relative bg-white dark:bg-[#1e293b] rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-[#334155] flex flex-col h-full hover:-translate-y-2">
                    
                    <!-- Top Visual Section -->
                    <div class="relative h-48 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10 transition-opacity group-hover:opacity-80"></div>
                        <img src="{{ $category['image'] }}" alt="{{ $category['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                        
                        <!-- Floating category badge -->
                        <div class="absolute top-4 left-4 z-20">
                            <span class="inline-block px-3 py-1 bg-white/90 dark:bg-black/80 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white shadow-lg">
                                {{ $category['subtitle'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-8 flex flex-col flex-grow relative">
                        <!-- Icon Badge -->
                        <div class="absolute -top-10 right-8 w-20 h-20 rounded-2xl bg-white dark:bg-[#0f172a] shadow-xl flex items-center justify-center border-4 border-gray-50 dark:border-[#1e293b] z-20 group-hover:scale-110 transition-transform duration-300">
                           <div class="text-{{ explode('-', $category['color'])[1] }}-600 dark:text-white transition-colors">
                                {!! $category['icon'] !!}
                           </div>
                        </div>

                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3 mt-2 group-hover:text-[#ff6b6b] transition-colors line-clamp-1">
                            {{ $category['title'] }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-2">
                            {{ $category['desc'] }}
                        </p>

                         <!-- Why Section -->
                        <div class="mb-8 flex-grow">
                             <div class="flex items-start gap-3 p-4 bg-gray-50 dark:bg-[#0f172a]/50 rounded-xl border border-gray-100 dark:border-[#334155]">
                                <div class="text-[#ff6b6b] mt-0.5 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed font-medium">
                                    <span class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Why Choose?</span>
                                    {{ $category['why'] }}
                                </p>
                             </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3 mt-auto">
                            <button onclick="openDesignModal('{{ $category['id'] }}')" 
                                class="flex items-center justify-center gap-2 py-3 rounded-xl bg-gray-100 dark:bg-[#334155] text-gray-900 dark:text-white font-bold text-sm hover:bg-gray-200 dark:hover:bg-[#475569] transition-colors group/btn">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover/btn:text-[#ff6b6b] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View Design
                            </button>
                            <a href="{{ route('contact') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl bg-[#ff6b6b]/10 text-[#ff6b6b] font-bold text-sm hover:bg-[#ff6b6b] hover:text-white transition-all group/btn">
                                Contact
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- How to Use Section - 4 Steps -->
    <section id="how-to-use" class="py-32 bg-white dark:bg-[#0f172a]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">Create a memory in</span>
                    <span class="block text-[#ff6b6b]">4 steps!</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-[#cbd5e1] max-w-2xl mx-auto mb-4">
                    Surprise someone special with a digital keepsake that makes the heart race. It's easy, fast, and unforgettable.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ auth()->check() ? route('dashboard.index') : route('create') }}" class="inline-block text-[#ff6b6b] font-bold hover:text-[#ff5252] transition-colors">
                        Start now!
                </a>
                    <span class="text-gray-600 dark:text-[#cbd5e1]">Easy and simple</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <!-- Step 1 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">1</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Design Your Space</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">Choose for Personal Memory or Business Profile. Add your photos and details.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#4ecdc4]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#4ecdc4] to-[#45b8b0] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">2</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Pick Your Card</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow mb-3">Optional: Order high-quality physical cards with your unique QR code pre-printed.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffd93d]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ffd93d] to-[#ffc107] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">3</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Activate Profile</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">Go live instantly. For businesses, start accepting WhatsApp orders immediately after activation.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff8fab]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ff8fab] to-[#ff6b9d] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">4</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Share & Grow</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">Deliver emotion or grow your business. One scan, endless possibilities.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ auth()->check() ? route('dashboard.index') : route('create') }}" class="inline-block bg-[#ff6b6b] text-white px-10 py-4 rounded-xl text-lg font-black tracking-wide hover:bg-[#ff5252] transition-all shadow-2xl shadow-[#ff6b6b]/30 hover:shadow-[#ff6b6b]/40 hover:-translate-y-0.5">
                    Start now! <span class="text-white/90">Easy and simple</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Trust & Statistics Section -->
    <section class="py-32 bg-gradient-to-b from-white to-gray-50 dark:from-[#0f172a] dark:to-[#1e293b]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-tight">
                    <span class="block text-gray-900 dark:text-white">Trust is abundant.</span>
                    <span class="block text-gray-900 dark:text-white">So is emotion.</span>
                    <span class="block text-[#ff6b6b]">And memories that last forever.</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <!-- Trust Card -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                        <h3 class="text-xl font-black mb-4 text-gray-900 dark:text-white text-center">Trust is abundant</h3>
                        <ul class="space-y-3 text-gray-600 dark:text-[#cbd5e1] text-sm">
                        <li class="flex items-start">
                                <span class="text-[#ff6b6b] mr-2 font-bold">•</span>
                                <span>10,000+ memories created in 2024</span>
                        </li>
                        <li class="flex items-start">
                                <span class="text-[#ff6b6b] mr-2 font-bold">•</span>
                            <span>Average rating: 4.97/5 ⭐⭐⭐⭐⭐</span>
                        </li>
                        <li class="flex items-start">
                                <span class="text-[#ff6b6b] mr-2 font-bold">•</span>
                                <span>Over 85% of customers recommend</span>
                        </li>
                        <li class="flex items-start">
                                <span class="text-[#ff6b6b] mr-2 font-bold">•</span>
                                <span>A unique gift accessed in over 30 countries</span>
                        </li>
                    </ul>
                    </div>
                </div>

                <!-- Digital Impact Card -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#4ecdc4]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#4ecdc4] to-[#45b8b0] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        </div>
                        <h3 class="text-xl font-black mb-4 text-gray-900 dark:text-white text-center">Digital gift. Real impact.</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm mb-4 text-center">
                            Hamro Yaad has become a reference in creating emotional memories — and social media is full of stories that make hearts race.
                        </p>
                    </div>
                </div>

                <!-- Social Media Card -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffd93d]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ffd93d] to-[#ffc107] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-black mb-4 text-gray-900 dark:text-white text-center">Strong social media presence</h3>
                        <div class="flex flex-col gap-4 mt-6">
                            <div class="flex items-center justify-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#ffd93d] to-[#ffc107] rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-2xl font-black text-gray-900 dark:text-white">30k+</div>
                                    <div class="text-xs text-gray-600 dark:text-[#cbd5e1]">followers</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-2xl font-black text-gray-900 dark:text-white">3M+</div>
                                    <div class="text-xs text-gray-600 dark:text-[#cbd5e1]">likes</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Beyond Screen Card -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff8fab]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ff8fab] to-[#ff6b9d] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        </div>
                        <h3 class="text-xl font-black mb-4 text-gray-900 dark:text-white text-center">Impression that goes beyond the screen</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center">
                            Even though it's digital, the Hamro Yaad experience is so powerful that many print the QR Code and deliver it in person — in cards, gift boxes, or even on their wedding day.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ Section -->
    <section id="faq" class="py-32 bg-gray-50 dark:bg-[#1e293b]">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-4 tracking-tight text-gray-900 dark:text-white">
                    Frequently Asked Questions
                </h2>
                <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">
                    Find answers to common questions below. We're here to help make your experience smooth and enjoyable.
                </p>
            </div>

            <div class="space-y-4">
                @php
                $faqs = [
                    ['q' => 'What is Hamro Yaad?', 'a' => 'Hamro Yaad is a platform that transforms traditional visiting cards and gifts into interactive digital experiences. Whether it\'s a personal memory gallery or a business digital profile, one scan reveals it all.'],
                    ['q' => 'How does the Business Profile work?', 'a' => 'For businesses, we create a mobile-friendly mini-site. You can list products, prices, and include an "Order on WhatsApp" button. Customers scan your QR card, view your shop, and order directly via message.'],
                    ['q' => 'Do I need a physical card?', 'a' => 'It\'s optional but highly recommended! You can use our digital link anywhere, but we also offer high-quality physical visiting cards with your unique QR code pre-printed.'],
                    ['q' => 'Is there a yearly fee for businesses?', 'a' => 'Yes, business profiles are subscription-based (Rs 2000/year) to maintain your digital storefront and ordering system. Personal memories are currently a one-time fee.'],
                    ['q' => 'How can I get help if I need it?', 'a' => 'You can reach out through our support email or social media channels. Our team is here to help ensure your digital profile is perfect.'],
                    ['q' => 'What payment methods do you accept?', 'a' => 'We accept secure payments via Bank Transfer, eSewa, Khalti, and major Credit Cards.'],
                ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="faq-item bg-white dark:bg-[#0f172a] rounded-xl border border-gray-200 dark:border-[#334155] hover:border-[#ff6b6b] transition-all overflow-hidden">
                    <button class="faq-question w-full text-left p-6 flex items-center justify-between focus:outline-none group" onclick="toggleFaq({{ $index }})">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white pr-4">{{ $faq['q'] }}</h3>
                        <svg class="faq-icon w-6 h-6 text-[#ff6b6b] flex-shrink-0 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-answer overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0px;">
                        <div class="px-6 pb-6 pt-0">
                            <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-white dark:bg-[#0f172a] border-t border-gray-200 dark:border-[#334155] py-16">
        <div class="w-full px-5 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <!-- Brand Section - First Column -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('assets/logo.png') }}" alt="Hamro Yaad" class="h-12 md:h-16 w-auto">
                        <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] bg-clip-text text-transparent">Hamro Yaad</span>
                    </div>
                    <p class="text-gray-600 dark:text-[#cbd5e1] text-sm leading-relaxed max-w-xs">Create beautiful custom gift websites and share your love with the world.</p>
                </div>
                
                <!-- Product Links -->
                <div>
                    <h4 class="font-black mb-4 text-gray-900 dark:text-white text-sm tracking-widest uppercase">Product</h4>
                    <ul class="space-y-2.5 text-gray-600 dark:text-[#cbd5e1] text-sm">
                        <li><a href="#categories" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Templates</a></li>
                        <li><a href="#shopping" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Shop</a></li>
                        <li><a href="#how-to-use" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">How It Works</a></li>
                    </ul>
                </div>
                
                <!-- Company Links -->
                <div>
                    <h4 class="font-black mb-4 text-gray-900 dark:text-white text-sm tracking-widest uppercase">Company</h4>
                    <ul class="space-y-2.5 text-gray-600 dark:text-[#cbd5e1] text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">About</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Contact</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Privacy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Terms & Conditions</a></li>
                    </ul>
                </div>
                
                <!-- Social Links -->
                <div>
                    <h4 class="font-black mb-4 text-gray-900 dark:text-white text-sm tracking-widest uppercase">Connect</h4>
                    <ul class="space-y-2.5 text-gray-600 dark:text-[#cbd5e1] text-sm">
                        <li><a href="https://www.facebook.com/profile.php?id=61569794637986" target="_blank" rel="noopener noreferrer" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Facebook</a></li>
                        <li><a href="https://www.instagram.com/hamro_yaad?igsh=MTZrYmdhYnpkajNiOQ%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">Instagram</a></li>
                        <li><a href="https://www.tiktok.com/@hamro.yaad?_r=1&_t=ZS-92tcIgnLALRtiktok" target="_blank" rel="noopener noreferrer" class="hover:text-gray-900 dark:hover:text-white transition-colors inline-block">TikTok</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-[#334155]">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-center md:text-left text-gray-500 dark:text-gray-400 text-sm">&copy; {{ date('Y') }} Hamro Yaad. All rights reserved.</p>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="{{ route('terms') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Terms & Conditions</a>
                        <span class="text-gray-400">|</span>
                        <a href="{{ route('privacy') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Design Modal -->
    <div id="designModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="modalOverlay" class="fixed inset-0 transition-opacity bg-gray-900/90 backdrop-blur-sm" onclick="closeDesignModal()"></div>

            <!-- Modal Panel -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-[#0f172a] rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full relative">
                <!-- Close Button -->
                <button onclick="closeDesignModal()" class="absolute top-6 right-6 z-20 p-2 bg-gray-100 dark:bg-[#1e293b] rounded-full text-gray-500 hover:text-gray-700 dark:text-[#94a3b8] dark:hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="p-8 sm:p-12">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <h3 id="modalTitle" class="text-3xl font-black text-gray-900 dark:text-white">Design Preview</h3>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 ml-2 uppercase tracking-widest">Mobile View</span>
                        </div>
                    </div>
                    
                    <div class="relative rounded-3xl overflow-hidden bg-gray-100 dark:bg-[#1e293b] border-8 border-gray-900 dark:border-black shadow-2xl overflow-y-auto max-h-[60vh] sm:max-h-[70vh]">
                        <div id="modalContent" class="w-full">
                            <!-- Dynamic Template Injected Here -->
                        </div>
                        <div id="loadingIndicator" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-[#1e293b] z-10">
                            <div class="w-12 h-12 border-4 border-[#ff6b6b] border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('contact') }}" class="bg-[#ff6b6b] text-white px-12 py-4 rounded-xl text-lg font-black hover:shadow-[0_10px_20px_rgba(255,107,107,0.3)] transition-all transform hover:-translate-y-1 text-center">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDesignModal(id, title) {
            const modal = document.getElementById('designModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const loadingIndicator = document.getElementById('loadingIndicator');

            modalTitle.innerText = title + ' Template';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Simulate loading for better UX
            loadingIndicator.classList.remove('hidden');
            modalContent.innerHTML = '';
            
            setTimeout(() => {
                const template = document.getElementById('template-' + id);
                if (template) {
                    modalContent.innerHTML = template.innerHTML;
                } else {
                    modalContent.innerHTML = '<div class="p-20 text-center text-gray-500">Template coming soon...</div>';
                }
                loadingIndicator.classList.add('hidden');
            }, 600);
        }

        function closeDesignModal() {
            const modal = document.getElementById('designModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function toggleFaq(index) {
            // ... (keep existing FAQ code)
            const faqItem = document.querySelectorAll('.faq-item')[index];
            const faqAnswer = faqItem.querySelector('.faq-answer');
            const faqIcon = faqItem.querySelector('.faq-icon');
            const currentHeight = faqAnswer.style.maxHeight || '0px';
            const isOpen = currentHeight !== '0px';
            
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach((item, i) => {
                if (i !== index) {
                    const answer = item.querySelector('.faq-answer');
                    const icon = item.querySelector('.faq-icon');
                    answer.style.maxHeight = '0px';
                    icon.classList.remove('rotate-180');
                }
            });
            
            // Toggle current FAQ
            if (isOpen) {
                faqAnswer.style.maxHeight = '0px';
                faqIcon.classList.remove('rotate-180');
            } else {
                // First set to auto to get the actual height, then animate
                faqAnswer.style.maxHeight = 'none';
                const height = faqAnswer.scrollHeight + 'px';
                faqAnswer.style.maxHeight = '0px';
                // Force reflow
                faqAnswer.offsetHeight;
                // Now animate to full height
                faqAnswer.style.maxHeight = height;
                faqIcon.classList.add('rotate-180');
            }
        }
    </script>
    <!-- Hidden Templates Repository -->
    <div id="templates-vault" class="hidden">
        <!-- Personal Portfolio Template -->
        <div id="template-personal">
            <div class="bg-[#18181b] text-zinc-200 font-sans min-h-screen relative overflow-hidden">
                <!-- Abstract Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-violet-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="max-w-md mx-auto flex flex-col items-center text-center p-8 py-12 relative z-10">
                    <div class="relative mb-8">
                        <div class="w-32 h-32 overflow-hidden relative grayscale hover:grayscale-0 transition-all duration-1000">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <div class="absolute inset-0 ring-1 ring-white/10 pointer-events-none"></div>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-16 h-16 border border-white/20 rounded-full flex items-center justify-center text-violet-400 animate-[spin_10s_linear_infinite]">
                            <svg viewBox="0 0 100 100" width="60" height="60">
                                <path id="circleP" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" fill="none"/>
                                <text font-size="14" fill="currentColor">
                                    <textPath xlink:href="#circleP">CREATIVE • VISION •</textPath>
                                </text>
                            </svg>
                        </div>
                    </div>
                    
                    <span class="text-zinc-200 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Professional Portfolio</span>
                    <h1 class="text-5xl font-serif italic text-white mb-6 tracking-tighter">Alex Sharma</h1>
                    <p class="text-zinc-400 text-xs font-medium tracking-[0.2em] mb-10 uppercase leading-loose">
                        Creative • Visionary • Professional
                    </p>
                    
                    <div class="bg-zinc-900/50 backdrop-blur-md rounded-none border border-white/5 p-8 w-full mb-10 text-left">
                        <span class="text-violet-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">About Me</span>
                        <h3 class="text-2xl font-serif italic text-white mb-4">Driven by passion.</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed font-light">
                            I am a dedicated professional with a passion for excellence. My work is a reflection of my commitment to delivering high-quality results.
                        </p>
                    </div>

                    <div class="w-full space-y-6">
                        <div class="text-center mb-6">
                            <span class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.4em]">Selected Works</span>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="relative h-40 overflow-hidden mb-4 filter grayscale hover:grayscale-0 transition-all duration-700 bg-zinc-900 border border-white/5">
                                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black to-transparent">
                                    <h3 class="text-lg font-serif italic text-white">Urban Architecture</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-6">
                            <button class="w-full bg-white text-black py-4 rounded-full font-black text-xs uppercase tracking-widest hover:bg-zinc-200 transition-colors">
                                Let's Collaborate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel & Tour Template -->
        <div id="template-travel">
            <div class="bg-[#020617] text-slate-200 font-sans min-h-screen relative overflow-hidden">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/40 to-black/30"></div>
                    
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                        <span class="text-teal-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Explore the World</span>
                        <h1 class="text-5xl font-serif italic text-white mb-6 tracking-tighter">Himalayan Pathfinders</h1>
                        <p class="text-slate-300 text-xs font-medium tracking-[0.2em] uppercase">Adventure • Serenity • Nature</p>
                    </div>
                </div>
                
                <div class="p-8 max-w-md mx-auto relative z-10">
                    <div class="grid grid-cols-2 gap-8 mb-12 text-center">
                         <div>
                             <div class="text-2xl text-teal-400 mb-2">🏔️</div>
                             <div class="text-xs font-bold uppercase tracking-widest text-slate-400">Summits</div>
                         </div>
                         <div>
                             <div class="text-2xl text-teal-400 mb-2">⭐</div>
                             <div class="text-xs font-bold uppercase tracking-widest text-slate-400">Top Rated</div>
                         </div>
                    </div>

                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-serif italic text-white mb-2">Curated Journeys</h2>
                        <div class="w-12 h-px bg-teal-900 mx-auto"></div>
                    </div>

                    <div class="space-y-8 mb-12">
                        <div class="group cursor-pointer">
                            <div class="relative h-56 overflow-hidden mb-4 filter sepia-[.2] group-hover:sepia-0 transition-all duration-700 bg-slate-900 border border-white/5">
                                <img src="https://images.unsplash.com/photo-1533130061792-64b345e4a833?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                                <div class="absolute top-4 right-4 bg-teal-500/90 backdrop-blur text-white text-[9px] font-black px-3 py-1 uppercase tracking-widest">14 Days</div>
                            </div>
                            <h3 class="text-xl font-serif italic text-white mb-1 group-hover:text-teal-400 transition-colors">Everest Base Camp</h3>
                            <div class="flex justify-between items-center border-t border-slate-800 pt-3 mt-3">
                                <span class="text-teal-400 font-bold text-xs">Rs 1,25,000</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-white transition-colors">View Details</span>
                            </div>
                        </div>
                    </div>
                    
                    <button class="w-full bg-teal-600 text-white py-4 rounded-none text-xs font-black uppercase tracking-widest hover:bg-teal-500 transition-colors">
                        Start Your Journey
                    </button>
                </div>
            </div>
        </div>

        <!-- Ecommerce Template -->
        <div id="template-ecommerce">
            <div class="bg-white text-slate-900 font-sans min-h-screen">
                <div class="px-6 py-6 flex justify-between items-center sticky top-0 bg-white/80 backdrop-blur-md z-20 border-b border-slate-50">
                    <div>
                        <h1 class="text-xl font-black tracking-tight uppercase">KREATIVE<span class="text-[#ff6b6b]">STORE</span></h1>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Curated Lifestyle</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-lg shadow-inner">📦</div>
                </div>
                
                <div class="p-6">
                    <div class="relative rounded-[2rem] overflow-hidden mb-10 group aspect-[4/5]">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-center p-8">
                            <span class="text-white/80 text-[10px] font-black uppercase tracking-[0.3em] mb-4">New Collection</span>
                            <h2 class="text-4xl font-black text-white leading-tight mb-8">SUMMER<br>MINIMAL</h2>
                            <button class="bg-white text-slate-900 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-2xl">Shop Now</button>
                        </div>
                    </div>

                    <div class="flex gap-3 mb-8 overflow-x-auto no-scrollbar pb-2">
                        <button class="bg-slate-900 text-white px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest whitespace-nowrap">All Items</button>
                        <button class="bg-slate-50 text-slate-400 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest whitespace-nowrap">Apparel</button>
                    </div>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-8">
                        @php
                            $ecommerceImages = [
                                'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800',
                                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800',
                                'https://images.unsplash.com/photo-1526170315870-ef6856fd3aba?w=800',
                                'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=800'
                            ];
                        @endphp
                        @for($i=1; $i<=4; $i++)
                        <div class="group cursor-pointer">
                            <div class="aspect-[3/4] bg-slate-100 rounded-[2rem] mb-3 overflow-hidden shadow-sm relative">
                                <img src="{{ $ecommerceImages[$i-1] }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700">
                                <div class="absolute bottom-3 right-3 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-xs shadow-lg translate-y-10 group-hover:translate-y-0 transition-transform">💬</div>
                            </div>
                            <h4 class="font-black text-xs text-slate-800 mb-1 leading-tight">Comfort Tee {{ $i }}</h4>
                            <span class="text-[#ff6b6b] text-xs font-black">Rs 2,499</span>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultancy Template -->
        <div id="template-consultancy">
            <div class="bg-[#0f172a] text-slate-200 font-sans min-h-screen relative overflow-hidden">
                <!-- Abstract Decoration -->
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

                <div class="relative z-10 p-8 pt-16 text-center">
                    <span class="text-indigo-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Expert Guidance</span>
                    <h1 class="text-5xl font-serif italic text-white mb-6 tracking-tighter">InVision Ed</h1>
                    <p class="text-slate-400 text-xs font-medium tracking-[0.2em] uppercase leading-loose mb-10">Trust • Excellence • Future</p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-12">
                        <div class="bg-slate-800/50 border border-white/5 p-6 backdrop-blur-sm">
                            <div class="text-2xl font-serif italic text-white mb-1">2.5k+</div>
                            <div class="text-[8px] text-indigo-400 uppercase font-bold tracking-widest">Success Stories</div>
                        </div>
                        <div class="bg-slate-800/50 border border-white/5 p-6 backdrop-blur-sm">
                            <div class="text-2xl font-serif italic text-white mb-1">98%</div>
                            <div class="text-[8px] text-indigo-400 uppercase font-bold tracking-widest">Visa Rate</div>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-900/20 border-y border-indigo-500/20 py-10 mb-12">
                        <h2 class="text-2xl font-serif italic text-white mb-8">Our Expertise</h2>
                         <div class="space-y-6 text-left px-4">
                            <div class="flex items-start gap-4 p-4 hover:bg-white/5 transition-colors">
                                <span class="text-xl">🎓</span>
                                <div>
                                    <h4 class="text-white font-serif italic text-lg mb-1">Study Abroad</h4>
                                    <p class="text-xs text-slate-400 leading-relaxed">Comprehensive guidance for UK, USA, and Australia.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 hover:bg-white/5 transition-colors">
                                <span class="text-xl">📋</span>
                                <div>
                                    <h4 class="text-white font-serif italic text-lg mb-1">Test Preparation</h4>
                                    <p class="text-xs text-slate-400 leading-relaxed">IELTS and PTE coaching by certified experts.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="w-full bg-indigo-600 text-white py-4 font-black text-xs uppercase tracking-widest hover:bg-indigo-500 transition-colors shadow-[0_0_20px_rgba(79,70,229,0.3)]">
                        Book Consultation
                    </button>
                    
                </div>
            </div>
        </div>

        <!-- Hotels & Restaurants Template -->
        <div id="template-hotels">
            <div class="bg-[#0c0a09] text-stone-200 font-sans min-h-screen relative overflow-hidden">
                <div class="relative h-[28rem]">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0c0a09] via-[#0c0a09]/50 to-black/30"></div>
                    
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                         <div class="flex items-center gap-3 mb-6 opacity-80">
                            <div class="w-8 h-px bg-white/60"></div>
                            <span class="text-stone-200 text-[10px] font-black uppercase tracking-[0.4em]">Est. 1998</span>
                            <div class="w-8 h-px bg-white/60"></div>
                        </div>
                        <h1 class="text-6xl font-serif italic text-white mb-8 tracking-tighter leading-none">Terra Cafe</h1>
                        <p class="text-stone-300 text-xs font-medium tracking-[0.2em] uppercase leading-loose mb-10">
                            Fine Dining & Hospitality
                        </p>
                         <button class="bg-white text-black px-10 py-4 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-stone-200 transition-colors">
                            Reserve Table
                        </button>
                    </div>
                </div>

                <div class="p-10 relative z-10">
                     <div class="text-center mb-12">
                        <span class="text-[#d4af37] text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">The Menu</span>
                        <h2 class="text-3xl font-serif italic text-white">Culinary Highlights</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-16">
                        <div class="group cursor-pointer">
                            <div class="aspect-square overflow-hidden mb-4 bg-stone-900 border border-white/5 relative">
                                <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&q=80" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                            </div>
                            <h4 class="text-lg font-serif italic text-white group-hover:text-[#d4af37] transition-colors">Signature Salad</h4>
                            <p class="text-[#d4af37] font-bold text-xs mt-1">Rs 850</p>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="aspect-square overflow-hidden mb-4 bg-stone-900 border border-white/5 relative">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&q=80" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                            </div>
                            <h4 class="text-lg font-serif italic text-white group-hover:text-[#d4af37] transition-colors">Truffle Pizza</h4>
                            <p class="text-[#d4af37] font-bold text-xs mt-1">Rs 1400</p>
                        </div>
                    </div>

                    <div class="border-t border-stone-800 pt-10 text-center">
                        <h3 class="text-2xl font-serif italic text-white mb-6">Guest Reviews</h3>
                         <p class="text-stone-400 text-sm leading-relaxed italic mb-4">"An unforgettable evening. The service was impeccable."</p>
                         <div class="text-[#d4af37] text-xs tracking-widest">★★★★★ — ALISHA K.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events & Photo Template -->
        <div id="template-photo">
            <div class="bg-[#171717] text-neutral-200 font-sans min-h-screen relative overflow-hidden">
                <div class="relative h-96 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#171717] via-[#171717]/60 to-black/30"></div>
                     <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                         <span class="text-rose-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Visual Stories</span>
                        <h1 class="text-6xl font-serif italic text-white mb-8 tracking-tighter">Raw Frames</h1>
                        <p class="text-neutral-300 text-xs font-medium tracking-[0.2em] uppercase leading-loose">
                            Weddings • Potraits • Events
                        </p>
                    </div>
                </div>

                <div class="p-8 relative z-10 -mt-10">
                    <div class="bg-[#262626] p-8 border border-white/5 text-center mb-12">
                         <h2 class="text-2xl font-serif italic text-white mb-6">The Gallery</h2>
                         <div class="grid grid-cols-2 gap-4">
                             <div class="aspect-[3/4] bg-neutral-800 overflow-hidden relative group">
                                 <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&q=80" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity">
                             </div>
                             <div class="space-y-4">
                                 <div class="aspect-square bg-neutral-800 overflow-hidden relative group">
                                     <img src="https://images.unsplash.com/photo-1520854221256-11451fbb3ba7?w=400&q=80" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity">
                                 </div>
                                 <div class="aspect-square bg-neutral-800 overflow-hidden relative group">
                                     <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&q=80" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity">
                                 </div>
                             </div>
                         </div>
                    </div>

                    <div class="text-center mb-12">
                        <span class="text-neutral-500 text-[10px] font-black uppercase tracking-[0.4em] mb-6 block">Packages</span>
                        <div class="space-y-4 text-left">
                            <div class="flex justify-between items-center border-b border-neutral-800 pb-4">
                                <h4 class="text-white font-serif italic text-lg">Wedding Day</h4>
                                <span class="text-rose-500 font-bold text-xs">Rs 85k</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-neutral-800 pb-4">
                                <h4 class="text-white font-serif italic text-lg">Portrait Session</h4>
                                <span class="text-rose-500 font-bold text-xs">Rs 15k</span>
                            </div>
                        </div>
                    </div>
                    
                    <button class="w-full bg-rose-600 text-white py-4 font-black text-xs uppercase tracking-widest hover:bg-rose-500 transition-colors shadow-[0_0_20px_rgba(225,29,72,0.3)]">
                        Check Availability
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
