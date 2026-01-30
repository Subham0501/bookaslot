@extends('layouts.app')

@section('title', 'Customize Your Gift - Hamro Yaad')

@section('content')
<div class="min-h-screen bg-white dark:bg-[#0f172a] py-20">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                <span class="text-gray-900 dark:text-white">Customize Your</span>
                <span class="block text-[#ff6b6b]">Perfect Gift</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-[#cbd5e1] max-w-2xl mx-auto">
                Select a gift and add photo frames, chocolates, flowers, and more to make it extra special!
            </p>
        </div>

        <!-- Gifts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @forelse($gifts as $gift)
            <div class="group relative bg-white dark:bg-[#0f172a] rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-[#334155]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ff6b6b]/10 to-transparent rounded-bl-full"></div>
                
                <!-- Gift Image -->
                <div class="relative h-64 overflow-hidden bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100 dark:from-[#1e293b] dark:via-[#0f172a] dark:to-[#1e293b]">
                    @if($gift->image && file_exists(storage_path('app/public/' . $gift->image)))
                        <img 
                            src="{{ asset('storage/' . $gift->image) }}" 
                            alt="{{ $gift->name }}" 
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center gap-3\'><svg class=\'w-20 h-20 text-gray-400 dark:text-gray-600\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><span class=\'text-xs text-gray-500 dark:text-gray-500\'>No Image</span></div>';"
                        >
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center gap-3">
                            <div class="relative">
                                <svg class="w-20 h-20 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">Gift Image</span>
                        </div>
                    @endif
                </div>
                
                <!-- Gift Content -->
                <div class="p-6 relative z-10">
                    <h3 class="text-2xl font-black mb-2 text-gray-900 dark:text-white">{{ $gift->name }}</h3>
                    @if($gift->description)
                        <p class="text-gray-600 dark:text-[#cbd5e1] mb-4 line-clamp-2">{{ $gift->description }}</p>
                    @endif
                    
                    <div class="mb-6">
                        <span class="text-3xl font-black text-[#ff6b6b]">Rs. {{ number_format($gift->price, 2) }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">Base Price</span>
                    </div>
                    
                    <a href="{{ route('gifts.customize', $gift->id) }}" class="block w-full bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white px-6 py-3 rounded-xl text-center font-bold tracking-wide hover:shadow-lg hover:shadow-[#ff6b6b]/30 transition-all">
                        Customize Gift
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 dark:text-[#cbd5e1] text-lg">No gifts available at the moment. Check back soon!</p>
            </div>
            @endforelse
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="/" class="inline-block text-gray-600 dark:text-[#cbd5e1] hover:text-[#ff6b6b] transition-colors font-medium">
                ← Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
