@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Create New Gift</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Add a new gift to your store</p>
                </div>
                <a href="{{ route('admin.gifts.index') }}" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                    Back to Gifts
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] p-8">
            <form action="{{ route('admin.gifts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Gift Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Price (Rs.) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500 dark:text-[#cbd5e1]">Lower numbers appear first</p>
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-[#ff6b6b] focus:ring-[#ff6b6b]">
                            <span class="ml-2 text-sm font-bold text-gray-700 dark:text-[#cbd5e1]">Active (visible on website)</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                            Create Gift
                        </button>
                        <a href="{{ route('admin.gifts.index') }}" class="px-6 py-4 bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
