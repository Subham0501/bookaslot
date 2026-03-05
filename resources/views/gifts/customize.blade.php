@extends('layouts.app')

@section('title', isset($gift) ? 'Customize ' . $gift->name : 'Customize Gift')

@section('content')
<!-- Customize Page -->
<div class="min-h-screen bg-slate-50 dark:bg-[#0f172a] py-12 relative overflow-hidden flex flex-col justify-center">
    
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-[#ff6b6b]/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-[#ff5252]/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 w-full relative z-10">
        
        <div class="bg-white/80 dark:bg-[#1e293b]/90 backdrop-blur-xl rounded-[3rem] shadow-2xl border border-white/20 dark:border-white/5 overflow-hidden min-h-[700px] flex flex-col lg:flex-row relative">
            
            <!-- Left Side: The Gift Box Animation -->
            <div class="lg:w-1/2 bg-gradient-to-br from-[#ff6b6b]/5 to-[#ff5252]/10 relative flex flex-col items-center justify-center p-8 lg:p-12 min-h-[400px]">
                
                <!-- Animated Gift Box Component -->
                <div class="relative w-72 h-72 mb-8 transition-all duration-500" id="main-gift-box">
                    
                    <!-- Floating Counter Badge -->
                    <div id="item-counter" class="absolute -top-6 -right-6 w-12 h-12 bg-[#ff6b6b] text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg transform scale-0 transition-transform duration-300 z-50 border-4 border-white dark:border-[#1e293b]">0</div>

                    <!-- Box Back (Static) -->
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-56 h-40 bg-[#e11d48] rounded-b-2xl shadow-inner z-0"></div>
                    
                    <!-- Selected Gift Image (Hidden initially - will show when items are added) -->
                    <div id="base-gift-image" class="absolute left-1/2 -translate-x-1/2 bottom-12 w-40 h-40 flex items-center justify-center z-10 transition-all duration-500 opacity-0 hidden">
                        <img id="main-gift-img" src="" alt="" class="w-full h-full object-contain filter drop-shadow-xl hover:scale-105 transition-transform" style="max-height: 140px;">
                        <div class="gift-label absolute -bottom-6 left-1/2 -translate-x-1/2 bg-[#ff6b6b] px-2 py-0.5 rounded text-[10px] font-bold text-white whitespace-nowrap shadow-sm">
                            Main Item
                        </div>
                    </div>
                    
                    <!-- Empty Box Message (Shown initially) -->
                    <div id="empty-box-message" class="absolute left-1/2 -translate-x-1/2 bottom-12 w-40 h-40 flex items-center justify-center z-10 transition-all duration-500">
                        <div class="text-center">
                            <div class="text-4xl mb-2">📦</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Empty Box</p>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">Select a gift to start</p>
                        </div>
                    </div>
                    
                    <!-- Container for added items inside the box -->
                    <div id="added-items-container" class="absolute left-1/2 -translate-x-1/2 bottom-12 w-40 h-40 flex flex-wrap items-center justify-center z-15 gap-1 p-2 pointer-events-none"></div>

                    <!-- Box Front (Static) -->
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-56 h-40 bg-[#ff4757] rounded-b-2xl z-20 shadow-2xl overflow-hidden flex items-center justify-center">
                        <div class="absolute left-1/2 -translate-x-1/2 w-12 h-full bg-[#fb7185]/40 backdrop-blur-sm border-l border-r border-white/10"></div>
                        <div class="relative z-10 bg-white/95 backdrop-blur-sm rounded-full p-2 shadow-lg border border-white/50">
                            <img src="{{ asset('assets/stabndard.png') }}" alt="Hamro Yaad" class="w-12 h-12 object-contain">
                        </div>
                    </div>
                    
                    <!-- Box Lid (Animated - Open by default) -->
                    <div id="box-lid" class="absolute bottom-40 left-1/2 -translate-x-1/2 w-60 h-16 bg-[#ff4757] rounded-xl z-30 shadow-2xl transition-all duration-700 ease-in-out lid-open">
                        <div class="absolute left-1/2 -translate-x-1/2 w-12 h-full bg-[#fb7185]/40 backdrop-blur-sm"></div>
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-20 h-10">
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-[#fb7185] z-40"></div>
                            <div class="absolute left-0 top-0 w-10 h-10 rounded-full border-4 border-[#fb7185] rounded-br-none -rotate-45 ml-[-4px]"></div>
                            <div class="absolute right-0 top-0 w-10 h-10 rounded-full border-4 border-[#fb7185] rounded-bl-none rotate-45 mr-[-4px]"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center z-20 mt-4">
                    <h2 id="selected-gift-name" class="text-2xl font-black text-gray-900 dark:text-white">Your Custom Gift Box</h2>
                    <p id="selected-gift-price" class="text-[#ff6b6b] font-bold text-lg">Select gifts to add</p>
                </div>
            </div>

            <!-- Right Side: Interaction Area -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col relative">
                
                <!-- Selection State: Grid of Items (Visible by default) -->
                <div id="state-selection" class="flex-1 p-8 lg:p-12 flex flex-col transition-all duration-500">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 id="selection-title" class="text-2xl font-bold text-gray-900 dark:text-white">Select Gifts</h3>
                            <p id="selection-subtitle" class="text-sm text-gray-500 dark:text-gray-400">Click on any gift below to add it to your box</p>
                        </div>
                        <div id="feedback-msg" class="text-[#ff6b6b] font-bold opacity-0 transition-opacity duration-300 bg-[#ff6b6b]/10 px-3 py-1 rounded-lg">
                            Added! ✨
                        </div>
                    </div>

                    <!-- Scrollable Grid -->
                    <div class="flex-1 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent mb-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pb-4" id="gifts-grid">
                            @if(isset($gift) && isset($availableGifts))
                                {{-- Show other gifts as addons when a gift is pre-selected --}}
                                @foreach($availableGifts as $addon)
                                @php
                                    $imageUrl = $addon->image ? asset('storage/' . $addon->image) : '';
                                @endphp
                                <div onclick="addItemToBox({{ $addon->id }}, '{{ addslashes($imageUrl) }}', '{{ addslashes($addon->name) }}', this, {{ $addon->price }})" 
                                     class="gift-card cursor-pointer bg-white dark:bg-[#0f172a] rounded-xl p-3 shadow-sm hover:shadow-lg border border-gray-100 dark:border-[#334155] hover:border-[#ff6b6b] transition-all transform hover:-translate-y-1 group relative active:scale-95"
                                     data-gift-id="{{ $addon->id }}"
                                     data-gift-price="{{ $addon->price }}"
                                     data-gift-name="{{ $addon->name }}"
                                     data-gift-image="{{ $imageUrl }}"
                                     style="cursor: pointer; user-select: none;">
                                    
                                    <div class="h-24 mb-2 overflow-hidden rounded-lg bg-gray-50 dark:bg-[#1e293b] flex items-center justify-center">
                                        @if($addon->image)
                                            <img src="{{ asset('storage/' . $addon->image) }}" alt="{{ $addon->name }}" class="w-full h-full object-contain p-1 pointer-events-none">
                                        @else
                                            <span class="text-2xl pointer-events-none">🎁</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="font-bold text-gray-800 dark:text-white text-xs line-clamp-1 group-hover:text-[#ff6b6b] transition-colors pointer-events-none">{{ $addon->name }}</h4>
                                    <div class="flex justify-between items-center mt-1 pointer-events-none">
                                        <p class="text-[#ff6b6b] text-xs font-bold">Rs. {{ number_format($addon->price, 0) }}</p>
                                        <div class="w-5 h-5 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 group-hover:bg-[#ff6b6b] group-hover:text-white transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @elseif(isset($allGifts))
                                {{-- Show all gifts for selection when no gift is pre-selected --}}
                                @foreach($allGifts as $giftItem)
                                @php
                                    $imageUrl = $giftItem->image ? asset('storage/' . $giftItem->image) : '';
                                @endphp
                                <div onclick="addItemToBox({{ $giftItem->id }}, '{{ addslashes($imageUrl) }}', '{{ addslashes($giftItem->name) }}', this, {{ $giftItem->price }})" 
                                     class="gift-card cursor-pointer bg-white dark:bg-[#0f172a] rounded-xl p-3 shadow-sm hover:shadow-lg border-2 border-gray-200 dark:border-[#334155] hover:border-[#ff6b6b] transition-all transform hover:-translate-y-1 group relative active:scale-95"
                                     data-gift-id="{{ $giftItem->id }}"
                                     data-gift-price="{{ $giftItem->price }}"
                                     data-gift-name="{{ $giftItem->name }}"
                                     data-gift-image="{{ $imageUrl }}"
                                     style="cursor: pointer; user-select: none;">
                                    
                                    <div class="h-24 mb-2 overflow-hidden rounded-lg bg-gray-50 dark:bg-[#1e293b] flex items-center justify-center">
                                        @if($giftItem->image)
                                            <img src="{{ asset('storage/' . $giftItem->image) }}" alt="{{ $giftItem->name }}" class="w-full h-full object-contain p-1 pointer-events-none">
                                        @else
                                            <span class="text-2xl pointer-events-none">🎁</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="font-bold text-gray-800 dark:text-white text-xs line-clamp-1 group-hover:text-[#ff6b6b] transition-colors pointer-events-none">{{ $giftItem->name }}</h4>
                                    <div class="flex justify-between items-center mt-1 pointer-events-none">
                                        <p class="text-[#ff6b6b] text-xs font-bold">Rs. {{ number_format($giftItem->price, 0) }}</p>
                                        <div class="w-5 h-5 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 group-hover:bg-[#ff6b6b] group-hover:text-white transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Selected Items List -->
                    <div id="selected-items-list" class="mb-4 max-h-32 overflow-y-auto scrollbar-thin">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 font-semibold">Selected Items:</p>
                        <div id="selected-items-container" class="space-y-1">
                            <p class="text-xs text-gray-400 dark:text-gray-500 italic">No items added yet</p>
                        </div>
                    </div>

                    <!-- Bottom Action Bar -->
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500">Selected Value</p>
                            <p class="text-xl font-black text-gray-900 dark:text-white" id="current-total">Rs. {{ isset($gift) ? number_format($gift->price, 2) : '0.00' }}</p>
                        </div>
                        <button onclick="finishCustomization()" id="checkout-btn" class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-[#ff6b6b]/30 transition-all hover:scale-105 active:scale-95 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Done & Checkout
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Hidden Form -->
<form id="checkout-form" action="{{ route('gifts.checkout') }}" method="POST" class="hidden">
    @csrf
    <div id="form-inputs-container"></div>
</form>

<style>
    /* Lid Open Animation state */
    .lid-open {
        transform: translate(-50%, -120px) rotate(-10deg) !important; 
    }
    
    .lid-closed {
        transform: translate(-50%, 0) !important;
    }

    .flying-item {
        position: fixed;
        pointer-events: none;
        z-index: 100;
        transition: all 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }
    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 3px;
    }
    
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.3);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .animate-bounce-in {
        animation: fadeInScale 0.5s ease-out;
    }
    
    .selected-gift {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
        }
        50% {
            box-shadow: 0 0 0 5px rgba(255, 107, 107, 0.3);
        }
    }
</style>

<script>
    @php
        $allGiftsData = [];
        if (isset($allGifts)) {
            foreach ($allGifts as $g) {
                $allGiftsData[] = [
                    'id' => $g->id,
                    'name' => $g->name,
                    'price' => $g->price,
                    'image' => $g->image ? asset('storage/' . $g->image) : ''
                ];
            }
        }
    @endphp
    
    let selectedAddons = [];
    let selectedItems = {}; // Store item details {id: {name, price, image}}
    let totalPrice = 0;
    let allGifts = @json($allGiftsData);

    // Save state to localStorage
    function saveState() {
        try {
            localStorage.setItem('giftCustomizeState', JSON.stringify({
                selectedAddons: selectedAddons,
                selectedItems: selectedItems,
                totalPrice: totalPrice
            }));
        } catch(e) {
            console.error('Error saving state:', e);
        }
    }

    // Restore state from localStorage
    function restoreState() {
        try {
            const saved = localStorage.getItem('giftCustomizeState');
            if (saved) {
                const state = JSON.parse(saved);
                selectedAddons = state.selectedAddons || [];
                selectedItems = state.selectedItems || {};
                totalPrice = state.totalPrice || 0;
                
                console.log('Restoring state:', { selectedAddons, selectedItems, totalPrice });
                
                // Wait for DOM to be ready, then restore visual state
                // Use a longer timeout and retry mechanism to ensure DOM is ready
                let retries = 0;
                const maxRetries = 10;
                
        const tryRestore = () => {
                    // Check if gift cards are loaded
                    const giftCards = document.querySelectorAll('[data-gift-id]');
                    if (giftCards.length === 0 && retries < maxRetries) {
                        retries++;
                        setTimeout(tryRestore, 200);
                        return;
                    }
                    
                    console.log('Found gift cards:', giftCards.length);
                    
                    // Restore visual state for each selected item
                    selectedAddons.forEach(id => {
                        const card = document.querySelector(`[data-gift-id="${id}"]`);
                        if (card) {
                            // Find the item details - get first matching item
                            const itemKey = Object.keys(selectedItems).find(key => selectedItems[key].id == id);
                            if (itemKey) {
                                const item = selectedItems[itemKey];
                                
                                console.log('Restoring item:', id, item);
                                
                                // Restore highlighting
                                card.classList.add('selected-gift');
                                card.style.borderColor = '#ff6b6b';
                                card.style.borderWidth = '3px';
                                card.style.backgroundColor = '#ff6b6b15';
                                card.style.boxShadow = '0 0 0 3px rgba(255, 107, 107, 0.2)';
                                card.style.transform = 'scale(0.98)';
                                
                                // Add checkmark badge
                                let badge = card.querySelector('.selected-badge');
                                if (!badge) {
                                    badge = document.createElement('div');
                                    badge.className = 'selected-badge absolute -top-2 -right-2 w-6 h-6 bg-[#ff6b6b] rounded-full flex items-center justify-center text-white text-xs font-bold z-10';
                                    badge.innerHTML = '✓';
                                    card.style.position = 'relative';
                                    card.appendChild(badge);
                                }
                                
                                // Update icon
                                const iconContainer = card.querySelector('.w-5.h-5');
                                if (iconContainer) {
                                    iconContainer.className = 'w-5 h-5 rounded-full bg-[#ff6b6b] flex items-center justify-center text-white';
                                    const icon = iconContainer.querySelector('svg');
                                    if (icon) {
                                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                                    }
                                }
                                
                                // Add to box visually (count how many times this ID appears)
                                const itemCount = selectedAddons.filter(selectedId => selectedId == id).length;
                                for (let i = 0; i < itemCount; i++) {
                                    addItemToBoxVisual(id, item.name, item.image);
                                }
                            } else {
                                // If item details not found, try to get from allGifts array
                                const giftData = allGifts.find(g => g.id == id);
                                if (giftData) {
                                    const itemCount = selectedAddons.filter(selectedId => selectedId == id).length;
                                    for (let i = 0; i < itemCount; i++) {
                                        addItemToBoxVisual(id, giftData.name, giftData.image);
                                    }
                                }
                            }
                        } else {
                            console.warn('Card not found for ID:', id);
                        }
                    });
                    
                    // Hide empty box message if items are selected
                    if (selectedAddons.length > 0) {
                        const emptyBoxMessage = document.getElementById('empty-box-message');
                        if (emptyBoxMessage) {
                            emptyBoxMessage.style.opacity = '0';
                            setTimeout(() => {
                                emptyBoxMessage.classList.add('hidden');
                            }, 300);
                        }
                    }
                    
                    // Enable checkout button if items are selected
                    const checkoutBtn = document.getElementById('checkout-btn');
                    if (checkoutBtn && selectedAddons.length > 0) {
                        checkoutBtn.disabled = false;
                    }
                    
                    // Update UI first
                    updateUI();
                    
                    // Open the box lid if items are selected (so items are visible)
                    // Do this immediately and also after a delay to ensure it works
                    if (selectedAddons.length > 0) {
                        const lid = document.getElementById('box-lid');
                        if (lid) {
                            console.log('Opening box lid - items restored (immediate)');
                            // Remove closed class and add open class
                            lid.classList.remove('lid-closed');
                            lid.classList.add('lid-open');
                            // Force immediate style update
                            lid.style.transform = 'translate(-50%, -120px) rotate(-10deg)';
                            
                            // Also do it after a delay to ensure transition works
                            setTimeout(() => {
                                lid.classList.remove('lid-closed');
                                lid.classList.add('lid-open');
                                lid.style.transform = 'translate(-50%, -120px) rotate(-10deg)';
                                console.log('Opening box lid - items restored (delayed)');
                            }, 100);
                        } else {
                            console.warn('Box lid element not found');
                        }
                    }
                };
                
                // Start restoration attempt
                setTimeout(tryRestore, 100);
            }
        } catch(e) {
            console.error('Error restoring state:', e);
        }
    }

    // Auto-open box when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded - Starting state restoration');
        
        // Make sure selection area is visible (in case it was hidden from previous navigation)
        const selection = document.getElementById('state-selection');
        if (selection) {
            selection.style.opacity = '1';
            selection.style.display = '';
        }
        
        // Immediately check if we have saved state and open lid if needed
        const saved = localStorage.getItem('giftCustomizeState');
        if (saved) {
            try {
                const state = JSON.parse(saved);
                if (state.selectedAddons && state.selectedAddons.length > 0) {
                    // Force open the lid immediately if items are selected
                    const lid = document.getElementById('box-lid');
                    if (lid) {
                        console.log('DOMContentLoaded - Force opening lid immediately');
                        lid.classList.remove('lid-closed');
                        lid.classList.add('lid-open');
                        lid.style.transform = 'translate(-50%, -120px) rotate(-10deg)';
                        lid.style.transition = 'all 0.7s ease-in-out';
                    }
                }
            } catch(e) {
                console.error('Error checking saved state:', e);
            }
        }
        
        // Restore state from localStorage first
        restoreState();
        
        // Wait a bit for state restoration to complete, then check
        setTimeout(() => {
            // If no saved state, clear everything
            if (selectedAddons.length === 0) {
                selectedAddons = [];
                selectedItems = {};
                totalPrice = 0;
                
                // Hide main gift image, show empty box message
                const baseGiftImage = document.getElementById('base-gift-image');
                const emptyBoxMessage = document.getElementById('empty-box-message');
                if (baseGiftImage) {
                    baseGiftImage.classList.add('opacity-0', 'hidden');
                }
                if (emptyBoxMessage) {
                    emptyBoxMessage.classList.remove('opacity-0', 'hidden');
                }
            }
            
            // Update UI after state is restored
            updateUI();
        }, 600);
        
        // Also check on window load (in case DOMContentLoaded fires too early)
        window.addEventListener('load', function() {
            console.log('Window loaded - Checking state again');
            
            // Ensure selection area is visible
            const selection = document.getElementById('state-selection');
            if (selection) {
                selection.style.opacity = '1';
                selection.style.display = '';
            }
            
            if (selectedAddons.length > 0) {
                // State exists, make sure UI is updated
                setTimeout(() => {
                    updateUI();
                    
                    // Ensure box lid is open if items are selected
                    const lid = document.getElementById('box-lid');
                    if (lid && selectedAddons.length > 0) {
                        console.log('Window loaded - Opening box lid');
                        lid.classList.remove('lid-closed');
                        lid.classList.add('lid-open');
                        // Force style update
                        lid.style.transform = 'translate(-50%, -120px) rotate(-10deg)';
                    }
                }, 400);
            }
        });
        
        // Handle browser back/forward cache (bfcache) - this fires when page is restored from cache
        window.addEventListener('pageshow', function(event) {
            console.log('PageShow event - persisted:', event.persisted);
            
            if (event.persisted) {
                // Page was restored from bfcache, restore state and open lid
                console.log('Page restored from cache - restoring state');
                
                // Ensure selection area is visible
                const selection = document.getElementById('state-selection');
                if (selection) {
                    selection.style.opacity = '1';
                    selection.style.display = '';
                }
                
                // Check saved state and open lid if needed
                const saved = localStorage.getItem('giftCustomizeState');
                if (saved) {
                    try {
                        const state = JSON.parse(saved);
                        if (state.selectedAddons && state.selectedAddons.length > 0) {
                            // Restore the state variables
                            selectedAddons = state.selectedAddons || [];
                            selectedItems = state.selectedItems || {};
                            totalPrice = state.totalPrice || 0;
                            
                            // Force open the lid
                            const lid = document.getElementById('box-lid');
                            if (lid) {
                                console.log('PageShow - Force opening lid');
                                lid.classList.remove('lid-closed');
                                lid.classList.add('lid-open');
                                lid.style.transform = 'translate(-50%, -120px) rotate(-10deg)';
                                lid.style.transition = 'all 0.7s ease-in-out';
                            }
                            
                            // Restore visual state
                            setTimeout(() => {
                                restoreState();
                            }, 100);
                        }
                    } catch(e) {
                        console.error('Error restoring from cache:', e);
                    }
                }
            }
        });
        
        // Open box lid - but only if no items are selected (to avoid closing it if items were restored)
        setTimeout(() => {
            const lid = document.getElementById('box-lid');
            if(lid) {
                // Check if lid is already open (from state restoration)
                const isAlreadyOpen = lid.classList.contains('lid-open');
                
                // Only open if no items are selected OR if it's not already open
                if (selectedAddons.length === 0 || !isAlreadyOpen) {
                    console.log('DOMContentLoaded timeout - Opening box lid');
                    lid.classList.remove('lid-closed');
                    lid.classList.add('lid-open');
                } else {
                    console.log('Box lid already open from state restoration');
                }
            }
        }, 1000);
    });

    function addItemToBox(id, imageSrc, name, element, price) {
        console.log('addItemToBox called', id, name, price);

        // Prevent if already processing
        if (element.classList.contains('processing')) {
            console.log('Already processing');
            return;
        }

        // Check if this item is already selected
        const isSelected = element.classList.contains('selected-gift');
        
        if (isSelected) {
            // Deselect the item
            removeItemFromBox(id, element, price);
            return;
        }

        try {
            // Mark as processing
            element.classList.add('processing');
            
            // 1. Create flying clone - get source position from the card image
            const rect = element.getBoundingClientRect();
            const cardImage = element.querySelector('img');
            const imageRect = cardImage ? cardImage.getBoundingClientRect() : rect;
            
            // Target Box - find the box container
            const boxTarget = document.getElementById('main-gift-box') || document.querySelector('.bg-[#e11d48]');
            const boxRect = boxTarget ? boxTarget.getBoundingClientRect() : { top: window.innerHeight/2, left: window.innerWidth/2, width: 200, height: 200 };
            
            // Create flying image clone
            const clone = document.createElement('img');
            if (imageSrc && imageSrc.trim() !== '') {
                clone.src = imageSrc;
            } else {
                // If no image, create a placeholder
                clone.style.display = 'flex';
                clone.style.alignItems = 'center';
                clone.style.justifyContent = 'center';
                clone.style.fontSize = '40px';
                clone.innerHTML = '🎁';
            }
            
            // Style the flying clone
            clone.style.position = 'fixed';
            clone.style.zIndex = '99999';
            clone.style.width = Math.max(imageRect.width, 80) + 'px';
            clone.style.height = Math.max(imageRect.height, 80) + 'px';
            clone.style.objectFit = 'contain';
            clone.style.borderRadius = '12px';
            clone.style.backgroundColor = 'white';
            clone.style.padding = '8px';
            clone.style.boxShadow = '0 8px 16px rgba(0,0,0,0.3), 0 0 0 4px rgba(255, 107, 107, 0.2)';
            clone.style.border = '3px solid #ff6b6b';
            clone.style.pointerEvents = 'none';
            clone.style.opacity = '1';
            clone.style.transform = 'scale(1) rotate(0deg)';
            
            // Set initial position (center of the card image)
            const startX = imageRect.left + imageRect.width / 2;
            const startY = imageRect.top + imageRect.height / 2;
            clone.style.top = startY - Math.max(imageRect.height, 80) / 2 + 'px';
            clone.style.left = startX - Math.max(imageRect.width, 80) / 2 + 'px';
            
            document.body.appendChild(clone);
            
            // Force reflow to ensure initial position is set
            clone.offsetHeight;
            
            // Calculate destination (center of the box)
            const destX = boxRect.left + boxRect.width / 2;
            const destY = boxRect.top + boxRect.height / 2;
            const finalSize = 56; // Final size in the box
            
            // Animate with smooth easing (faster animation)
            requestAnimationFrame(() => {
                clone.style.transition = 'all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
                clone.style.top = destY - finalSize / 2 + 'px';
                clone.style.left = destX - finalSize / 2 + 'px';
                clone.style.width = finalSize + 'px';
                clone.style.height = finalSize + 'px';
                clone.style.transform = 'scale(0.8) rotate(360deg)';
                clone.style.opacity = '0.9';
            });

            // 3. Add to selected items (allow duplicates)
            selectedAddons.push(id);
            // Store item details with a unique key to allow duplicates
            const uniqueKey = id + '_' + Date.now();
            selectedItems[uniqueKey] = {id: id, name: name, price: price, image: imageSrc};
            totalPrice += price;
            
            console.log('Item added:', name, 'Total items:', selectedAddons.length);
            
            // 4. Visual feedback - highlight the card
            element.classList.add('selected-gift');
            element.style.borderColor = '#ff6b6b';
            element.style.borderWidth = '3px';
            element.style.backgroundColor = '#ff6b6b15';
            element.style.boxShadow = '0 0 0 3px rgba(255, 107, 107, 0.2)';
            element.style.transform = 'scale(0.98)';
            
            // Add checkmark badge if not already present
            let badge = element.querySelector('.selected-badge');
            if (!badge) {
                badge = document.createElement('div');
                badge.className = 'selected-badge absolute -top-2 -right-2 w-6 h-6 bg-[#ff6b6b] rounded-full flex items-center justify-center text-white text-xs font-bold z-10';
                badge.innerHTML = '✓';
                element.style.position = 'relative';
                element.appendChild(badge);
            }
            
            // Update icon to show it's selected
            const iconContainer = element.querySelector('.w-5.h-5');
            if (iconContainer) {
                iconContainer.className = 'w-5 h-5 rounded-full bg-[#ff6b6b] flex items-center justify-center text-white';
                const icon = iconContainer.querySelector('svg');
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                }
            }
            
            // 5. Add item to box visually after animation completes (faster)
            setTimeout(() => {
                addItemToBoxVisual(id, name, imageSrc);
                // Remove the flying clone
                if (clone && clone.parentNode) {
                    clone.remove();
                }
            }, 500);

            updateUI();
            saveState(); // Save state to localStorage
            
            // Enable checkout button when item is selected
            const checkoutBtn = document.getElementById('checkout-btn');
            if (checkoutBtn && selectedAddons.length > 0) {
                checkoutBtn.disabled = false;
            }

            const feedback = document.getElementById('feedback-msg');
            if(feedback) {
                feedback.textContent = name + ' added! ✨';
                feedback.style.opacity = '1';
                setTimeout(() => feedback.style.opacity = '0', 2000);
            }

            // Cleanup processing state
            setTimeout(() => {
                element.classList.remove('processing');
            }, 500);
        } catch(e) {
            console.error("Add item error", e);
            // Fallback - add without animation
            selectedAddons.push(id);
            const uniqueKey = id + '_' + Date.now();
            selectedItems[uniqueKey] = {id: id, name: name, price: price, image: imageSrc};
            totalPrice += price;
            addItemToBoxVisual(id, name, imageSrc);
            
            // Highlight the card
            element.classList.add('selected-gift');
            element.style.borderColor = '#ff6b6b';
            element.style.borderWidth = '3px';
            element.style.backgroundColor = '#ff6b6b15';
            element.style.boxShadow = '0 0 0 3px rgba(255, 107, 107, 0.2)';
            
            updateUI();
            element.classList.remove('processing');
        }
    }

    function removeItemFromBox(id, element, price) {
        console.log('removeItemFromBox called', id);
        
        // Remove from selected arrays
        const index = selectedAddons.indexOf(id);
        if (index > -1) {
            selectedAddons.splice(index, 1);
        }
        
        // Remove from selectedItems (remove one instance)
        const keys = Object.keys(selectedItems);
        for (let i = keys.length - 1; i >= 0; i--) {
            if (selectedItems[keys[i]].id === id) {
                totalPrice -= selectedItems[keys[i]].price;
                delete selectedItems[keys[i]];
                break; // Remove only one instance
            }
        }
        
        // Remove visual highlighting
        element.classList.remove('selected-gift');
        element.style.borderColor = '';
        element.style.borderWidth = '';
        element.style.backgroundColor = '';
        element.style.boxShadow = '';
        element.style.transform = '';
        
        // Remove checkmark badge
        const badge = element.querySelector('.selected-badge');
        if (badge) {
            badge.remove();
        }
        
        // Reset icon to plus
        const iconContainer = element.querySelector('.w-5.h-5');
        if (iconContainer) {
            iconContainer.className = 'w-5 h-5 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 group-hover:bg-[#ff6b6b] group-hover:text-white transition-colors';
            const icon = iconContainer.querySelector('svg');
            if (icon) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>';
            }
        }
        
        // Remove from box visually
        const container = document.getElementById('added-items-container');
        if (container) {
            const items = container.querySelectorAll(`[data-item-id="${id}"]`);
            if (items.length > 0) {
                // Remove the first matching item with animation
                const itemToRemove = items[0];
                itemToRemove.style.transition = 'all 0.3s ease-out';
                itemToRemove.style.opacity = '0';
                itemToRemove.style.transform = 'scale(0)';
                setTimeout(() => {
                    itemToRemove.remove();
                }, 300);
            }
        }
        
        // Show feedback
        const feedback = document.getElementById('feedback-msg');
        if(feedback) {
            const itemName = element.dataset.giftName || 'Item';
            feedback.textContent = itemName + ' removed';
            feedback.style.opacity = '1';
            setTimeout(() => feedback.style.opacity = '0', 1500);
        }
        
        // Update UI
        updateUI();
        saveState(); // Save state to localStorage
        
        // Disable checkout button if no items selected
        const checkoutBtn = document.getElementById('checkout-btn');
        if (checkoutBtn && selectedAddons.length === 0) {
            checkoutBtn.disabled = true;
        }
    }

    function addItemToBoxVisual(id, name, imageSrc) {
        const container = document.getElementById('added-items-container');
        if (!container) return;
        
        const itemDiv = document.createElement('div');
        itemDiv.className = 'added-item w-14 h-14 bg-white rounded-lg shadow-lg flex items-center justify-center p-1 border-2 border-[#ff6b6b]';
        itemDiv.setAttribute('data-item-id', id);
        itemDiv.title = name;
        itemDiv.style.animation = 'fadeInScale 0.3s ease-out';
        
        if (imageSrc && imageSrc.trim() !== '') {
            const img = document.createElement('img');
            img.src = imageSrc;
            img.className = 'w-full h-full object-contain';
            img.alt = name;
            img.onerror = function() {
                // If image fails to load, show emoji instead
                this.style.display = 'none';
                itemDiv.innerHTML = '<span class="text-xl">🎁</span>';
            };
            itemDiv.appendChild(img);
        } else {
            itemDiv.innerHTML = '<span class="text-xl">🎁</span>';
        }
        
        container.appendChild(itemDiv);
    }

    function updateUI() {
        console.log('updateUI called', selectedAddons.length, totalPrice);
        
        // Update Total Badge
        const badge = document.getElementById('item-counter');
        if (badge) {
            const count = selectedAddons.length;
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('scale-0');
                badge.classList.add('scale-125'); // bump effect
                setTimeout(() => badge.classList.remove('scale-125'), 150);
            } else {
                badge.classList.add('scale-0');
            }
        }
        
        // Show/hide empty box message
        const emptyBoxMessage = document.getElementById('empty-box-message');
        if (emptyBoxMessage) {
            if (selectedAddons.length === 0) {
                emptyBoxMessage.classList.remove('hidden');
                emptyBoxMessage.style.opacity = '1';
            } else {
                emptyBoxMessage.style.opacity = '0';
                setTimeout(() => {
                    emptyBoxMessage.classList.add('hidden');
                }, 300);
            }
        }

        // Update Selected Items List
        const container = document.getElementById('selected-items-container');
        if (container) {
            const totalItems = Object.keys(selectedItems).length;
            if (totalItems === 0) {
                container.innerHTML = '<p class="text-xs text-gray-400 dark:text-gray-500 italic">No items added yet</p>';
            } else {
                container.innerHTML = '';
                
                // Calculate discount percentage
                const discountPercentage = {{ \App\Models\Setting::getDiscountPercentage() }};
                const subtotal = totalPrice;
                const discount = selectedAddons.length > 0 ? subtotal * (discountPercentage / 100) : 0;
                const total = subtotal - discount;
                
                // Count items by ID
                const itemCounts = {};
                Object.values(selectedItems).forEach(item => {
                    if (!itemCounts[item.id]) {
                        itemCounts[item.id] = {name: item.name, price: item.price, count: 0};
                    }
                    itemCounts[item.id].count++;
                });
                
                // Calculate discount per item (proportional to item price)
                const discountPerItem = selectedAddons.length > 0 ? discount / subtotal : 0;
                
                // Display all items with counts and discounted prices
                Object.keys(itemCounts).forEach(id => {
                    const item = itemCounts[id];
                    const itemSubtotal = parseFloat(item.price) * item.count;
                    const itemDiscount = itemSubtotal * discountPerItem;
                    const itemTotal = itemSubtotal - itemDiscount;
                    const countText = item.count > 1 ? ` (x${item.count})` : '';
                    
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex items-center justify-between text-xs bg-[#ff6b6b]/10 dark:bg-[#ff6b6b]/20 rounded-lg px-2 py-1 mb-1';
                    
                    if (selectedAddons.length > 0 && discount > 0) {
                        // Show original price with strikethrough and discounted price
                        itemDiv.innerHTML = `
                            <span class="text-gray-700 dark:text-gray-300 font-medium">${item.name}${countText}</span>
                            <div class="flex flex-col items-end">
                                <span class="text-gray-400 dark:text-gray-500 line-through text-[10px]">Rs. ${itemSubtotal.toFixed(2)}</span>
                                <span class="text-[#ff6b6b] font-bold">Rs. ${itemTotal.toFixed(2)}</span>
                            </div>
                        `;
                    } else {
                        // Show regular price if no discount
                        itemDiv.innerHTML = `
                            <span class="text-gray-700 dark:text-gray-300 font-medium">${item.name}${countText}</span>
                            <span class="text-[#ff6b6b] font-bold">Rs. ${itemSubtotal.toFixed(2)}</span>
                        `;
                    }
                    container.appendChild(itemDiv);
                });
            }
        }

        // Update Price Text with discount
        const discountPercentage = {{ \App\Models\Setting::getDiscountPercentage() }};
        const subtotal = totalPrice;
        const discount = selectedAddons.length > 0 ? subtotal * (discountPercentage / 100) : 0;
        const total = subtotal - discount;
        
        const totalElement = document.getElementById('current-total');
        if (totalElement) {
            totalElement.textContent = 'Rs. ' + total.toLocaleString('en-US', {minimumFractionDigits: 2});
        }
        
        // Save state after UI update
        saveState();
    }

    function finishCustomization() {
        // Check if at least one gift is selected
        if (selectedAddons.length === 0) {
            alert('Please select at least one gift!');
            return;
        }

        // Save state before navigating
        saveState();

        // 1. Close the Lid
        const lid = document.getElementById('box-lid');
        lid.classList.remove('lid-open');
        lid.classList.add('lid-closed');

        // 2. Hide selection UI to show simple "Packing your gift..." state or just wait
        const selection = document.getElementById('state-selection');
        selection.style.opacity = '0';

        // 3. Prepare Form Data - send all selected gifts as selected_gifts[]
        const container = document.getElementById('form-inputs-container');
        container.innerHTML = '';
        
        // Add all selected gifts
        selectedAddons.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_gifts[]';
            input.value = id;
            container.appendChild(input);
        });

        // 4. Submit after a short delay for animation
        setTimeout(() => {
            document.getElementById('checkout-form').submit();
        }, 1000);
    }
    
    // Clear state when order is successfully submitted (optional - can be called from checkout page)
    function clearCustomizeState() {
        localStorage.removeItem('giftCustomizeState');
    }
</script>
@endsection
