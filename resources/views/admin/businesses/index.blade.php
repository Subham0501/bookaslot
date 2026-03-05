@extends('layouts.dashboard', ['title' => 'Business Management'])

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white">Business Management</h1>
            <p class="text-gray-500 dark:text-[#94a3b8] font-medium mt-2">Manage business user accounts and their digital link availability.</p>
        </div>
        <a href="{{ route('admin.businesses.create') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-600/20 hover:-translate-y-1 transition-all">
            ＋ Create New Business
        </a>
    </div>

    <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] border border-gray-100 dark:border-[#334155] overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-50 dark:border-[#0f172a]">
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Business Detail</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Owner (Login Email)</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-[#0f172a]">
                @foreach($businesses as $business)
                <tr class="group hover:bg-gray-50 dark:hover:bg-[#0f172a] transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-[#0f172a] rounded-xl flex items-center justify-center text-xl">
                                @if($business->logo)
                                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    🏢
                                @endif
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 dark:text-white text-lg">{{ $business->business_name }}</h4>
                                <a href="{{ $business->profile_url }}" target="_blank" class="text-xs text-indigo-500 font-bold tracking-tight hover:underline italic">{{ str_replace(['http://', 'https://'], '', $business->profile_url) }}</a>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-gray-900 dark:text-[#cbd5e1] font-bold">{{ $business->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400 font-medium">{{ $business->user->email ?? 'N/A' }}</div>
                    </td>
                    <td class="px-8 py-6">
                        @if($business->is_active)
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full text-[10px] font-black uppercase tracking-widest">Active</span>
                        @else
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest">Inactive</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2 text-center items-center">
                            @php
                                $isFeatured = \App\Models\Setting::get('home_featured_business_id') == $business->id && \App\Models\Setting::get('home_featured_business_enabled');
                            @endphp
                            <form action="{{ route('admin.businesses.toggle-featured', $business->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="p-3 {{ $isFeatured ? 'bg-amber-100 text-amber-500 hover:bg-amber-500' : 'bg-gray-50 text-gray-400 hover:bg-amber-500' }} rounded-xl hover:text-white transition-all flex flex-col items-center gap-1 group"
                                        title="{{ $isFeatured ? 'Currently showcased' : 'Showcase on Home' }}">
                                    <svg class="w-5 h-5" fill="{{ $isFeatured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.673c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span class="text-[8px] font-black uppercase tracking-tighter hidden group-hover:block">{{ $isFeatured ? 'Featured' : 'Showcase' }}</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this business and its user account?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($businesses->isEmpty())
        <div class="p-20 text-center">
            <div class="text-4xl mb-4 opacity-30">📭</div>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">No business users found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
