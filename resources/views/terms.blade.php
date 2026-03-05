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
                <a href="/" class="block text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white transition-colors text-[15px] font-medium tracking-wide py-2" onclick="toggleMobileMenu()">Home</a>
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

    <!-- Terms and Conditions Section -->
    <section class="pt-32 pb-20 bg-white dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">Terms and</span>
                    <span class="block text-[#ff6b6b]">Conditions</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <!-- Content -->
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 md:p-12 shadow-xl border border-gray-200 dark:border-[#334155] space-y-8">
                    
                    <!-- Introduction -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Introduction</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            Welcome to Hamro Yaad. These Terms and Conditions ("Terms") govern your use of our service for creating and sharing digital memory pages. By using our service, you agree to be bound by these Terms.
                        </p>
                    </div>

                    <!-- Service Description -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. Service Description</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            Hamro Yaad provides a platform for creating personalized digital memory pages that can be shared via unique URLs. Our service allows you to upload images, add messages, customize designs, and share your memories with others.
                        </p>
                    </div>

                    <!-- Website URL Validity and Renewal -->
                    <div class="bg-gradient-to-br from-[#ff6b6b]/10 to-[#ff5252]/10 dark:from-[#ff6b6b]/20 dark:to-[#ff5252]/20 rounded-2xl p-6 border-2 border-[#ff6b6b]/30">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            3. Website URL Validity and Renewal
                        </h2>
                        <div class="space-y-4">
                            <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed font-medium">
                                <strong class="text-[#ff6b6b]">Important:</strong> Your memory page URL will be active and accessible for <strong class="text-gray-900 dark:text-white">one (1) year</strong> from the date of purchase/activation.
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-[#cbd5e1] ml-4">
                                <li>The URL will remain active for exactly 365 days from the activation date.</li>
                                <li>After the one-year period expires, the URL will become inactive and inaccessible.</li>
                                <li>To continue using the same URL, you must renew your subscription by paying the renewal charges.</li>
                                <li>Renewal charges will be applicable for each additional year of service.</li>
                                <li>We will notify you via email before your URL expires, providing you with the option to renew.</li>
                                <li>If you choose not to renew, your memory page and all associated data will be archived and may be permanently deleted after a grace period.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Payment Terms -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Payment Terms</h2>
                        <div class="space-y-4">
                            <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                                Payment for the initial service and any renewals must be made through the payment methods we accept (including but not limited to bank transfer, eSewa, and other digital payment platforms).
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-[#cbd5e1] ml-4">
                                <li>All payments are non-refundable unless otherwise stated.</li>
                                <li>Renewal charges are due before the expiration date to ensure uninterrupted service.</li>
                                <li>Failure to pay renewal charges will result in the URL becoming inactive.</li>
                                <li>We reserve the right to change our pricing with prior notice.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- User Responsibilities -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. User Responsibilities</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-[#cbd5e1] ml-4">
                            <li>You are responsible for maintaining the confidentiality of your PIN and account information.</li>
                            <li>You must ensure that all content you upload complies with applicable laws and does not infringe on any third-party rights.</li>
                            <li>You agree not to use the service for any illegal, harmful, or unauthorized purposes.</li>
                            <li>You are responsible for backing up any important data, as we are not liable for data loss.</li>
                        </ul>
                    </div>

                    <!-- Content Ownership -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Content Ownership</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            You retain ownership of all content you upload to our platform. However, by using our service, you grant us a license to store, display, and serve your content through our platform for the duration of your active subscription.
                        </p>
                    </div>

                    <!-- Limitation of Liability -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">7. Limitation of Liability</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            Hamro Yaad shall not be liable for any indirect, incidental, special, or consequential damages arising from the use or inability to use our service. Our total liability shall not exceed the amount you paid for the service.
                        </p>
                    </div>

                    <!-- Termination -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">8. Termination</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            We reserve the right to terminate or suspend your access to the service at any time, with or without cause, if you violate these Terms or engage in any fraudulent or illegal activity.
                        </p>
                    </div>

                    <!-- Changes to Terms -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">9. Changes to Terms</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed">
                            We reserve the right to modify these Terms at any time. We will notify users of any significant changes via email or through our website. Continued use of the service after changes constitutes acceptance of the new Terms.
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50 dark:bg-[#0f172a] rounded-2xl p-6 border border-gray-200 dark:border-[#334155]">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">10. Contact Us</h2>
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed mb-4">
                            If you have any questions about these Terms and Conditions, please contact us:
                        </p>
                        <div class="space-y-2 text-gray-700 dark:text-[#cbd5e1]">
                            <p><strong>Email:</strong> support@hamroyaad.com</p>
                            <p><strong>Website:</strong> <a href="{{ url('/') }}" class="text-[#ff6b6b] hover:underline">{{ url('/') }}</a></p>
                        </div>
                    </div>

                    <!-- Acceptance -->
                    <div class="pt-6 border-t border-gray-200 dark:border-[#334155]">
                        <p class="text-gray-700 dark:text-[#cbd5e1] leading-relaxed text-center">
                            By using Hamro Yaad, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.
                        </p>
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

