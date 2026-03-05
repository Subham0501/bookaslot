@extends('layouts.app')

@section('content')
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-xl z-50 border-b border-gray-200 dark:border-[#334155] shadow-sm dark:shadow-[#1e293b]/50">
        <div class="w-full px-5 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex justify-between items-center h-20">
                <!-- Logo - Left Aligned -->
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="hover:opacity-80 transition-opacity flex items-center gap-3">
                        <img src="{{ asset('assets/stabndard.png') }}" alt="Hamro Yaad" class="h-16 md:h-20 w-auto">
                        <span class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] bg-clip-text text-transparent">Hamro Yaad</span>
                    </a>
                </div>
                
                <!-- Navigation Links - Right Aligned -->
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="/" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide relative group py-2">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#ff6b6b] group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide relative group py-2">
                        Contact
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
                <a href="/" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">Home</a>
                <a href="{{ route('contact') }}" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">Contact</a>
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

    <!-- About Section -->
    <section class="pt-32 pb-20 bg-white dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">About</span>
                    <span class="block text-[#ff6b6b]">Hamro Yaad</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Creating memories that last forever</p>
            </div>

            <!-- Content -->
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 md:p-12 shadow-xl border border-gray-200 dark:border-[#334155] space-y-8">
                    
                    <!-- Our Story -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Story</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            Hamro Yaad was born from a simple idea: to help people create and share beautiful, personalized memories in a digital format. We believe that every moment deserves to be celebrated and preserved in a way that makes hearts race.
                        </p>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed mt-4">
                            Whether it's a birthday, wedding, anniversary, or just because you remembered someone special, Hamro Yaad provides you with the tools to create stunning digital memory pages that can be shared instantly via link or QR code.
                        </p>
                    </div>

                    <!-- Our Mission -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            Our mission is to make it easy for everyone to create beautiful, personalized digital memories. We want to help you turn simple moments into thrilling surprises that can be shared with loved ones anywhere in the world.
                        </p>
                    </div>

                    <!-- What We Offer -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What We Offer</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-[#cbd5e1] ml-4">
                            <li>Customizable digital memory pages with beautiful templates</li>
                            <li>Easy-to-use interface for uploading photos and adding messages</li>
                            <li>Unique URLs and QR codes for easy sharing</li>
                            <li>Multiple template categories for different occasions</li>
                            <li>Secure and private memory pages</li>
                            <li>One-year validity with renewal options</li>
                        </ul>
                    </div>

                    <!-- Why Choose Us -->
                    <div class="bg-gradient-to-br from-[#ff6b6b]/10 to-[#ff5252]/10 dark:from-[#ff6b6b]/20 dark:to-[#ff5252]/20 rounded-2xl p-6 border-2 border-[#ff6b6b]/30">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Why Choose Hamro Yaad?</h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">✨ Easy & Fast</h3>
                                <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                                    Create your memory page in just minutes. Our intuitive interface makes it simple for anyone to create beautiful digital memories.
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">🎨 Beautiful Templates</h3>
                                <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                                    Choose from a variety of professionally designed templates for birthdays, weddings, anniversaries, and more.
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">📱 Share Instantly</h3>
                                <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                                    Share your memory page instantly via link or QR code. Perfect for surprising someone special!
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">💝 Lasting Memories</h3>
                                <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                                    Your memory page stays active for one year, giving you and your loved ones plenty of time to revisit those special moments.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50 dark:bg-[#0f172a] rounded-2xl p-6 border border-gray-200 dark:border-[#334155]">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Get in Touch</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed mb-4">
                            Have questions or need help? We're here for you!
                        </p>
                        <div class="space-y-3 text-gray-700 dark:text-[#cbd5e1]">
                            <p class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <strong>Email:</strong> <a href="mailto:hamroyaadpvt@gmail.com" class="text-[#ff6b6b] hover:underline">hamroyaadpvt@gmail.com</a>
                            </p>
                            <p class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <strong>Phone:</strong> <a href="tel:9845004365" class="text-[#ff6b6b] hover:underline">9845004365</a>
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('contact') }}" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                                Contact Us
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Back to Home Button -->
            <div class="text-center mt-12">
                <a href="/" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl text-lg font-bold tracking-wide hover:shadow-2xl hover:shadow-[#ff6b6b]/40 transition-all hover:-translate-y-1 transform">
                    Back to Home
                </a>
            </div>
        </div>
    </section>

    <style>
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

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        // Theme toggle functionality
        if (typeof window.toggleTheme === 'undefined') {
            window.toggleTheme = function(event) {
                event.preventDefault();
                const html = document.documentElement;
                const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.classList.remove(currentTheme);
                html.classList.add(newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Update icons
                document.querySelectorAll('.dark\\:hidden').forEach(el => {
                    if (newTheme === 'dark') {
                        el.classList.add('hidden');
                    } else {
                        el.classList.remove('hidden');
                    }
                });
                document.querySelectorAll('.hidden.dark\\:block').forEach(el => {
                    if (newTheme === 'dark') {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
            };
        }

        // Initialize theme
        (function() {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        })();

        // Theme toggle button
        document.getElementById('theme-toggle')?.addEventListener('click', window.toggleTheme);
    </script>
@endsection

