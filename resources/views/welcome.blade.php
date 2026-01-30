@extends('layouts.app')

@section('content')
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
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-all ml-2">
                                Logout
                            </button>
                        </form>
                    @endauth
                    <a href="{{ route('create') }}" class="bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-2.5 rounded-lg hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-[15px] font-semibold tracking-wide ml-2">
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
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" onclick="toggleMobileMenu()" class="w-full text-left p-2 rounded-lg text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1e293b] transition-all text-[15px] font-medium tracking-wide">
                            Logout
                        </button>
                    </form>
                @endauth
                <a href="{{ route('create') }}" class="block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-2.5 rounded-lg hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-[15px] font-semibold tracking-wide text-center" onclick="toggleMobileMenu()">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20 bg-white dark:bg-[#0f172a]">
        <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Side - Image -->
                <div class="order-2 lg:order-1 flex justify-center lg:justify-start">
                    <div class="relative group max-w-xs lg:max-w-sm w-full">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl transform group-hover:scale-[1.02] transition-transform duration-300">
                            <img src="{{ asset('assets/image_1_1765817075593.jpg') }}" alt="Hamro Yaad Memory" class="w-full h-auto object-cover rounded-3xl">
                        </div>
                    </div>
        </div>
        
                <!-- Right Side - Content -->
                <div class="order-1 lg:order-2 text-center lg:text-left space-y-8">
                    <!-- Main Heading -->
                    <div class="space-y-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-[#cbd5e1]">
                            Don't give a traditional gift.
                </h2>
                        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black leading-[1.1] tracking-tight">
                            <span class="block text-gray-900 dark:text-white">Give something</span>
                            <span class="block text-[#ff6b6b]">that makes the heart race.</span>
                </h1>
                    </div>
                    
                    <!-- Subheading -->
                    <p class="text-xl md:text-2xl text-gray-600 dark:text-[#cbd5e1] leading-relaxed">
                        Turn simple moments into thrilling surprises.
                    </p>
                    
                    <p class="text-lg md:text-xl text-gray-600 dark:text-[#94a3b8]">
                        Whether it's a birthday, wedding, or just because you remembered — create your unique memory now and send it to someone you love.
                    </p>
                    
                    <p class="text-base md:text-lg text-gray-500 dark:text-[#94a3b8]">
                        In just minutes, you'll have everything ready to eternalize a feeling.
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="pt-4">
                        <a href="{{ route('create') }}" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-10 py-4 rounded-xl text-lg md:text-xl font-bold tracking-wide hover:shadow-2xl hover:shadow-[#ff6b6b]/40 transition-all hover:-translate-y-1 transform">
                            Create your memory
                        </a>
                    </div>
                </div>
            </div>
                
                <!-- Hero Images Gallery -->
                <div class="pt-12 pb-8">
                    
                    
                    <!-- User Images Carousel -->
                    <div class="flex justify-center items-center gap-4 overflow-hidden">
                        <div class="flex gap-4 animate-scroll">
                            @php
                                $images = [
                                    asset('assets/img 1.jpg'),
                                    asset('assets/img2.jpg'),
                                    asset('assets/img 3.jpg'),
                                    asset('assets/img 4.jpg'),
                                    asset('assets/img 5.jpg'),
                                    asset('assets/img 6.jpg'),
                                    asset('assets/img 7.jpg'),
                                    asset('assets/img 8.jpg'),
                                ];
                                // Duplicate images for seamless infinite scroll
                                $images = array_merge($images, $images);
                            @endphp
                            @foreach($images as $index => $image)
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border-4 border-white dark:border-[#1e293b] shadow-lg flex-shrink-0 bg-gray-100 dark:bg-[#1e293b] relative">
                                <img src="{{ $image }}" alt="Memory {{ $index + 1 }}" class="absolute inset-0 w-full h-full object-cover" style="object-position: center 25%;">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-lg md:text-xl font-bold text-gray-700 dark:text-[#cbd5e1] mt-6">
                        125+ memories eternalized
                    </p>
                </div>
            </div>
        </div>

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
                    <a href="{{ route('create') }}" class="inline-block text-[#ff6b6b] font-bold hover:text-[#ff5252] transition-colors">
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
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Fill in the fields</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">Follow the form steps and build your memory.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#4ecdc4]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#4ecdc4] to-[#45b8b0] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">2</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Payment</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow mb-3">Make a secure payment using Credit Card or Bank Transfer.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffd93d]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ffd93d] to-[#ffc107] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">3</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">QR Code and Link</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">You'll instantly receive the QR code and a link via email to access your memory.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155] overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff8fab]/10 to-transparent rounded-bl-full"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#ff8fab] to-[#ff6b9d] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white font-black text-2xl">4</span>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-900 dark:text-white text-center">Share the Memory</h3>
                        <p class="text-gray-600 dark:text-[#cbd5e1] leading-relaxed text-sm text-center flex-grow">Surprise someone or save your memory by sharing the link or QR code.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('create') }}" class="inline-block bg-[#ff6b6b] text-white px-10 py-4 rounded-xl text-lg font-black tracking-wide hover:bg-[#ff5252] transition-all shadow-2xl shadow-[#ff6b6b]/30 hover:shadow-[#ff6b6b]/40 hover:-translate-y-0.5">
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

    <!-- Gifts Section -->
    <section id="gifts" class="py-32 bg-white dark:bg-[#0f172a]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">Choose Your Perfect</span>
                    <span class="block text-[#ff6b6b]">Gift</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-[#cbd5e1] max-w-2xl mx-auto">
                    Buy directly or customize with addons to make it extra special.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @forelse($gifts ?? [] as $gift)
                <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155]">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b]/10 to-transparent rounded-bl-full"></div>
                    
                    <!-- Gift Image -->
                    <div class="relative h-64 overflow-hidden bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100 dark:from-[#1e293b] dark:via-[#0f172a] dark:to-[#1e293b]">
                        @if($gift->image && file_exists(storage_path('app/public/' . $gift->image)))
                            <img 
                                src="{{ asset('storage/' . $gift->image) }}" 
                                alt="{{ $gift->name }}" 
                                class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center gap-3\'><svg class=\'w-20 h-20 text-gray-400 dark:text-gray-600\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><span class=\'text-xs text-gray-500 dark:text-gray-500\'>No Image</span></div>';"
                            >
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-3">
                                <div class="relative">
                                    <svg class="w-20 h-20 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">Gift Image</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Gift Content -->
                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-black mb-2 text-gray-900 dark:text-white">{{ $gift->name }}</h3>
                        @if($gift->description)
                            <p class="text-gray-600 dark:text-[#cbd5e1] mb-4 line-clamp-2">{{ $gift->description }}</p>
                        @endif
                        
                        <div class="mb-6">
                            <span class="text-3xl font-black text-[#ff6b6b]">Rs. {{ number_format($gift->price, 2) }}</span>
                        </div>
                        
                        <a href="{{ route('gifts.quick-buy', $gift->id) }}" class="block w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl text-center font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all mb-3">
                            Buy Now
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 dark:text-[#cbd5e1] text-lg">No gifts available at the moment. Check back soon!</p>
                </div>
                @endforelse
            </div>

            <!-- Customize Gift Option -->
            <div class="text-center mt-16">
                <div class="bg-gradient-to-r from-[#ff6b6b]/10 to-[#ff5252]/10 dark:from-[#ff6b6b]/20 dark:to-[#ff5252]/20 rounded-3xl p-12 border-2 border-[#ff6b6b]/20">
                    <h3 class="text-3xl md:text-4xl font-black mb-4 text-gray-900 dark:text-white">
                        Want to Customize Your Gift?
                    </h3>
                    <p class="text-xl text-gray-600 dark:text-[#cbd5e1] mb-8 max-w-2xl mx-auto">
                        Add photo frames, chocolates, flowers, and more to make your gift extra special!
                    </p>
                    <a href="{{ route('gifts.index') }}" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-10 py-4 rounded-xl text-lg font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                        Customize Gift
                    </a>
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
                    ['q' => 'What is Hamro Yaad?', 'a' => 'Hamro Yaad is a platform where you can create beautiful, personalized gift websites. Share your story, photos, and messages with a custom website that you can share via link or QR code.'],
                    ['q' => 'What can I include in my website?', 'a' => 'Your website can include custom text, multiple photos, personalized messages, custom colors, and sections. You\'ll also get a unique link and QR code to share.'],
                    ['q' => 'Does my website expire?', 'a' => 'Your website is valid for 1 year from the date of creation. After 1 year, you need to renew it to keep it accessible through your unique link.'],
                    ['q' => 'How quickly will I get my website link?', 'a' => 'You\'ll receive your unique link and QR code immediately via email after completing your website customization.'],
                    ['q' => 'How can I get help if I need it?', 'a' => 'You can reach out through our support email or social media channels. Our team is here to help ensure your website is perfect.'],
                    ['q' => 'What payment methods do you accept?', 'a' => 'We accept secure payments via Bank Transfer, eSewa, Credit Card, and other major payment methods for your convenience.'],
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

    <script>
        function toggleFaq(index) {
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
@endsection
