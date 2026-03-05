@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image with Overlay -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#ff6b6b] to-[#4ecdc4] overflow-hidden">
        <!-- Background Image - Replace with your memory/gift related image -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/register-bg.jpg') }}');">
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
                    Start Your Journey
                </h1>
                <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-8">
                    Join thousands creating beautiful, personalized gift websites for their loved ones
                </p>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-lg font-semibold">Easy to Use</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-lg font-semibold">Unlimited Photos</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-lg font-semibold">Secure & Private</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-[#0f172a] relative overflow-y-auto">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" type="button" class="absolute top-6 right-6 z-50 p-3 rounded-xl bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-lg text-gray-700 dark:text-[#cbd5e1] hover:bg-white dark:hover:bg-[#1e293b] border border-gray-200/50 dark:border-[#334155]/50 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 group cursor-pointer" aria-label="Toggle dark mode">
            <svg id="moon-icon" class="w-6 h-6 dark:hidden transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg id="sun-icon" class="w-6 h-6 hidden dark:block transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </button>

        <div class="max-w-md w-full space-y-8 py-8">
            <!-- Header -->
            <div class="text-center">
                <a href="/" class="inline-block mb-6 transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('assets/stabndard.png') }}" alt="Hamro Yaad" class="h-16 md:h-20 w-auto mx-auto">
                </a>
                <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Create Account</h2>
                <p class="text-gray-600 dark:text-[#cbd5e1]">Start creating beautiful memories today</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-[#334155]">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border-2 border-red-200 dark:border-red-500/30 rounded-xl text-red-700 dark:text-red-400 text-sm font-semibold">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                @foreach($errors->all() as $error)
                                    <p class="mb-1">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300 @error('name') border-red-500 ring-2 ring-red-500/20 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300 @error('email') border-red-500 ring-2 ring-red-500/20 @enderror"
                               placeholder="Enter your email">
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
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300 @error('password') border-red-500 ring-2 ring-red-500/20 @enderror"
                               placeholder="Minimum 8 characters">
                        @error('password')
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                            Confirm Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-[#ff6b6b] transition-all duration-300"
                               placeholder="Re-enter your password">
                    </div>

                    <!-- Password Strength Indicator -->
                    <div id="password-strength" class="hidden">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-gray-600 dark:text-[#cbd5e1]">Password Strength:</span>
                            <div class="flex-1 h-2 bg-gray-200 dark:bg-[#334155] rounded-full overflow-hidden">
                                <div id="strength-bar" class="h-full transition-all duration-300 rounded-full"></div>
                            </div>
                            <span id="strength-text" class="text-xs font-semibold"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" id="register-submit-btn" 
                                class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl font-bold text-lg tracking-wide hover:shadow-xl hover:shadow-[#ff6b6b]/30 transition-all duration-300 hover:-translate-y-0.5 transform relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <span>Create Account</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-[#cbd5e1] text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-[#ff6b6b] font-bold hover:text-[#ff5252] transition-colors hover:underline">
                            Sign in
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
    const form = document.getElementById('register-form');
    const submitBtn = document.getElementById('register-submit-btn');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const strengthIndicator = document.getElementById('password-strength');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        return strength;
    }
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length > 0) {
            strengthIndicator.classList.remove('hidden');
            const strength = checkPasswordStrength(password);
            
            const percentage = (strength / 5) * 100;
            strengthBar.style.width = percentage + '%';
            
            if (strength <= 2) {
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-red-500';
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-xs font-semibold text-red-500';
            } else if (strength <= 3) {
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-yellow-500';
                strengthText.textContent = 'Fair';
                strengthText.className = 'text-xs font-semibold text-yellow-500';
            } else if (strength <= 4) {
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-blue-500';
                strengthText.textContent = 'Good';
                strengthText.className = 'text-xs font-semibold text-blue-500';
            } else {
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-green-500';
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-xs font-semibold text-green-500';
            }
        } else {
            strengthIndicator.classList.add('hidden');
        }
        
        // Check if passwords match
        if (passwordConfirmInput.value) {
            validatePasswordMatch();
        }
    });
    
    passwordConfirmInput.addEventListener('input', validatePasswordMatch);
    
    function validatePasswordMatch() {
        if (passwordInput.value && passwordConfirmInput.value) {
            if (passwordInput.value !== passwordConfirmInput.value) {
                passwordConfirmInput.classList.add('border-red-500', 'ring-2', 'ring-red-500/20');
            } else {
                passwordConfirmInput.classList.remove('border-red-500', 'ring-2', 'ring-red-500/20');
                passwordConfirmInput.classList.add('border-green-500');
                setTimeout(() => {
                    passwordConfirmInput.classList.remove('border-green-500');
                }, 1000);
            }
        }
    }
    
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Creating Account...</span>
            </span>
        `;
    });
});
</script>
@endsection
