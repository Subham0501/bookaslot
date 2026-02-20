@extends('layouts.dashboard', ['title' => 'Overview'])

@section('content')
<div class="space-y-12">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Welcome back, {{ $business->business_name }}! 👋</h1>
            <p class="text-gray-500 dark:text-[#94a3b8]">Here's what's happening with your digital card today.</p>
        </div>
        <a href="/{{ $business->slug }}" target="_blank" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-8 py-3 rounded-2xl font-black flex items-center gap-2 hover:shadow-xl transition-all active:scale-95">
            <span>👁️</span> View Card
        </a>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-[#334155] hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 text-2xl mb-4">📱</div>
            <div class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($analytics['total_scans']) }}</div>
            <div class="text-sm font-bold text-gray-400 dark:text-[#94a3b8]">Total QR Scans</div>
        </div>
        <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-[#334155] hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-500 text-2xl mb-4">🛍️</div>
            <div class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($analytics['product_views']) }}</div>
            <div class="text-sm font-bold text-gray-400 dark:text-[#94a3b8]">Product Views</div>
        </div>
        <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-[#334155] hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500 text-2xl mb-4">💬</div>
            <div class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($analytics['whatsapp_clicks']) }}</div>
            <div class="text-sm font-bold text-gray-400 dark:text-[#94a3b8]">WhatsApp Inquiries</div>
        </div>
        <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-[#334155] hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 text-2xl mb-4">⭐</div>
            <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $business->plan == 'premium' ? 'Gold' : 'Basic' }}</div>
            <div class="text-sm font-bold text-gray-400 dark:text-[#94a3b8]">Membership Plan</div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- 👤 Profile Management -->
        <div class="bg-white dark:bg-[#1e293b] p-10 rounded-[3rem] shadow-xl border border-gray-100 dark:border-[#334155]">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-14 h-14 bg-[#ff6b6b]/10 rounded-2xl flex items-center justify-center text-3xl">👤</div>
                <h2 class="text-3xl font-black text-gray-900 dark:text-white">Profile Management</h2>
            </div>
            
            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside text-sm font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Business Logo -->
                    <div class="flex flex-col items-center gap-6 p-8 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border-2 border-dashed border-gray-200 dark:border-[#334155]">
                        @if($business->logo)
                            <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-200 dark:bg-[#1e293b] rounded-2xl flex items-center justify-center text-3xl">🏭</div>
                        @endif
                        <div class="text-center">
                            <label class="cursor-pointer bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-2 rounded-xl font-bold shadow-lg block mb-2 text-xs">
                                Update Logo
                                <input type="file" name="logo" class="hidden">
                            </label>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Square logo, max 2MB</p>
                        </div>
                    </div>

                    <!-- Professional Hero Photo (for Personal Theme) -->
                    <div class="flex flex-col items-center gap-6 p-8 bg-gray-50 dark:bg-[#0f172a] rounded-3xl border-2 border-dashed border-gray-200 dark:border-[#334155]">
                        @if($business->hero_image)
                            <img src="{{ Str::startsWith($business->hero_image, 'http') ? $business->hero_image : asset('storage/' . $business->hero_image) }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-200 dark:bg-[#1e293b] rounded-2xl flex items-center justify-center text-3xl">📸</div>
                        @endif
                        <div class="text-center">
                            <label class="cursor-pointer bg-blue-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg block mb-2 text-xs">
                                {{ $business->category == 'personal' ? 'Update Profile Photo' : 'Update Hero Banner' }}
                                <input type="file" name="hero_image" class="hidden">
                            </label>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">High quality, max 5MB</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">
                            {{ $business->category == 'personal' ? 'Full Name / Title' : 'Business Name' }}
                        </label>
                        <input type="text" name="business_name" value="{{ $business->business_name }}" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">
                            {{ $business->category == 'personal' ? 'Experience Since (Year)' : 'Established Year' }}
                        </label>
                        <input type="text" name="established_year" value="{{ $business->established_year }}" placeholder="e.g. 2024" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Business Category</label>
                        <div class="w-full bg-gray-100 dark:bg-[#0f172a]/50 border border-gray-200 dark:border-gray-800 rounded-2xl p-4 text-gray-400 dark:text-gray-500 font-bold flex justify-between items-center cursor-not-allowed">
                            <span>{{ ucwords(str_replace('_', ' ', $business->category)) }}</span>
                            <span class="text-[10px] bg-gray-200 dark:bg-gray-800 px-2 py-1 rounded-lg uppercase tracking-widest">Fixed</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">
                        {{ $business->category == 'personal' ? 'Professional Bio / Summary' : 'About Business' }}
                    </label>
                    <textarea name="description" rows="4" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold whitespace-pre-line">{{ $business->description }}</textarea>
                </div>

                @if($business->category == 'personal')
                <div class="space-y-6 pt-6 border-t border-gray-100 dark:border-[#334155]">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Core Specializations</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4 p-6 bg-gray-50 dark:bg-[#0f172a] rounded-3xl">
                            <label class="text-xs font-black text-blue-500 uppercase tracking-widest">Specialization 1</label>
                            <input type="text" name="spec_1_title" value="{{ $business->social_links['spec_1_title'] ?? 'Strategic Planning' }}" placeholder="Title" class="w-full bg-white dark:bg-[#1e293b] border-none rounded-xl p-3 text-sm font-bold">
                            <input type="text" name="spec_1_desc" value="{{ $business->social_links['spec_1_desc'] ?? 'Visionary approach to business growth.' }}" placeholder="Short Description" class="w-full bg-white dark:bg-[#1e293b] border-none rounded-xl p-3 text-sm font-medium text-gray-500">
                        </div>
                        <div class="space-y-4 p-6 bg-gray-50 dark:bg-[#0f172a] rounded-3xl">
                            <label class="text-xs font-black text-blue-500 uppercase tracking-widest">Specialization 2</label>
                            <input type="text" name="spec_2_title" value="{{ $business->social_links['spec_2_title'] ?? 'Elite Leadership' }}" placeholder="Title" class="w-full bg-white dark:bg-[#1e293b] border-none rounded-xl p-3 text-sm font-bold">
                            <input type="text" name="spec_2_desc" value="{{ $business->social_links['spec_2_desc'] ?? 'Managing high-performance teams.' }}" placeholder="Short Description" class="w-full bg-white dark:bg-[#1e293b] border-none rounded-xl p-3 text-sm font-medium text-gray-500">
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $business->whatsapp_number }}" placeholder="977..." class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Business Phone</label>
                        <input type="text" name="phone" value="{{ $business->phone }}" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Location (Google Maps Link)</label>
                    <input type="url" name="google_maps_link" value="{{ $business->google_maps_link }}" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Social Media Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">TikTok Link</label>
                            <input type="url" name="tiktok_link" value="{{ $business->social_links['tiktok'] ?? '' }}" placeholder="https://tiktok.com/@..." class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Instagram Link</label>
                            <input type="url" name="instagram_link" value="{{ $business->social_links['instagram'] ?? '' }}" placeholder="https://instagram.com/..." class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Facebook Link</label>
                            <input type="url" name="facebook_link" value="{{ $business->social_links['facebook'] ?? '' }}" placeholder="https://facebook.com/..." class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] text-gray-900 dark:text-white font-bold">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b6b] text-white rounded-2xl font-black text-xl hover:shadow-2xl hover:shadow-[#ff6b6b]/40 transition-all active:scale-95">
                    Update Profile
                </button>
            </form>
        </div>

        <!-- Quick Actions & Settings -->
        <div class="space-y-12">

        </div>
    </div>
</div>
@endsection
