@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image with Overlay -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#ff6b6b] to-[#4ecdc4] overflow-hidden">
        <!-- Background Image - Replace with your memory/gift related image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/login-bg.jpg') }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-[#ff6b6b]/90 to-[#4ecdc4]/80"></div>
        </div>
        
        <!-- Fallback Gradient if image doesn't exist -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#ff6b6b] via-[#ff5252] to-[#4ecdc4]"></div>
        
        <!-- Floating decorative elements -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-white/10 rounded-full blur-xl animate-pulse" style="animation-delay: 0.5s;"></div>
        
        <!-- Content Overlay -->
        <div class="relative z-10 flex flex-col justify-end p-12 text-white h-full">
            <div class="max-w-md animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight">
                    Create Beautiful Memories
                </h1>
                <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-8">
                    Design stunning gift websites and preserve your precious moments forever
                </p>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-lg font-semibold">Personalized Templates</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-lg font-semibold">Photo Galleries</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        <span class="text-lg font-semibold">Easy Sharing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-[#0f172a] relative">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" type="button" class="absolute top-6 right-6 z-50 p-3 rounded-xl bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-lg text-gray-700 dark:text-[#cbd5e1] hover:bg-white dark:hover:bg-[#1e293b] border border-gray-200/50 dark:border-[#334155]/50 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 group cursor-pointer" aria-label="Toggle dark mode">
            <svg id="moon-icon" class="w-6 h-6 dark:hidden transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg id="sun-icon" class="w-6 h-6 hidden dark:block transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </button>

        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <a href="/" class="inline-block mb-6 transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('assets/logo.png') }}" alt="Hamro Yaad" class="h-16 md:h-20 w-auto mx-auto">
                </a>
                <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Welcome Back</h2>
                <p class="text-gray-600 dark:text-[#cbd5e1]">Sign in to continue creating beautiful memories</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-[#334155]">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-500/10 border-2 border-green-200 dark:border-green-500/30 rounded-xl text-green-700 dark:text-green-400 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border-2 border-red-200 dark:border-red-500/30 rounded-xl text-red-700 dark:text-red-400 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border-2 border-red-200 dark:border-red-500/30 rounded-xl text-red-700 dark:text-red-400 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                            Email Address or Username
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300 @error('email') border-red-500 ring-2 ring-red-500/20 @enderror"
                               placeholder="Enter your email or username">
                        @error('email')
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                            Password
                        </label>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300 @error('password') border-red-500 ring-2 ring-red-500/20 @enderror"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-[#ff6b6b] focus:ring-[#ff6b6b] border-gray-300 dark:border-[#334155] rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-[#cbd5e1] cursor-pointer">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-sm text-[#ff6b6b] hover:text-[#ff5252] font-semibold transition-colors">
                            Forgot your password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" id="login-submit-btn" 
                                class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl font-bold text-lg tracking-wide hover:shadow-xl hover:shadow-[#ff6b6b]/30 transition-all duration-300 hover:-translate-y-0.5 transform relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <span>Sign In</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-[#cbd5e1] text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-[#ff6b6b] font-bold hover:text-[#ff5252] transition-colors hover:underline">
                            Create one here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const submitBtn = document.getElementById('login-submit-btn');
    
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Signing In...</span>
            </span>
        `;
    });
});
</script>
@endsection
