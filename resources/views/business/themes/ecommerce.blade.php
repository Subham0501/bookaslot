<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - Premium Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        h1, h2, h3, h4, .serif { font-family: 'Playfair Display', serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .premium-border {
            position: relative;
        }
        .premium-border::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #fff;
            transition: width 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .premium-border:hover::after {
            width: 100%;
        }

        .fade-in { animation: fadeIn 1.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    </style>
</head>
<body class="bg-[#080808] text-neutral-300 font-sans antialiased selection:bg-white selection:text-black">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-500 border-b border-white/0" id="navbar">
        <div class="max-w-7xl mx-auto px-8 py-8 flex justify-between items-center">
            <a href="#" class="flex items-center gap-4 text-3xl font-serif italic font-bold text-white tracking-tighter group">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-12 w-auto rounded-none border border-white/10 group-hover:border-white/30 transition-all">
                @endif
                <span class="group-hover:translate-x-1 transition-transform">{{ $business->business_name }}</span>
            </a>
            
            <div class="hidden md:flex items-center gap-12 text-[10px] font-black uppercase tracking-[0.3em] text-neutral-400">
                <a href="#about" class="premium-border text-white transition-colors">House</a>
                <a href="#products" class="premium-border transition-colors hover:text-white">Collection</a>
                <a href="#contact" class="premium-border transition-colors hover:text-white">Boutique</a>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white text-black px-8 py-3 rounded-none hover:bg-neutral-200 transition-all transform hover:scale-105 shadow-[0_0_20px_rgba(255,255,255,0.1)]">Shop Now</a>
                @endif
            </div>

            <!-- Mobile menu button -->
            <button class="md:hidden text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 8h16M4 16h16"></path></svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full glass p-8 flex flex-col gap-6 text-center">
            <a href="#about" class="text-xs font-black uppercase tracking-widest text-white">House</a>
            <a href="#products" class="text-xs font-black uppercase tracking-widest text-neutral-400">Collection</a>
            <a href="#contact" class="text-xs font-black uppercase tracking-widest text-neutral-400">Boutique</a>
        </div>
    </nav>

    <!-- Header / Hero -->
    <header class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            @if($business->banners->count() > 0)
                <div class="relative w-full h-full" id="hero-slider">
                    @foreach($business->banners as $key => $banner)
                         <div class="absolute inset-0 transition-opacity duration-1500 ease-in-out {{ $key === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide>
                            <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}" class="w-full h-full object-cover scale-110 animate-[pulse_30s_infinite]">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full h-full bg-[#050505]"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-[#080808]/40 via-transparent to-[#080808]"></div>
        </div>

        <div class="relative z-10 text-center px-6 max-w-6xl fade-in">
            <span class="text-white text-[10px] md:text-xs font-black uppercase tracking-[0.5em] mb-8 block opacity-70">Exquisite Collection</span>
            
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-serif italic text-white mb-10 tracking-tighter leading-[0.85] drop-shadow-2xl">
                The New <br><span class="text-neutral-400">Standard</span>
            </h1>
            
            <p class="text-neutral-300 text-xs md:text-sm font-light tracking-[0.3em] mb-14 uppercase max-w-2xl mx-auto leading-loose opacity-80">
                Curating the finest essentials for the modern lifestyle.
            </p>
            
            <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I would like to browse the collection.') }}" 
                   class="group bg-white text-black px-12 py-5 text-[10px] font-black uppercase tracking-[0.2em] transform transition-all hover:scale-105 hover:shadow-[0_0_40px_rgba(255,255,255,0.15)]">
                    Explore Collection
                </a>
                @endif
                <a href="#products" class="text-white text-[10px] font-black uppercase tracking-[0.2em] flex items-center gap-4 group">
                    View Catalog <span class="group-hover:translate-y-1 transition-transform">↓</span>
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-30">
            <div class="w-px h-20 bg-gradient-to-b from-white to-transparent"></div>
        </div>
    </header>

    <!-- Intro Section -->
    <section id="about" class="py-32 bg-[#080808] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            <div class="relative order-2 lg:order-1">
                <div class="aspect-[3/4] overflow-hidden relative border border-white/5">
                    @php
                        $introImage = $business->banners->skip(1)->first()?->image ?? $business->products->first()?->image;
                    @endphp
                    @if($introImage)
                        <img src="{{ Str::startsWith($introImage, 'http') ? $introImage : asset('storage/' . $introImage) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                    @else
                        <div class="w-full h-full bg-[#111] shimmering-placeholder shimmer"></div>
                    @endif
                </div>
                <!-- Float elements -->
                <div class="absolute -top-12 -right-12 w-48 h-48 border border-white/5 rounded-full glass hidden lg:flex items-center justify-center animate-[pulse_10s_infinite]">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40">Est. {{ $business->established_year ?? ($business->created_at ? $business->created_at->format('Y') : date('Y')) }}</span>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <span class="text-neutral-500 text-[10px] font-black uppercase tracking-[0.4em] mb-6 block">The House</span>
                <h2 class="text-5xl md:text-7xl font-serif italic text-white mb-10 leading-tight">
                    Crafted with <br><span class="text-neutral-600">Precision.</span>
                </h2>
                <div class="w-24 h-px bg-white/10 mb-12"></div>
                <p class="text-neutral-400 text-lg leading-relaxed font-light italic mb-12">
                    "{{ $business->description ?? 'We believe that luxury is in the details. Every piece in our collection is selected to provide a seamless blend of style and function.' }}"
                </p>
                <div class="grid grid-cols-2 gap-8 text-[10px] font-black uppercase tracking-[0.2em] text-white/60">
                    <div class="flex items-center gap-4">
                        <span class="w-2 h-2 bg-white rounded-full"></span> Handpicked
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="w-2 h-2 bg-white rounded-full"></span> Premium Quality
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Collection -->
    <section id="products" class="py-32 bg-[#0a0a0a] border-t border-white/5 relative">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-24">
                <div class="max-w-xl">
                    <span class="text-neutral-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Archive</span>
                    <h2 class="text-5xl md:text-6xl font-serif italic text-white">The Collection</h2>
                </div>
                
                @if($business->categories->count() > 0)
                <div class="flex flex-wrap gap-8 text-[10px] font-black uppercase tracking-widest text-neutral-500 overflow-x-auto no-scrollbar pb-2">
                    <button class="menu-tab active text-white border-b border-white pb-2 transition-all" data-category="all">All Pieces</button>
                    @foreach($business->categories as $category)
                    <button class="menu-tab hover:text-white transition-all pb-2" data-category="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24">
                @forelse($business->products as $product)
                <div class="menu-item group" data-category="{{ $product->category->slug ?? 'all' }}">
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#111] mb-10 cursor-pointer" 
                         onclick="window.location.href='https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Inquiry for: ' . $product->name) }}'">
                        
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                 class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110 grayscale-[0.3] group-hover:grayscale-0">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl">✦</div>
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-500"></div>
                        
                        <!-- Sale Tag -->
                        @if($product->discount_price)
                            <div class="absolute top-6 left-6 glass px-4 py-2 text-[8px] font-black uppercase tracking-widest text-white">
                                Limited Offer
                            </div>
                        @endif

                        <!-- Action Button -->
                        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 glass px-8 py-4 text-[9px] font-black uppercase tracking-widest text-white opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 whitespace-nowrap">
                            Inquire via WhatsApp
                        </div>
                    </div>

                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-neutral-600 mb-2 block">{{ $product->category->name ?? 'Collection' }}</span>
                            <h3 class="text-xl font-serif italic text-white group-hover:text-neutral-400 transition-colors">{{ $product->name }}</h3>
                        </div>
                        <div class="text-right">
                            @if($product->discount_price)
                                <div class="text-white font-bold text-sm">Rs {{ number_format($product->discount_price) }}</div>
                                <div class="text-neutral-600 text-[10px] line-through">Rs {{ number_format($product->price) }}</div>
                            @else
                                <div class="text-white font-bold text-sm">Rs {{ number_format($product->price) }}</div>
                            @endif
                        </div>
                    </div>
                    <p class="mt-4 text-neutral-500 text-xs font-light leading-relaxed line-clamp-2">{{ $product->description }}</p>
                </div>
                @empty
                <div class="col-span-full py-40 text-center border border-white/5 glass">
                    <span class="text-4xl block mb-6">✦</span>
                    <h3 class="text-2xl font-serif italic text-white mb-2">Curating Archive</h3>
                    <p class="text-neutral-500 text-xs uppercase tracking-[0.2em]">New Arrivals Coming Soon</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Contact & Store Info -->
    <section id="contact" class="relative bg-[#080808]">
        <div class="h-[700px] w-full relative grayscale hover:grayscale-0 transition-all duration-1000">
             @if($business->google_maps_link)
             <iframe 
                width="100%" 
                height="100%" 
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                style="filter: invert(95%) hue-rotate(180deg) brightness(95%);"
                src="https://maps.google.com/maps?q={{ urlencode($business->address ?? $business->business_name) }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
            </iframe>
             @else
             <div class="w-full h-full flex items-center justify-center bg-[#111]">
                 <p class="text-neutral-700 font-serif italic">The Map is Loading...</p>
             </div>
             @endif
        </div>

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#080808]/95 backdrop-blur-md p-12 md:p-20 max-w-lg w-[90%] text-center border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)] fade-in">
            <h3 class="text-4xl font-serif italic text-white mb-10">Visit Us</h3>
            
            <div class="space-y-10">
                <div>
                    <p class="text-neutral-600 text-[9px] font-black uppercase tracking-[0.3em] mb-3">The Boutique</p>
                    <p class="text-white text-base font-light tracking-wide">{{ $business->address ?? 'Kathmandu, Nepal' }}</p>
                </div>

                <div>
                    <p class="text-neutral-600 text-[9px] font-black uppercase tracking-[0.3em] mb-3">Reservations</p>
                    @if($business->phone)
                    <p class="text-white text-base font-light tracking-wide mb-2">{{ $business->phone }}</p>
                    @endif
                    @if($business->whatsapp_number)
                     <p class="text-neutral-400 text-xs uppercase tracking-widest">WhatsApp Available</p>
                    @endif
                </div>

                <div>
                    <p class="text-neutral-600 text-[9px] font-black uppercase tracking-[0.3em] mb-3">Boutique Hours</p>
                    <p class="text-white text-base font-light tracking-wide">Mon - Sun: 10:00 AM - 10:00 PM</p>
                </div>
            </div>

            <div class="mt-12 flex justify-center gap-6">
                 @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all">📞</a>
                @endif
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all">💬</a>
                @endif
                @if($business->google_maps_link)
                 <a href="{{ $business->google_maps_link }}" target="_blank" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white hover:text-black transition-all">📍</a>
                @endif
            </div>

            @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
            <div class="mt-10 pt-10 border-t border-white/5 flex justify-center gap-8">
                @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                    <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="text-neutral-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="text-neutral-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                    </a>
                @endif
                @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="text-neutral-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-24 bg-[#050505] border-t border-white/5 text-center">
        <a href="#" class="text-4xl font-serif italic text-white mb-16 inline-block tracking-tighter">{{ $business->business_name }}</a>
        
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-12">
            <div class="flex gap-12 text-[9px] font-black uppercase tracking-[0.3em] text-neutral-500">
                <a href="#" class="hover:text-white transition-colors">Top</a>
                <a href="#about" class="hover:text-white transition-colors">House</a>
                <a href="#products" class="hover:text-white transition-colors">Collection</a>
                <a href="#contact" class="hover:text-white transition-colors">Contact</a>
            </div>
            
            <p class="text-neutral-700 text-[9px] font-black uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} {{ $business->business_name }}. All Rights Reserved.
            </p>
        </div>
    </footer>

    <script>
        // Hero Slider
        const slides = document.querySelectorAll('[data-slide]');
        let currentSlide = 0;
        
        if(slides.length > 1) {
            setInterval(() => {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }, 6000);
        }

        // Navbar Transformation
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 100) {
                nav.classList.add('glass', 'py-4', 'border-white/10');
                nav.querySelector('div').classList.remove('py-8');
                nav.querySelector('div').classList.add('py-4');
            } else {
                nav.classList.remove('glass', 'py-4', 'border-white/10');
                nav.querySelector('div').classList.remove('py-4');
                nav.querySelector('div').classList.add('py-8');
            }
        });

        // Collection Filter
        const tabs = document.querySelectorAll('.menu-tab');
        const items = document.querySelectorAll('.menu-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('active', 'text-white', 'border-b', 'border-white');
                    t.classList.add('text-neutral-500');
                });
                tab.classList.remove('text-neutral-500');
                tab.classList.add('active', 'text-white', 'border-b', 'border-white');

                const category = tab.dataset.category;
                items.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                        setTimeout(() => item.classList.add('fade-in'), 10);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
