@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Manage Addons</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Gift: <span class="font-bold">{{ $gift->name }}</span></p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.gifts.index') }}" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                        Back to Gifts
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add New Addon Form -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] p-6 sticky top-24">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Add New Addon</h2>
                    <form action="{{ route('admin.gifts.addons.store', $gift->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Name *</label>
                                <input type="text" name="name" required class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Description</label>
                                <textarea name="description" rows="3" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Price (Rs.) *</label>
                                <input type="number" name="price" step="0.01" min="0" required class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Image</label>
                                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Sort Order</label>
                                <input type="number" name="sort_order" value="0" min="0" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 rounded border-gray-300 text-[#ff6b6b] focus:ring-[#ff6b6b]">
                                    <span class="ml-2 text-sm font-bold text-gray-700 dark:text-[#cbd5e1]">Active</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                                Add Addon
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Addons -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Existing Addons ({{ $gift->addons->count() }})</h2>
                
                @if($gift->addons->count() > 0)
                    <div class="space-y-4">
                        @foreach($gift->addons as $addon)
                        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] p-6">
                            <form action="{{ route('admin.gifts.addons.update', [$gift->id, $addon->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        @php
                                            // Use addon image if available, otherwise use gift image
                                            $displayImage = $addon->image ?: $gift->image;
                                        @endphp
                                        @if($displayImage && file_exists(storage_path('app/public/' . $displayImage)))
                                            <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $addon->name }}" class="w-full h-32 object-contain rounded-xl mb-2 bg-gray-100 dark:bg-[#1e293b] p-2">
                                        @else
                                            <div class="w-full h-32 bg-gray-100 dark:bg-[#1e293b] rounded-xl mb-2 flex items-center justify-center">
                                                <span class="text-xs text-gray-400">No image</span>
                                            </div>
                                        @endif
                                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                                        <p class="text-xs text-gray-500 dark:text-[#cbd5e1] mt-1">Leave empty to use gift image</p>
                                    </div>
                                    
                                    <div class="md:col-span-2 space-y-3">
                                        <div>
                                            <input type="text" name="name" value="{{ $addon->name }}" required class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white font-bold">
                                        </div>
                                        <div>
                                            <textarea name="description" rows="2" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white text-sm">{{ $addon->description }}</textarea>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="flex-1">
                                                <label class="block text-xs text-gray-600 dark:text-[#cbd5e1] mb-1">Price</label>
                                                <input type="number" name="price" value="{{ $addon->price }}" step="0.01" min="0" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="block text-xs text-gray-600 dark:text-[#cbd5e1] mb-1">Sort</label>
                                                <input type="number" name="sort_order" value="{{ $addon->sort_order }}" min="0" class="w-20 px-3 py-2 rounded-lg border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white">
                                            </div>
                                            <div class="pt-5">
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="is_active" value="1" {{ $addon->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-[#ff6b6b] focus:ring-[#ff6b6b]">
                                                    <span class="ml-2 text-xs text-gray-700 dark:text-[#cbd5e1]">Active</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                                Update
                                            </button>
                                            <form action="{{ route('admin.gifts.addons.destroy', [$gift->id, $addon->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this addon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] p-12 text-center">
                        <p class="text-gray-500 dark:text-[#cbd5e1]">No addons yet. Add your first addon using the form on the left.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
