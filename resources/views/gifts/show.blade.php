@extends('layouts.app')

@section('title', $gift->name . ' - Hamro Yaad')

@section('content')
<div class="min-h-screen bg-white dark:bg-[#0f172a] py-20">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-[#cbd5e1]">
                <a href="/" class="hover:text-[#ff6b6b] transition-colors">Home</a>
                <span>/</span>
                <a href="#gifts" class="hover:text-[#ff6b6b] transition-colors">Gifts</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white">{{ $gift->name }}</span>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Gift Image -->
            <div class="flex justify-center lg:justify-start">
                <div class="relative group max-w-lg w-full">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl transform group-hover:scale-[1.02] transition-transform duration-300">
                        @if($gift->image)
                            <img src="{{ asset('storage/' . $gift->image) }}" alt="{{ $gift->name }}" class="w-full h-auto object-contain rounded-3xl">
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-[#1e293b] dark:to-[#334155] rounded-3xl flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Gift Details -->
            <div class="flex flex-col justify-center">
                <h1 class="text-5xl md:text-6xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">{{ $gift->name }}</span>
                </h1>
                
                @if($gift->description)
                    <p class="text-xl text-gray-600 dark:text-[#cbd5e1] mb-8 leading-relaxed">
                        {{ $gift->description }}
                    </p>
                @endif

                <div class="mb-8">
                    <div class="text-5xl font-black text-[#ff6b6b] mb-2">
                        Rs. {{ number_format($gift->price, 2) }}
                    </div>
                    <p class="text-gray-600 dark:text-[#cbd5e1]">Base Price</p>
                </div>

                <!-- Features -->
                <div class="mb-8 space-y-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700 dark:text-[#cbd5e1]">Premium Quality</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700 dark:text-[#cbd5e1]">Customizable with Addons</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700 dark:text-[#cbd5e1]">Fast Delivery Available</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('gifts.customize', $gift->id) }}" class="flex-1 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl text-center font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all text-lg">
                        Customize Gift
                    </a>
                    <a href="#gifts" class="flex-1 bg-gray-100 dark:bg-[#1e293b] text-gray-900 dark:text-white px-8 py-4 rounded-xl text-center font-bold tracking-wide hover:bg-gray-200 dark:hover:bg-[#334155] transition-all text-lg">
                        Browse More
                    </a>
                </div>
            </div>
        </div>

        <!-- Available Addons Preview -->
        @if($gift->addons->count() > 0)
        <div class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black mb-4 tracking-tight">
                    <span class="text-gray-900 dark:text-white">Available Addons</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-[#cbd5e1]">
                    Customize your gift by adding these special items
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($gift->addons->take(8) as $addon)
                <div class="bg-white dark:bg-[#0f172a] rounded-2xl p-4 border border-gray-200 dark:border-[#334155] hover:border-[#ff6b6b] transition-all">
                    @if($addon->image)
                        <div class="bg-gray-100 dark:bg-[#1e293b] rounded-xl mb-3 flex items-center justify-center overflow-hidden" style="min-height: 128px;">
                            <img src="{{ asset('storage/' . $addon->image) }}" alt="{{ $addon->name }}" class="w-full h-auto max-h-32 object-contain rounded-xl">
                        </div>
                    @else
                        <div class="w-full h-32 bg-gray-100 dark:bg-[#1e293b] rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm">{{ $addon->name }}</h3>
                    <p class="text-[#ff6b6b] font-black">Rs. {{ number_format($addon->price, 2) }}</p>
                </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('gifts.customize', $gift->id) }}" class="inline-block bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-8 py-4 rounded-xl font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                    View All Addons & Customize
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
