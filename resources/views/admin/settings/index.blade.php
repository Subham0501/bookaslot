@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Settings</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Manage application settings</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.gifts.index') }}" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                        Gifts
                    </a>
                    <a href="{{ route('admin.templates.index') }}" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                        Templates
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Settings Form -->
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] p-8">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <div class="space-y-8">
                    <!-- Gift Customization Discount -->
                    <div class="border-b border-gray-200 dark:border-[#334155] pb-8">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">
                                    Gift Customization Discount
                                </h2>
                                <p class="text-gray-600 dark:text-[#cbd5e1] mb-4">
                                    Set the discount percentage applied when customers customize gifts by selecting addons. This discount is automatically applied to the subtotal.
                                </p>
                            </div>
                            <div class="ml-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                                    Discount Percentage (%)
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="gift_customization_discount" 
                                        value="{{ old('gift_customization_discount', $discount) }}" 
                                        min="0" 
                                        max="100" 
                                        step="0.1"
                                        required 
                                        class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent text-lg font-bold"
                                    >
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-[#cbd5e1] font-bold">%</span>
                                </div>
                                @error('gift_customization_discount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                                <h3 class="text-sm font-bold text-green-800 dark:text-green-400 mb-2">Current Setting</h3>
                                <div class="text-4xl font-black text-green-600 dark:text-green-400 mb-2">
                                    {{ number_format($discount, 1) }}%
                                </div>
                                <p class="text-sm text-green-700 dark:text-green-300">
                                    This discount will be applied when customers select addons during gift customization.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Home Page Featured Business -->
                    <div class="border-b border-gray-200 dark:border-[#334155] pb-8 pt-8">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">
                                    Home Page Featured Site
                                </h2>
                                <p class="text-gray-600 dark:text-[#cbd5e1] mb-4">
                                    Select which business to showcase prominently on the home page. You can toggle this section on or off.
                                </p>
                            </div>
                            <div class="ml-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">
                                    Select Business to Display
                                </label>
                                <select 
                                    name="home_featured_business_id" 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#0f172a] text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-bold"
                                >
                                    <option value="">No Business Selected</option>
                                    @foreach($businesses as $business)
                                        <option value="{{ $business->id }}" {{ old('home_featured_business_id', $featuredBusinessId) == $business->id ? 'selected' : '' }}>
                                            {{ $business->business_name }} ({{ $business->category }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-sm text-gray-500 dark:text-[#cbd5e1]">
                                    Pick a business from your active listings.
                                </p>
                            </div>

                            <div class="flex items-center">
                                <div class="bg-gray-100 dark:bg-[#0f172a] rounded-2xl p-6 border border-gray-200 dark:border-[#334155] w-full">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-bold text-gray-700 dark:text-[#cbd5e1]">Show on Home Page</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Toggle this to enable/disable the featured section.</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="home_featured_business_enabled" value="1" class="sr-only peer" {{ old('home_featured_business_enabled', $featuredBusinessEnabled) ? 'checked' : '' }}>
                                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all transform hover:scale-105">
                            Save Settings
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
