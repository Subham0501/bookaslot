@extends('layouts.app')

@section('title', 'Customize Gift - ' . $gift->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-white dark:from-[#0f172a] dark:via-[#1e293b] dark:to-[#0f172a] py-20 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#ff6b6b]/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 relative z-10">
        <!-- Breadcrumb -->
        <div class="mb-8 animate-fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-[#cbd5e1]">
                <a href="/" class="hover:text-[#ff6b6b] transition-colors duration-300">Home</a>
                <span>/</span>
                <a href="#gifts" class="hover:text-[#ff6b6b] transition-colors duration-300">Gifts</a>
                <span>/</span>
                <a href="{{ route('gifts.show', $gift->id) }}" class="hover:text-[#ff6b6b] transition-colors duration-300">{{ $gift->name }}</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white font-semibold">Customize</span>
            </nav>
        </div>

        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in-up">
            <div class="inline-block mb-4">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white rounded-full text-sm font-bold animate-bounce-slow">
                    ✨ Customize Your Gift
                </span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                <span class="text-gray-900 dark:text-white inline-block animate-slide-in-left">Customize Your</span>
                <span class="block text-[#ff6b6b] inline-block animate-slide-in-right mt-2">{{ $gift->name }}</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-[#cbd5e1] max-w-2xl mx-auto animate-fade-in delay-300">
                Select addons to make your gift extra special
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Gift Info Card -->
            <div class="lg:col-span-1 animate-fade-in-up delay-200">
                <div class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-lg rounded-3xl p-6 shadow-2xl border border-gray-100/50 dark:border-[#334155]/50 sticky top-24 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-3xl">
                    <div class="mb-6">
                        @if($gift->image)
                            <div class="relative overflow-hidden rounded-2xl mb-4 group bg-gray-100 dark:bg-[#1e293b] flex items-center justify-center" style="min-height: 200px;">
                                <img src="{{ asset('storage/' . $gift->image) }}" alt="{{ $gift->name }}" class="w-full h-auto max-h-64 object-contain transform transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-[#1e293b] dark:to-[#334155] rounded-2xl flex items-center justify-center mb-4 transform transition-all duration-300 hover:scale-105">
                                <svg class="w-24 h-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2 transform transition-all duration-300 hover:translate-x-2">{{ $gift->name }}</h2>
                        @if($gift->description)
                            <p class="text-gray-600 dark:text-[#cbd5e1] mb-4 leading-relaxed">{{ $gift->description }}</p>
                        @endif
                        <div class="text-3xl font-black text-[#ff6b6b] mb-6 transform transition-all duration-300 hover:scale-110 inline-block">
                            Rs. {{ number_format($gift->price, 2) }}
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="border-t border-gray-200 dark:border-[#334155] pt-4 space-y-3 animate-fade-in">
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1] transform transition-all duration-300 hover:translate-x-1">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Gift Price:
                            </span>
                            <span class="font-semibold">Rs. {{ number_format($gift->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1] transform transition-all duration-300 hover:translate-x-1" id="addons-total-row" style="display: none;">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Addons:
                            </span>
                            <span class="font-semibold" id="addons-total">Rs. 0.00</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-[#cbd5e1] transform transition-all duration-300 hover:translate-x-1" id="subtotal-row">
                            <span class="flex items-center gap-2 font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Subtotal:
                            </span>
                            <span class="font-semibold" id="subtotal-amount">Rs. {{ number_format($gift->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-green-600 dark:text-green-400 transform transition-all duration-300 hover:scale-105" id="discount-row" style="display: none;">
                            <span class="flex items-center gap-2 font-semibold">
                                <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Discount (<span id="discount-percentage">{{ \App\Models\Setting::getDiscountPercentage() }}</span>%):
                            </span>
                            <span class="font-semibold" id="discount-amount">-Rs. 0.00</span>
                        </div>
                        <div class="flex justify-between text-xl font-black text-gray-900 dark:text-white pt-3 border-t-2 border-gray-200 dark:border-[#334155] transform transition-all duration-300 hover:scale-105">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Total:
                            </span>
                            <span class="text-[#ff6b6b] transform transition-all duration-300" id="total-amount">Rs. {{ number_format($gift->price, 2) }}</span>
                        </div>
                    </div>

                    <form id="customize-form" action="{{ route('gifts.checkout') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                        <input type="hidden" name="selected_addons" id="selected-addons-input" value="[]">
                        <button type="submit" class="w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-4 rounded-xl text-center font-bold tracking-wide hover:shadow-2xl hover:shadow-[#ff6b6b]/50 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Proceed to WhatsApp
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#ff5252] to-[#ff6b6b] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                        </button>
                    </form>
                </div>
            </div>

                    <!-- Addons Selection -->
            <div class="lg:col-span-2 animate-fade-in-up delay-400">
                @if($gift->addons->count() > 0)
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-3xl font-black text-gray-900 dark:text-white">Select Addons</h2>
                            <span class="px-3 py-1 bg-[#ff6b6b]/10 text-[#ff6b6b] rounded-full text-sm font-bold animate-pulse">
                                {{ $gift->addons->count() }} available
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($gift->addons as $index => $addon)
                            @php
                                // Check if this addon name matches the gift name (already included in gift)
                                $isIncludedInGift = strtolower(trim($addon->name)) === strtolower(trim($gift->name));
                            @endphp
                            <div class="addon-card bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-lg rounded-2xl p-6 border-2 {{ $isIncludedInGift ? 'border-green-500 bg-green-50/80 dark:bg-green-900/20' : 'border-gray-200 dark:border-[#334155]' }} hover:border-[#ff6b6b] hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 {{ $isIncludedInGift ? '' : 'cursor-pointer' }} animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms" data-addon-id="{{ $addon->id }}" data-addon-price="{{ $addon->price }}" data-included="{{ $isIncludedInGift ? 'true' : 'false' }}">
                                <div class="flex flex-col">
                                    <!-- Image -->
                                    <div class="mb-4 relative overflow-hidden rounded-xl group bg-gray-100 dark:bg-[#1e293b] flex items-center justify-center" style="min-height: 192px;">
                                        @php
                                            // Use addon image if available, otherwise use gift image
                                            $displayImage = $addon->image ?: $gift->image;
                                        @endphp
                                        @if($displayImage && file_exists(storage_path('app/public/' . $displayImage)))
                                            <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $addon->name }}" class="w-full h-auto max-h-48 object-contain transform transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-[#1e293b] dark:to-[#334155] rounded-xl flex items-center justify-center transform transition-all duration-300 group-hover:scale-105">
                                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($isIncludedInGift)
                                                <div class="w-6 h-6 rounded-full border-2 border-green-500 bg-green-500 flex items-center justify-center animate-pulse">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <input type="checkbox" name="addon" value="{{ $addon->id }}" id="addon-{{ $addon->id }}" class="addon-checkbox w-6 h-6 rounded border-2 border-gray-300 text-[#ff6b6b] focus:ring-2 focus:ring-[#ff6b6b] cursor-pointer transform transition-all duration-300 hover:scale-110">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                <h3 class="text-xl font-black text-gray-900 dark:text-white transform transition-all duration-300 hover:translate-x-1">{{ $addon->name }}</h3>
                                                @if($isIncludedInGift)
                                                    <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full animate-bounce-slow flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Included
                                                    </span>
                                                @endif
                                            </div>
                                            @if($addon->description)
                                                <p class="text-gray-600 dark:text-[#cbd5e1] mb-3 text-sm leading-relaxed">{{ $addon->description }}</p>
                                            @endif
                                            <div class="text-2xl font-black text-[#ff6b6b] transform transition-all duration-300 hover:scale-110 inline-block">
                                                Rs. {{ number_format($addon->price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-[#0f172a] rounded-2xl p-12 text-center border border-gray-200 dark:border-[#334155]">
                        <p class="text-gray-600 dark:text-[#cbd5e1] text-lg mb-6">No addons available for this gift.</p>
                        <form action="{{ route('gifts.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                            <input type="hidden" name="selected_addons" value="[]">
                            <button type="submit" class="bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-in-left {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}

.animate-slide-in-left {
    animation: slide-in-left 0.8s ease-out;
}

.animate-slide-in-right {
    animation: slide-in-right 0.8s ease-out;
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

.delay-1000 {
    animation-delay: 1s;
}

.delay-2000 {
    animation-delay: 2s;
}

.delay-300 {
    animation-delay: 0.3s;
}

.delay-200 {
    animation-delay: 0.2s;
}

.delay-400 {
    animation-delay: 0.4s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addonCards = document.querySelectorAll('.addon-card');
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');
    const selectedAddonsInput = document.getElementById('selected-addons-input');
    const addonsTotalElement = document.getElementById('addons-total');
    const addonsTotalRow = document.getElementById('addons-total-row');
    const totalAmountElement = document.getElementById('total-amount');
    const giftPrice = {{ $gift->price }};
    
    let selectedAddons = [];
    
    function updateTotal() {
        let addonsTotal = 0;
        selectedAddons.forEach(addonId => {
            const addon = Array.from(addonCards).find(card => card.dataset.addonId == addonId);
            if (addon && addon.dataset.included !== 'true') {
                addonsTotal += parseFloat(addon.dataset.addonPrice);
            }
        });
        
        const subtotal = giftPrice + addonsTotal;
        
        // Apply 5% discount for customization
        const discount = subtotal * 0.05;
        const total = subtotal - discount;
        
        // Update subtotal
        document.getElementById('subtotal-amount').textContent = 'Rs. ' + subtotal.toFixed(2);
        
        if (addonsTotal > 0) {
            addonsTotalRow.style.display = 'flex';
            addonsTotalElement.textContent = 'Rs. ' + addonsTotal.toFixed(2);
        } else {
            addonsTotalRow.style.display = 'none';
        }
        
        // Show discount if any addons selected
        if (selectedAddons.length > 0) {
            const discountRow = document.getElementById('discount-row');
            discountRow.style.display = 'flex';
            discountRow.style.animation = 'fade-in 0.5s ease-out';
            document.getElementById('discount-amount').textContent = '-Rs. ' + discount.toFixed(2);
            document.getElementById('discount-percentage').textContent = discountPercentage;
        } else {
            document.getElementById('discount-row').style.display = 'none';
        }
        
        // Animate total amount change
        totalAmountElement.style.transform = 'scale(1.1)';
        totalAmountElement.textContent = 'Rs. ' + total.toFixed(2);
        setTimeout(() => {
            totalAmountElement.style.transform = 'scale(1)';
        }, 200);
        
        selectedAddonsInput.value = JSON.stringify(selectedAddons);
    }
    
    addonCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't allow clicking on already included items
            if (this.dataset.included === 'true') return;
            if (e.target.type === 'checkbox') return;
            
            const checkbox = this.querySelector('.addon-checkbox');
            if (!checkbox) return;
            
            checkbox.checked = !checkbox.checked;
            
            const addonId = parseInt(checkbox.value);
            if (checkbox.checked) {
                if (!selectedAddons.includes(addonId)) {
                    selectedAddons.push(addonId);
                }
                this.classList.add('border-[#ff6b6b]', 'bg-[#ff6b6b]/10', 'shadow-xl', 'ring-2', 'ring-[#ff6b6b]/20');
                this.style.transform = 'scale(1.05)';
            } else {
                selectedAddons = selectedAddons.filter(id => id !== addonId);
                this.classList.remove('border-[#ff6b6b]', 'bg-[#ff6b6b]/10', 'shadow-xl', 'ring-2', 'ring-[#ff6b6b]/20');
                this.style.transform = 'scale(1)';
            }
            
            updateTotal();
        });
    });
    
    addonCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const addonId = parseInt(this.value);
            const card = this.closest('.addon-card');
            
            // Don't allow selecting already included items
            if (card.dataset.included === 'true') {
                this.checked = false;
                return;
            }
            
            if (this.checked) {
                if (!selectedAddons.includes(addonId)) {
                    selectedAddons.push(addonId);
                }
                card.classList.add('border-[#ff6b6b]', 'bg-[#ff6b6b]/10', 'shadow-xl', 'ring-2', 'ring-[#ff6b6b]/20');
                card.style.transform = 'scale(1.05) translateY(-8px)';
                
                // Add a pulse animation
                card.style.animation = 'pulse 0.5s ease-out';
            } else {
                selectedAddons = selectedAddons.filter(id => id !== addonId);
                card.classList.remove('border-[#ff6b6b]', 'bg-[#ff6b6b]/10', 'shadow-xl', 'ring-2', 'ring-[#ff6b6b]/20');
                card.style.transform = 'scale(1) translateY(0)';
            }
            
            updateTotal();
        });
    });
});
</script>
@endsection
