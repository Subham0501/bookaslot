@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Gift Management</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Manage gifts and addons</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.templates.index') }}" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                        Templates
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="bg-blue-500 dark:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                        Settings
                    </a>
                    <a href="{{ route('admin.gifts.create') }}" class="bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                        + Add New Gift
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Gifts List -->
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-[#334155]">
                    <thead class="bg-gray-50 dark:bg-[#0f172a]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Addons</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-[#cbd5e1] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#1e293b] divide-y divide-gray-200 dark:divide-[#334155]">
                        @forelse($gifts as $gift)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#0f172a] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($gift->image)
                                    <img src="{{ asset('storage/' . $gift->image) }}" alt="{{ $gift->name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-[#334155] rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $gift->name }}</div>
                                @if($gift->description)
                                    <div class="text-sm text-gray-500 dark:text-[#cbd5e1] mt-1">{{ Str::limit($gift->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-[#ff6b6b]">Rs. {{ number_format($gift->price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $gift->addons->count() }} addon(s)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($gift->is_active)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-400">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.gifts.addons', $gift->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-semibold">
                                        Addons
                                    </a>
                                    <a href="{{ route('admin.gifts.edit', $gift->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.gifts.destroy', $gift->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this gift?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500 dark:text-[#cbd5e1]">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-lg font-semibold mb-2">No gifts found</p>
                                    <p class="mb-4">Get started by creating your first gift</p>
                                    <a href="{{ route('admin.gifts.create') }}" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                                        Create Gift
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
