@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-white dark:bg-[#0f172a] py-20">
    <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                <span class="text-gray-900 dark:text-white">Checkout</span>
            </h1>
        </div>

        <div class="max-w-2xl mx-auto">
            <!-- Order Summary -->
            <div class="bg-white dark:bg-[#0f172a] rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-[#334155]">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Order Summary</h2>
                
                <!-- All Selected Gifts (treated equally) -->
                <div class="space-y-4 mb-6">
                    @foreach($allSelectedGifts as $item)
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-200 dark:border-[#334155] last:border-0">
                        @php
                            $displayImage = $item->image;
                        @endphp
                        @if($displayImage && file_exists(storage_path('app/public/' . $displayImage)))
                            <div class="w-20 h-20 bg-gray-100 dark:bg-[#1e293b] rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $item->name }}" class="w-full h-full object-contain rounded-xl">
                            </div>
                        @else
                            <div class="w-20 h-20 bg-gray-100 dark:bg-[#1e293b] rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-3xl">🎁</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                            @if($item->description)
                                <p class="text-sm text-gray-600 dark:text-[#cbd5e1] mt-1">{{ \Illuminate\Support\Str::limit($item->description, 60) }}</p>
                            @endif
                        </div>
                        <div class="text-lg font-black text-[#ff6b6b]">
                            Rs. {{ number_format($item->price, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Price Breakdown - Simplified -->
                <div class="border-t border-gray-200 dark:border-[#334155] pt-6">
                    @if($discount > 0)
                    <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1] mb-3">
                        <span>Subtotal:</span>
                        <span class="font-semibold">Rs. {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-green-600 dark:text-green-400 mb-3">
                        <span>Customization Discount ({{ \App\Models\Setting::getDiscountPercentage() }}%):</span>
                        <span class="font-semibold">-Rs. {{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-3xl font-black text-gray-900 dark:text-white pt-3 border-t border-gray-200 dark:border-[#334155]">
                        <span>Total:</span>
                        <span class="text-[#ff6b6b]">Rs. {{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>
                
                <!-- WhatsApp Button -->
                <a href="{{ $whatsappUrl }}" target="_blank" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl text-center font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-lg inline-flex items-center justify-center">
                    Proceed to WhatsApp
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
