@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image with Overlay -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#ff6b6b] to-[#4ecdc4] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/login-bg.jpg') }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-[#ff6b6b]/90 to-[#4ecdc4]/80"></div>
        </div>
        
        <!-- Fallback Gradient if image doesn't exist -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#ff6b6b] via-[#ff5252] to-[#4ecdc4]"></div>
        
        <!-- Floating decorative elements -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <!-- Content Overlay -->
        <div class="relative z-10 flex flex-col justify-center p-12 text-white h-full">
            <div class="max-w-md animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight">
                    Verify Your Email
                </h1>
                <p class="text-xl md:text-2xl text-white/90 leading-relaxed">
                    We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side - Verification Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-[#0f172a]">
        <div class="w-full max-w-md space-y-8 animate-fade-in">
            <!-- Logo/Title -->
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2">
                    Check Your Email
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    We've sent a verification link to <strong>{{ Auth::user()->email }}</strong>
                </p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-4 flex items-start gap-3 animate-fade-in">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-4 flex items-start gap-3 animate-fade-in">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Verification Info Card -->
            <div class="bg-gradient-to-br from-[#ff6b6b]/10 to-[#4ecdc4]/10 dark:from-[#ff6b6b]/20 dark:to-[#4ecdc4]/20 border-2 border-[#ff6b6b]/20 dark:border-[#ff6b6b]/30 rounded-xl p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-[#ff6b6b] rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Verification Email Sent</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Click the link in the email to verify your account</p>
                    </div>
                </div>
            </div>

            <!-- Resend Verification Email Form -->
            <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] hover:from-[#ff5252] hover:to-[#ff6b6b] text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#ff6b6b]/50">
                    Resend Verification Email
                </button>
            </form>

            <!-- Additional Info -->
            <div class="text-center space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Didn't receive the email? Check your spam folder or click the button above to resend.
                </p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-[#ff6b6b] hover:text-[#ff5252] font-semibold transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

