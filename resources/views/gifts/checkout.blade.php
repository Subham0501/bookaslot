@extends('layouts.app')

@section('title', 'Checkout - ' . $gift->name)

@section('content')
<div class="min-h-screen bg-white dark:bg-[#0f172a] py-20">
    <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                <span class="text-gray-900 dark:text-white">Checkout</span>
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-[#334155] mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Order Summary</h2>
                    
                    <!-- Gift Item -->
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-[#334155]">
                        @if($gift->image)
                            <div class="w-24 h-24 bg-gray-100 dark:bg-[#1e293b] rounded-xl flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/' . $gift->image) }}" alt="{{ $gift->name }}" class="w-full h-full object-contain rounded-xl">
                            </div>
                        @else
                            <div class="w-24 h-24 bg-gray-100 dark:bg-[#1e293b] rounded-xl flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $gift->name }}</h3>
                            <p class="text-gray-600 dark:text-[#cbd5e1] text-sm">Gift</p>
                        </div>
                        <div class="text-xl font-black text-[#ff6b6b]">
                            Rs. {{ number_format($gift->price, 2) }}
                        </div>
                    </div>

                    <!-- Selected Addons -->
                    @if($selectedAddons->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Selected Addons</h3>
                            <div class="space-y-4">
                                @foreach($selectedAddons as $addon)
                                <div class="flex items-center gap-4">
                                    @if($addon->image)
                                        <div class="w-16 h-16 bg-gray-100 dark:bg-[#1e293b] rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                            <img src="{{ asset('storage/' . $addon->image) }}" alt="{{ $addon->name }}" class="w-full h-full object-contain rounded-lg">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 dark:bg-[#1e293b] rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $addon->name }}</h4>
                                        @if($addon->description)
                                            <p class="text-sm text-gray-600 dark:text-[#cbd5e1]">{{ \Illuminate\Support\Str::limit($addon->description, 50) }}</p>
                                        @endif
                                    </div>
                                    <div class="font-bold text-[#ff6b6b]">
                                        Rs. {{ number_format($addon->price, 2) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Price Breakdown -->
                    <div class="border-t border-gray-200 dark:border-[#334155] pt-6 space-y-3">
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1]">
                            <span>Gift Price:</span>
                            <span class="font-semibold">Rs. {{ number_format($gift->price, 2) }}</span>
                        </div>
                        @if($addonsTotal > 0)
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1]">
                            <span>Addons:</span>
                            <span class="font-semibold">Rs. {{ number_format($addonsTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1]">
                            <span>Subtotal:</span>
                            <span class="font-semibold">Rs. {{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="flex justify-between text-green-600 dark:text-green-400">
                            <span>Customization Discount (5%):</span>
                            <span class="font-semibold">-Rs. {{ number_format($discount, 2) }}</span>
                        </div>
                        @endif
                        @endif
                        <div class="flex justify-between text-2xl font-black text-gray-900 dark:text-white pt-3 border-t border-gray-200 dark:border-[#334155]">
                            <span>Total:</span>
                            <span class="text-[#ff6b6b]">Rs. {{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information Form -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-[#334155] sticky top-24">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Your Information</h2>
                    
                    <form action="{{ route('gifts.submit-order') }}" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                        <input type="hidden" name="selected_addons" value="{{ json_encode($selectedAddons->pluck('id')->toArray()) }}">
                        
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Full Name *</label>
                                <input type="text" name="customer_name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#1e293b] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Email *</label>
                                <input type="email" name="customer_email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#1e293b] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Phone *</label>
                                <input type="tel" name="customer_phone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#1e293b] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Address</label>
                                <textarea name="customer_address" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#1e293b] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-[#cbd5e1] mb-2">Notes (Optional)</label>
                                <textarea name="notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-[#334155] bg-white dark:bg-[#1e293b] text-gray-900 dark:text-white focus:ring-2 focus:ring-[#ff6b6b] focus:border-transparent" placeholder="Any special instructions..."></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl text-center font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
