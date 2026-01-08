<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hamro Yaad - Custom Gifting Made Easy')</title>
    <meta name="description" content="Create beautiful custom gift websites for any occasion. Personalize templates, add QR codes, and share your love with the world.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'theme-color': 'var(--theme-color, #4ecdc4)',
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        /* Theme color variable */
        :root {
            --theme-color: #4ecdc4;
        }
        
        .theme-bg {
            background: var(--theme-color);
        }
        
        .theme-bg-opacity {
            background: rgba(78, 205, 196, 0.9);
        }
    </style>
    
    <!-- Initialize theme immediately in head -->
    <script>
        (function() {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="bg-[#0a0a0a] text-white antialiased" style="scroll-behavior: smooth;">
    @yield('content')
    
    <!-- Theme Toggle Script - At end of body for better reliability -->
    <script>
        (function() {
            'use strict';
            
            const html = document.documentElement;
            let themeToggleInitialized = false;
            
            // Theme toggle function
            function toggleTheme(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }
                
                const isDark = html.classList.contains('dark');
                
                if (isDark) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    console.log('Theme changed to: light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    console.log('Theme changed to: dark');
                }
                
                return false;
            }
            
            // Make it globally accessible
            window.toggleTheme = toggleTheme;
            
            // Event handler for theme toggle buttons using event delegation
            function handleThemeToggle(e) {
                const target = e.target.closest('#theme-toggle, #theme-toggle-nav');
                if (target) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleTheme(e);
                }
            }
            
            // Set up event delegation once
            function setupThemeToggles() {
                if (!themeToggleInitialized) {
                    document.addEventListener('click', handleThemeToggle, true);
                    themeToggleInitialized = true;
                    console.log('Theme toggle event delegation set up');
                }
            }
            
            // Run setup when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setupThemeToggles();
                });
            } else {
                setupThemeToggles();
            }
        })();
        
    
        function toggleMobileMenu(button) {
            // Get the button element (passed from onclick or find it)
            const clickedButton = button || (event ? event.target.closest('#mobile-menu-toggle') : document.querySelector('#mobile-menu-toggle'));
            
            if (!clickedButton) return;
            
            // Find the menu associated with this button (should be in the same nav)
            const nav = clickedButton.closest('nav');
            const menu = nav ? nav.querySelector('#mobile-menu') : document.querySelector('#mobile-menu');
            const menuIcon = clickedButton.querySelector('#menu-icon');
            const closeIcon = clickedButton.querySelector('#close-icon');
            
            if (menu && menuIcon && closeIcon) {
                const isHidden = menu.classList.contains('hidden');
                
                // Close all other menus first
                document.querySelectorAll('#mobile-menu').forEach(m => {
                    if (m !== menu) {
                        m.classList.add('hidden');
                    }
                });
                document.querySelectorAll('#mobile-menu-toggle').forEach(btn => {
                    if (btn !== clickedButton) {
                        const mi = btn.querySelector('#menu-icon');
                        const ci = btn.querySelector('#close-icon');
                        if (mi && ci) {
                            mi.classList.remove('hidden');
                            ci.classList.add('hidden');
                        }
                    }
                });
                
                // Toggle current menu
                if (isHidden) {
                    menu.classList.remove('hidden');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    menu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            }
        }
        
        // Make it globally accessible
        window.toggleMobileMenu = toggleMobileMenu;
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menus = document.querySelectorAll('#mobile-menu');
            const toggleButtons = document.querySelectorAll('#mobile-menu-toggle');
            
            menus.forEach((menu, index) => {
                const toggleButton = toggleButtons[index];
                if (menu && toggleButton && !menu.contains(e.target) && !toggleButton.contains(e.target)) {
                    if (!menu.classList.contains('hidden')) {
                        const menuIcon = toggleButton.querySelector('#menu-icon');
                        const closeIcon = toggleButton.querySelector('#close-icon');
                        if (menuIcon && closeIcon) {
                            menu.classList.add('hidden');
                            menuIcon.classList.remove('hidden');
                            closeIcon.classList.add('hidden');
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
