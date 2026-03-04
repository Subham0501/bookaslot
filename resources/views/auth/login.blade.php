@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-white">
    <!-- Left Side - Brand Showcase -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#010514] overflow-hidden">
        <!-- Abstract Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100" stroke="white" fill="transparent" stroke-width="0.1"/>
                <path d="M0 0 C 50 100 80 100 100 0" stroke="white" fill="transparent" stroke-width="0.1"/>
            </svg>
        </div>
        
        <!-- Animated Gradient Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] bg-[#3D5AFE]/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-[#3D5AFE]/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <!-- Content Overlay -->
        <div class="relative z-10 flex flex-col justify-center p-24 text-white h-full">
            <div class="max-w-xl">
                <a href="/" class="flex items-center gap-3 mb-20 group">
                    <img src="{{ asset('assets/bookinglogo.jpeg') }}" alt="BookingArc Logo" class="h-12 w-auto object-contain transition-transform group-hover:scale-110">
                    <span class="text-3xl font-black tracking-tighter uppercase italic text-white">BookingArc</span>
                </a>

                <h1 class="text-7xl font-black mb-10 leading-[0.95] tracking-[-0.05em] uppercase italic">
                    Manage Your<br><span class="text-[#3D5AFE]">Digital Presence.</span>
                </h1>
                
                <p class="text-xl text-white/50 font-medium leading-relaxed mb-16 tracking-tight max-w-md">
                    Access your master dashboard to update your mini-website, track analytics, and manage products.
                </p>

                <div class="space-y-8">
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl transition-all group-hover:bg-[#3D5AFE] group-hover:border-[#3D5AFE]">📊</div>
                        <div>
                            <p class="text-[13px] font-black uppercase tracking-widest text-white/40 mb-1">Analytics</p>
                            <p class="text-lg font-bold">Real-time Performance Metrics</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl transition-all group-hover:bg-[#3D5AFE] group-hover:border-[#3D5AFE]">🛍️</div>
                        <div>
                            <p class="text-[13px] font-black uppercase tracking-widest text-white/40 mb-1">Management</p>
                            <p class="text-lg font-bold">Unlimited Product Updates</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="absolute bottom-16 left-24">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-white/20">© 2026 BookingArc LTD.</p>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-12 bg-white">
        <div class="max-w-md w-full">
            <!-- Header -->
            <div class="mb-16">
                <h2 class="text-[44px] font-black text-[#010514] leading-none mb-4 tracking-tighter uppercase italic">Dashboard Login</h2>
                <p class="text-gray-400 font-medium text-lg leading-snug tracking-tight">Enter your credentials to manage your professional slot.</p>
            </div>

            <!-- Login Form -->
            <div class="space-y-10">
                @if($errors->any())
                    <div class="p-5 bg-red-50 border border-red-100 rounded-[30px] text-red-600 text-[13px] font-bold flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">!</div>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-3">
                        <label for="email" class="text-[11px] font-black text-[#010514] uppercase tracking-widest pl-4">
                            Business Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                               class="w-full px-8 py-5 rounded-full border border-gray-100 bg-gray-50/50 text-[#010514] font-bold text-[15px] focus:ring-2 focus:ring-[#3D5AFE] focus:border-transparent transition-all outline-none placeholder:text-gray-300"
                               placeholder="your@email.com">
                    </div>

                    <!-- Password -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between px-4">
                            <label for="password" class="text-[11px] font-black text-[#010514] uppercase tracking-widest">
                                Password
                            </label>
                            <a href="#" class="text-[10px] font-black text-[#3D5AFE] uppercase tracking-widest hover:underline">Forgot?</a>
                        </div>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-8 py-5 rounded-full border border-gray-100 bg-gray-50/50 text-[#010514] font-bold text-[15px] focus:ring-2 focus:ring-[#3D5AFE] focus:border-transparent transition-all outline-none placeholder:text-gray-300"
                               placeholder="••••••••">
                    </div>

                    <!-- Options -->
                    <div class="flex items-center px-4">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative w-5 h-5">
                                <input type="checkbox" name="remember" class="peer hidden">
                                <div class="w-full h-full border-2 border-gray-200 rounded-lg group-hover:border-[#3D5AFE] peer-checked:bg-[#3D5AFE] peer-checked:border-[#3D5AFE] transition-all"></div>
                                <svg class="absolute inset-0 w-full h-full text-white opacity-0 peer-checked:opacity-100 p-1 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-[12px] font-bold text-gray-500 uppercase tracking-tight">Keep me signed in</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full bg-[#3D5AFE] text-white py-6 rounded-full font-black uppercase text-[15px] tracking-[0.2em] shadow-2xl hover:bg-[#010514] transition-all transform active:scale-[0.98]">
                        Access Dashboard ↗
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="text-center pt-8 border-t border-gray-50">
                    <p class="text-gray-400 font-bold text-[13px] uppercase tracking-tighter">
                        New professional? 
                        <a href="https://wa.me/9845004365" target="_blank" class="text-[#3D5AFE] border-b-2 border-transparent hover:border-[#3D5AFE] transition-all flex items-center justify-center gap-2 mt-2">
                            <span>Create your slot here</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Call to Action (Login Page) -->
<div class="bg-gray-50 py-12 px-6 border-t border-gray-100">
    <div class="max-w-4xl mx-auto">
        <div class="bg-primary rounded-[40px] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl shadow-primary/20">
            <div class="relative z-10 text-center md:text-left">
                <h3 class="text-xl md:text-2xl font-black text-white uppercase italic tracking-tighter mb-2">New professional?</h3>
                <p class="text-white/70 font-medium text-sm">Create your professional slot today and join our network.</p>
            </div>
            <a href="https://wa.me/9845004365" target="_blank" class="relative z-10 bg-white text-primary px-10 py-4 rounded-full text-[13px] font-black uppercase tracking-widest hover:bg-navy hover:text-white transition-all shadow-xl flex items-center gap-3">
                <span>Contact Now</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
            </a>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    input::placeholder { font-weight: 500; }
</style>
@endsection
