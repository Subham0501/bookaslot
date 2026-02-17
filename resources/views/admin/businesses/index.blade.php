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
                                <p class="text-xs text-indigo-500 font-bold tracking-tight">hamroyaad.com/{{ $business->slug }}</p>
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
                        <div class="flex justify-end gap-2">
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
