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
                    <a href="{{ route('about') }}" class="text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide relative group py-2">
                        About
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
                <a href="{{ route('about') }}" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">About</a>
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

    <!-- Contact Section -->
    <section class="pt-32 pb-20 bg-white dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">Get in</span>
                    <span class="block text-[#ff6b6b]">Touch</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">We'd love to hear from you. Reach out to us anytime!</p>
            </div>

            <!-- Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Information Card -->
                <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 md:p-12 shadow-xl border border-gray-200 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Contact Information</h2>
                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Email</h3>
                                <a href="mailto:hamroyaadpvt@gmail.com" class="text-[#ff6b6b] hover:underline text-gray-700 dark:text-[#cbd5e1]">
                                    hamroyaadpvt@gmail.com
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Phone</h3>
                                <a href="tel:9845004365" class="text-[#ff6b6b] hover:underline text-gray-700 dark:text-[#cbd5e1]">
                                    9845004365
                                </a>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="pt-6 border-t border-gray-200 dark:border-[#334155]">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Follow Us</h3>
                            <div class="flex gap-4">
                                <a href="https://www.facebook.com/profile.php?id=61569794637986" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 dark:bg-[#334155] rounded-lg flex items-center justify-center hover:bg-[#ff6b6b] hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://www.instagram.com/hamro_yaad?igsh=MTZrYmdhYnpkajNiOQ%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 dark:bg-[#334155] rounded-lg flex items-center justify-center hover:bg-[#ff6b6b] hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                <a href="https://www.tiktok.com/@hamro.yaad?_r=1&_t=ZS-92tcIgnLALRtiktok" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 dark:bg-[#334155] rounded-lg flex items-center justify-center hover:bg-[#ff6b6b] hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Card -->
                <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 md:p-12 shadow-xl border border-gray-200 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send us a Message</h2>
                    <form action="mailto:hamroyaadpvt@gmail.com" method="post" enctype="text/plain" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Name</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all transform hover:-translate-y-0.5">
                            Send Message
                        </button>
                    </form>
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

