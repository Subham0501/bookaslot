<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - Hamro Yaad Showcase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .dark .glass { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(10px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <!-- Floating Navigation -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-4xl">
        <div class="glass border border-white/20 rounded-[2rem] px-8 py-4 shadow-2xl flex justify-between items-center">
            <div class="flex items-center gap-4">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" class="w-10 h-10 rounded-xl object-cover shadow-lg">
                @else
                    <div class="w-10 h-10 bg-[#ff6b6b] rounded-xl flex items-center justify-center text-white text-xl">🏠</div>
                @endif
                <span class="text-xl font-black tracking-tight">{{ $business->business_name }}</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#products" class="font-bold hover:text-[#ff6b6b] transition-colors">Products</a>
                <a href="#about" class="font-bold hover:text-[#ff6b6b] transition-colors">About</a>
                <a href="#contact" class="font-bold hover:text-[#ff6b6b] transition-colors">Contact</a>
            </div>
            <div class="flex items-center gap-3">
                @if($business->phone)
                    <a href="tel:{{ $business->phone }}" class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">📞</a>
                @endif
                @if($business->whatsapp_number)
                    <a href="https://wa.me/{{ $business->whatsapp_number }}" class="w-10 h-10 bg-[#25d366] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">💬</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero / Banners -->
    <section class="relative pt-32 pb-12 px-6">
        <div class="max-w-7xl mx-auto">
            @if($business->banners->count() > 0)
                <div class="relative rounded-[3rem] overflow-hidden shadow-3xl aspect-[21/9] bg-gray-200">
                    <div class="absolute inset-0 flex transition-transform duration-700 ease-in-out" id="banner-track">
                        @foreach($business->banners as $banner)
                            <div class="min-w-full relative">
                                <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-12">
                                    <h2 class="text-4xl md:text-6xl font-black text-white mb-4">{{ $banner->title }}</h2>
                                    <p class="text-white/80 max-w-2xl font-medium text-lg">{{ $banner->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-[3rem] p-16 md:p-32 text-center text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h1 class="text-5xl md:text-8xl font-black mb-8">{{ $business->business_name }}</h1>
                        <p class="text-xl md:text-2xl font-medium max-w-3xl mx-auto opacity-90">{{ $business->description }}</p>
                    </div>
                    <!-- Abstract decors -->
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
                </div>
            @endif
        </div>
    </section>

    <!-- Categories Tab -->
    @if($business->categories->count() > 0)
    <section class="py-8 sticky top-28 z-40 bg-gray-50/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pb-2">
                <button class="category-tab active px-8 py-3 rounded-2xl bg-gray-900 text-white font-black whitespace-nowrap transition-all shadow-xl shadow-gray-900/20" data-category="all">All Items</button>
                @foreach($business->categories as $category)
                    <button class="category-tab px-8 py-3 rounded-2xl bg-white text-gray-500 hover:text-gray-900 font-bold whitespace-nowrap transition-all border border-gray-100 shadow-sm" data-category="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Products Showcase -->
    <section id="products" class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10" id="product-grid">
                @forelse($business->products as $product)
                    <div class="product-card group bg-white rounded-[3rem] p-6 shadow-xl border border-gray-50 transition-all hover:shadow-2xl hover:-translate-y-2" data-category="{{ $product->category->slug }}">
                        <div class="relative aspect-square rounded-[2rem] overflow-hidden bg-gray-200 mb-6">
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl">🛍️</div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-[#ff6b6b] shadow-lg">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black mb-4 group-hover:text-[#ff6b6b] transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-3xl font-black text-gray-900">Rs {{ number_format($product->price) }}</span>
                                @if($product->discount_price)
                                    <span class="block text-sm text-gray-400 line-through">Rs {{ number_format($product->discount_price) }}</span>
                                @endif
                            </div>
                            <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Hi, I am interested in ' . $product->name . ' from ' . $business->business_name . '.') }}" class="w-14 h-14 bg-[#25d366] text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-[#25d366]/20 hover:scale-110 active:scale-95 transition-all">
                                💬
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center">
                        <span class="text-8xl mb-8 block">🐚</span>
                        <h3 class="text-3xl font-black text-gray-300">Nothing here yet</h3>
                        <p class="text-gray-400 font-bold">Check back soon for amazing products!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- About & Location -->
    <section id="about" class="py-24 px-6 bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20">
            <div>
                <h2 class="text-5xl font-black mb-10 tracking-tight">About <span class="text-[#ff6b6b]">{{ $business->business_name }}</span></h2>
                <div class="prose prose-xl text-gray-600 font-medium leading-relaxed mb-12">
                    {!! nl2br(e($business->description)) !!}
                </div>
                
                <div class="space-y-6">
                    @if($business->phone)
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-[#ff6b6b] group-hover:text-white transition-all">📞</div>
                        <a href="tel:{{ $business->phone }}" class="text-xl font-black">{{ $business->phone }}</a>
                    </div>
                    @endif
                    @if($business->whatsapp_number)
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-[#25d366] group-hover:text-white transition-all">💬</div>
                        <a href="https://wa.me/{{ $business->whatsapp_number }}" class="text-xl font-black">WhatsApp Chat</a>
                    </div>
                    @endif
                </div>
                
                @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
                    <div class="flex gap-4 mt-8">
                        @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                            <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                            </a>
                        @endif
                        @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                            <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="w-12 h-12 bg-pink-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                            </a>
                        @endif
                         @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                            <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div id="contact">
                @if($business->google_maps_link)
                    <div class="rounded-[4rem] overflow-hidden shadow-2xl h-[500px] border-8 border-gray-50 relative group">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            scrolling="no" 
                            marginheight="0" 
                            marginwidth="0" 
                            src="https://maps.google.com/maps?q={{ urlencode($business->address ?? $business->business_name) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="grayscale hover:grayscale-0 transition-all duration-1000"
                        ></iframe>
                        <a href="{{ $business->google_maps_link }}" target="_blank" class="absolute bottom-10 left-10 right-10 bg-white p-6 rounded-3xl shadow-2xl flex items-center justify-between group-hover:-translate-y-2 transition-transform">
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Our Location</p>
                                <p class="font-black text-lg">{{ $business->address ?? 'Nepal' }}</p>
                            </div>
                            <span class="w-12 h-12 bg-blue-500 text-white rounded-xl flex items-center justify-center text-2xl">📍</span>
                        </a>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[4rem] p-16 h-full text-white flex flex-col justify-center">
                        <h3 class="text-4xl font-black mb-6">Contact Us Directly</h3>
                        <p class="text-xl opacity-90 mb-12">We are ready to assist you any time. Reach out through our social channels or phone.</p>
                        <div class="grid grid-cols-2 gap-4">
                            @if($business->phone)
                                <a href="tel:{{ $business->phone }}" class="bg-white/20 backdrop-blur-md p-6 rounded-3xl text-center font-black hover:bg-white/30 transition-all">Call Now</a>
                            @endif
                            @if($business->whatsapp_number)
                                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white/20 backdrop-blur-md p-6 rounded-3xl text-center font-black hover:bg-white/30 transition-all">WhatsApp</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="py-12 bg-white border-t border-gray-100 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <p class="font-bold text-gray-400">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>
            <p class="text-xs text-gray-300 mt-2 uppercase tracking-tight">Powered by <a href="/" class="hover:text-[#ff6b6b]">Hamro Yaad</a></p>
        </div>
    </footer>

    <script>
        // Category Filtering
        const tabs = document.querySelectorAll('.category-tab');
        const cards = document.querySelectorAll('.product-card');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active state
                tabs.forEach(t => {
                    t.classList.remove('active', 'bg-gray-900', 'text-white', 'shadow-xl', 'shadow-gray-900/20');
                    t.classList.add('bg-white', 'text-gray-500', 'border-gray-100', 'shadow-sm');
                });
                tab.classList.add('active', 'bg-gray-900', 'text-white', 'shadow-xl', 'shadow-gray-900/20');
                tab.classList.remove('bg-white', 'text-gray-500', 'border-gray-100', 'shadow-sm');

                const category = tab.dataset.category;

                cards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                        setTimeout(() => card.style.opacity = '1', 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                });
            });
        });

        // Simple Banner Slider
        const track = document.getElementById('banner-track');
        if (track) {
            let index = 0;
            const count = track.children.length;
            setInterval(() => {
                index = (index + 1) % count;
                track.style.transform = `translateX(-${index * 100}%)`;
            }, 5000);
        }
    </script>
</body>
</html>
