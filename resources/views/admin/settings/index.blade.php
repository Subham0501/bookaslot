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
                                <p class="mt-2 text-sm text-gray-500 dark:text-[#cbd5e1]">
                                    Enter a value between 0 and 100. Example: 5 for 5% discount, 10 for 10% discount.
                                </p>
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

                        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1">How it works:</p>
                                    <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1 list-disc list-inside">
                                        <li>Discount is calculated on the subtotal (gift price + addons)</li>
                                        <li>Only applies when customers select at least one addon</li>
                                        <li>Displayed in the customize page and WhatsApp message</li>
                                        <li>Changes take effect immediately after saving</li>
                                    </ul>
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
