<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - E-Commerce Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        h1, h2, h3, h4, .serif { font-family: 'Playfair Display', serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .fade-in { animation: fadeIn 1.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#0a0a0a] text-slate-200 font-sans antialiased selection:bg-pink-900 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-[2px] border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 text-2xl font-serif italic font-bold text-white tracking-tighter hover:text-pink-300 transition-colors">
                 @if($business->logo)
                    <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-10 w-auto rounded-full border border-white/20">
                @endif
                {{ $business->business_name }}
            </a>
            
            <div class="hidden md:flex items-center gap-10 text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
                <a href="#about" class="hover:text-white transition-colors">About</a>
                <a href="#products" class="hover:text-white transition-colors">Shop</a>
                <a href="#contact" class="hover:text-white transition-colors">Contact</a>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white text-slate-900 px-6 py-3 rounded-full hover:bg-slate-200 transition-transform hover:scale-105">Shop Now</a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#1a1a1a] border-b border-slate-800 p-6 flex flex-col gap-6 text-center shadow-2xl">
            <a href="#about" class="text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-white">About</a>
            <a href="#products" class="text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-white">Shop</a>
            <a href="#contact" class="text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-white">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative h-screen min-h-[600px] overflow-hidden flex items-center justify-center">
        <!-- Background Slider -->
        <div class="absolute inset-0 z-0">
             @if($business->banners->count() > 0)
                <div class="relative w-full h-full" id="hero-slider">
                    @foreach($business->banners as $key => $banner)
                         <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $key === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide>
                            <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}" class="w-full h-full object-cover scale-105 animate-[pulse_20s_infinite]">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full h-full bg-gradient-to-br from-pink-900 via-slate-900 to-black"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center px-6 max-w-5xl fade-in">
            <span class="text-pink-400 text-[10px] font-black uppercase tracking-[0.4em] mb-6 block">Premium E-Commerce</span>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif italic text-white mb-8 leading-[0.9] tracking-tight">
                {{ $business->business_name }}
            </h1>
            <p class="text-slate-300 text-lg md:text-xl max-w-2xl mx-auto mb-12 font-light leading-relaxed">
                {{ $business->description }}
            </p>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I would like to browse your products.') }}" class="bg-white text-black px-10 py-4 rounded-full text-[11px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Start Shopping
                </a>
                @endif

                @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="text-white border border-white/20 px-10 py-4 rounded-full text-[11px] font-black uppercase tracking-widest hover:bg-white/10 transition-all">
                    Call Us
                </a>
                @endif
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-24 bg-[#0a0a0a] relative border-t border-white/5">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-pink-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">About Us</span>
            <h2 class="text-4xl md:text-5xl font-serif italic text-white mb-8">{{ $business->business_name }}</h2>
            <p class="text-slate-400 text-lg leading-relaxed">{{ $business->description }}</p>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-24 bg-[#111111] relative border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-pink-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Our Collection</span>
                <h2 class="text-4xl md:text-5xl font-serif italic text-white">Featured Products</h2>
            </div>

            <!-- Category Filter -->
            @if($business->categories->count() > 0)
            <div class="flex gap-3 mb-16 overflow-x-auto no-scrollbar pb-2 justify-center">
                <button class="menu-tab active px-8 py-3 bg-white text-black rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:bg-pink-200 whitespace-nowrap" data-category="all">All</button>
                @foreach($business->categories as $category)
                <button class="menu-tab px-8 py-3 bg-transparent border border-slate-700 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:border-slate-500 hover:text-white whitespace-nowrap" data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($business->products as $product)
            <div class="menu-item group cursor-pointer" data-category="{{ $product->category->slug ?? 'all' }}"
                 onclick="window.location.href='https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I am interested in: ' . $product->name) }}'">
                
                <div class="relative h-96 overflow-hidden mb-6 filter sepia-[.2] group-hover:sepia-0 transition-all duration-700 bg-neutral-900">
                    @if($product->image)
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl text-neutral-700">🛍️</div>
                    @endif
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                    
                    @if($product->discount_price)
                        <div class="absolute top-4 right-4 bg-pink-500 text-white text-[10px] font-black px-3 py-1 rounded-sm uppercase tracking-widest">
                            Sale
                        </div>
                    @endif
                    
                    <div class="absolute top-4 left-4 bg-white text-black text-[10px] font-black px-3 py-1 rounded-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 duration-300">
                        Shop Now
                    </div>
                </div>

                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-base font-bold text-white group-hover:text-pink-300 transition-colors">{{ $product->name }}</h3>
                </div>
                
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-3">{{ $product->category->name }}</p>
                
                <div class="flex items-baseline gap-3">
                    @if($product->discount_price)
                        <span class="text-pink-400 text-lg font-black">Rs {{ number_format($product->discount_price) }}</span>
                        <span class="text-slate-600 text-sm line-through">Rs {{ number_format($product->price) }}</span>
                    @else
                        <span class="text-white text-lg font-black">Rs {{ number_format($product->price) }}</span>
                    @endif
                </div>
            </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-slate-900 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 border border-slate-800">🛒</div>
                    <h3 class="text-2xl font-serif italic text-white mb-2">Collection Coming Soon</h3>
                    <p class="text-slate-500 text-sm">We're curating something special for you.</p>
                </div>
            @endforelse
            </div>
        </div>
    </section>
        

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-[#0a0a0a] relative border-t border-white/5">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-pink-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Get In Touch</span>
                <h2 class="text-4xl md:text-5xl font-serif italic text-white mb-6">Contact Us</h2>
                <p class="text-slate-400 text-lg">Have questions? We're here to help.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                @if($business->phone)
                <div class="bg-[#111111] p-8 rounded-2xl border border-white/5 hover:border-pink-500/30 transition-all">
                    <div class="text-4xl mb-4">📞</div>
                    <h3 class="text-white font-bold mb-2">Phone</h3>
                    <a href="tel:{{ $business->phone }}" class="text-pink-400 hover:text-pink-300">{{ $business->phone }}</a>
                </div>
                @endif

                @if($business->whatsapp_number)
                <div class="bg-[#111111] p-8 rounded-2xl border border-white/5 hover:border-pink-500/30 transition-all">
                    <div class="text-4xl mb-4">💬</div>
                    <h3 class="text-white font-bold mb-2">WhatsApp</h3>
                    <a href="https://wa.me/{{ $business->whatsapp_number }}" class="text-pink-400 hover:text-pink-300">Chat with us</a>
                @endif
            </div>

            @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
            <div class="flex justify-center gap-4 mb-12">
                @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                    <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="w-12 h-12 bg-[#111111] text-white rounded-full flex items-center justify-center border border-white/5 hover:border-pink-500 hover:text-pink-500 transition-all">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="w-12 h-12 bg-[#111111] text-white rounded-full flex items-center justify-center border border-white/5 hover:border-pink-500 hover:text-pink-500 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                    </a>
                @endif
                @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="w-12 h-12 bg-[#111111] text-white rounded-full flex items-center justify-center border border-white/5 hover:border-pink-500 hover:text-pink-500 transition-all">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
            @endif

            @if($business->google_maps_link)
            <div class="rounded-2xl overflow-hidden h-96 grayscale hover:grayscale-0 transition-all duration-700 border border-white/5">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    scrolling="no" 
                    marginheight="0" 
                    marginwidth="0" 
                    src="https://maps.google.com/maps?q={{ urlencode($business->address ?? $business->business_name) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                ></iframe>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black border-t border-white/5 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-slate-500 text-sm mb-2">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>
            <p class="text-slate-700 text-xs uppercase tracking-widest">Powered by Hamro Yaad</p>
        </div>
    </footer>

    <script>
        // Category Filtering
        const tabs = document.querySelectorAll('.menu-tab');
        const cards = document.querySelectorAll('.menu-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active state
                tabs.forEach(t => {
                    t.classList.remove('active', 'bg-slate-900', 'text-white');
                    t.classList.add('bg-slate-50', 'text-slate-400');
                });
                tab.classList.add('active', 'bg-slate-900', 'text-white');
                tab.classList.remove('bg-slate-50', 'text-slate-400');

                const category = tab.dataset.category;

                cards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
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
