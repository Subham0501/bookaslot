@extends('layouts.dashboard', ['title' => 'Create New Business Account'])

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div>
        <a href="{{ route('admin.businesses.index') }}" class="text-xs font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors flex items-center gap-2 mb-4">
            ← Back to Management
        </a>
        <h1 class="text-4xl font-black text-gray-900 dark:text-white">Create Business Account</h1>
        <p class="text-gray-500 dark:text-[#94a3b8] font-medium mt-2">Generate a new login ID and business profile for a partner business.</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-100 p-6 rounded-2xl text-red-600 text-sm font-bold">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.businesses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        
        <!-- User Credentials Section -->
        <div class="bg-white dark:bg-[#1e293b] p-10 rounded-[2.5rem] border border-gray-100 dark:border-[#334155] space-y-8 shadow-sm">
            <h3 class="text-sm font-black text-indigo-500 uppercase tracking-[0.2em]">1. Credentials (ID/Pass)</h3>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Owner Full Name</label>
                <input type="text" name="name" required placeholder="Full Name" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-xl p-4 focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:text-white font-bold">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Login Email (Used as ID)</label>
                <input type="email" name="email" required placeholder="business@email.com" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-xl p-4 focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:text-white font-bold">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-xl p-4 focus:ring-4 focus:ring-indigo-500/10 text-gray-900 dark:text-white font-bold">
            </div>
        </div>

        <div class="bg-white dark:bg-[#1e293b] p-10 rounded-[2.5rem] border border-gray-100 dark:border-[#334155] space-y-8 shadow-sm">
            <h3 class="text-sm font-black text-[#ff6b6b] uppercase tracking-[0.2em]">2. Business Identity</h3>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Public Business Name</label>
                <input type="text" name="business_name" required placeholder="e.g., Kumal Visuals" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-xl p-4 focus:ring-4 focus:ring-[#ff6b6b]/10 text-gray-900 dark:text-white font-bold">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Business Category</label>
                <select name="category" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-xl p-4 focus:ring-4 focus:ring-[#ff6b6b]/10 text-gray-900 dark:text-white font-bold appearance-none">
                    <option value="" disabled selected>Select Category</option>
                    <option value="ecommerce">Ecommerce Portfolio</option>
                    <option value="hotels">Hotels & Restaurants</option>
                    <option value="travel">Travel & Tour</option>
                    <option value="personal">Personal Portfolio</option>
                    <option value="consultancy">Consultancy</option>
                    <option value="photo">Events & Photo</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Custom URL Slug</label>
                <div class="flex items-center bg-gray-50 dark:bg-[#0f172a] rounded-xl pl-4 overflow-hidden border border-transparent focus-within:border-indigo-500/20">
                    <span class="text-gray-400 text-xs font-bold">hamroyaad.com/</span>
                    <input type="text" name="slug" required placeholder="slug" class="flex-grow bg-transparent border-none p-4 focus:ring-0 text-gray-900 dark:text-white font-black">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-indigo-600/30 hover:-translate-y-1 transition-all">
                    Create Account ✨
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
