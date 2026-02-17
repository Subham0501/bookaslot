@extends('layouts.dashboard', ['title' => 'Setup Your Business'])

@section('content')
<div class="max-w-2xl mx-auto py-20 text-center">
    <div class="w-24 h-24 bg-[#ff6b6b]/10 rounded-3xl flex items-center justify-center text-5xl mx-auto mb-8 animate-bounce">🚀</div>
    <h1 class="text-5xl font-black text-gray-900 dark:text-white mb-4 leading-tight">Ready to go digital?</h1>
    <p class="text-xl text-gray-500 dark:text-[#94a3b8] mb-12">Set up your business profile in seconds and start sharing your magic via QR code.</p>

    <form action="{{ route('dashboard.profile.update') }}" method="POST" class="bg-white dark:bg-[#1e293b] p-12 rounded-[3.5rem] shadow-2xl border border-gray-100 dark:border-[#334155] text-left space-y-8">
        @csrf
        <div class="space-y-2">
            <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Business Name</label>
            <input type="text" name="business_name" required placeholder="e.g., Kumal Visuals, Urban Clutter" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-5 focus:ring-4 focus:ring-[#ff6b6b]/20 text-gray-900 dark:text-white font-bold text-lg">
        </div>

        <div class="space-y-4">
             <label class="text-sm font-black text-gray-700 dark:text-[#cbd5e1] uppercase tracking-widest">Choose Your Link</label>
             <div class="flex items-center bg-gray-50 dark:bg-[#0f172a] rounded-2xl p-1 pl-5">
                 <span class="text-gray-400 font-bold">hamroyaad.com/</span>
                 <input type="text" name="slug" required placeholder="yourname" class="flex-grow bg-transparent border-none p-4 focus:ring-0 text-gray-900 dark:text-white font-black text-lg">
             </div>
             <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">This will be your unique QR destination.</p>
        </div>

        <button type="submit" class="w-full py-6 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white rounded-[2rem] font-black text-2xl shadow-2xl shadow-[#ff6b6b]/40 hover:-translate-y-1 transition-all active:scale-95">
             Create My Digital Card ✨
        </button>
    </form>
</div>
@endsection
