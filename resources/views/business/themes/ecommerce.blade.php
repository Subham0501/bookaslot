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
<body class="bg-[#0c0a09] text-stone-200 font-sans antialiased selection:bg-stone-700 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-[2px] border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 text-2xl font-serif italic font-bold text-white tracking-tighter hover:text-neutral-300 transition-colors">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-10 w-auto rounded-full border border-white/20">
                @endif
                {{ $business->business_name }}
            </a>
            
            <div class="hidden md:flex items-center gap-10 text-xs font-bold uppercase tracking-[0.2em] text-neutral-400">
                <a href="#about" class="hover:text-white transition-colors">House</a>
                <a href="#products" class="hover:text-white transition-colors">Collection</a>
                <a href="#contact" class="hover:text-white transition-colors">Boutique</a>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white text-black px-6 py-3 rounded-full hover:bg-neutral-200 transition-transform hover:scale-105">Shop Now</a>
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
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#111] border-b border-neutral-800 p-6 flex flex-col gap-6 text-center shadow-2xl">
            <a href="#about" class="text-sm font-bold uppercase tracking-widest text-neutral-400 hover:text-white">House</a>
            <a href="#products" class="text-sm font-bold uppercase tracking-widest text-neutral-400 hover:text-white">Collection</a>
            <a href="#contact" class="text-sm font-bold uppercase tracking-widest text-neutral-400 hover:text-white">Boutique</a>
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

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto fade-in">
            <div class="flex items-center justify-center gap-4 mb-6 opacity-80">
                <div class="w-16 h-px bg-white/60"></div>
                <span class="text-neutral-400 text-[10px] md:text-xs font-black uppercase tracking-[0.4em]">Est. {{ $business->established_year ?? ($business->created_at ? $business->created_at->format('Y') : date('Y')) }}</span>
                <div class="w-16 h-px bg-white/60"></div>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif italic text-white mb-8 tracking-tighter leading-[0.9] drop-shadow-2xl">
                {{ $business->business_name }}
            </h1>
            
            <p class="text-neutral-300 text-sm md:text-base font-medium tracking-[0.2em] mb-12 uppercase max-w-2xl mx-auto leading-loose">
                {{ $business->category ?? 'Exquisite Collection & Curation' }}
            </p>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I would like to inquire about your collection.') }}" class="bg-white text-black px-10 py-4 rounded-full text-[11px] font-black uppercase tracking-widest hover:bg-neutral-200 transition-all hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Shop Collection
                </a>
                @endif
                <a href="#products" class="group flex items-center gap-3 text-white text-[11px] font-black uppercase tracking-widest hover:text-neutral-300 transition-colors">
                    Explore Catalog <span class="group-hover:translate-y-1 transition-transform text-lg">↓</span>
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-30">
            <div class="w-px h-20 bg-gradient-to-b from-white to-transparent"></div>
        </div>
    </header>

    <!-- Intro Section -->
    <section id="about" class="py-24 md:py-32 bg-[#080808] relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-center">
            <div class="relative">
                <div class="aspect-[4/5] rounded-none overflow-hidden relative border border-white/5">
                     @php
                        $introImage = $business->banners->skip(1)->first()?->image ?? $business->products->first()?->image;
                     @endphp
                     @if($introImage)
                        <img src="{{ Str::startsWith($introImage, 'http') ? $introImage : asset('storage/' . $introImage) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                     @else
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                     @endif
                     <div class="absolute inset-0 ring-1 ring-white/10 pointer-events-none"></div>
                </div>
                <!-- Since aesthetic -->
                <div class="absolute -bottom-10 -right-10 w-40 h-40 border border-white/20 rounded-full flex items-center justify-center text-neutral-500 animate-[spin_20s_linear_infinite]">
                    <svg viewBox="0 0 100 100" width="140" height="140">
                      <defs>
                        <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                      </defs>
                      <text font-size="11" fill="currentColor" letter-spacing="2">
                        <textPath xlink:href="#circle">
                          EXQUISITE • STYLE • CURATION •
                        </textPath>
                      </text>
                    </svg>
                </div>
            </div>
            
            <div class="md:text-left text-center">
                <span class="text-neutral-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">The House</span>
                <h2 class="text-4xl md:text-6xl font-serif italic text-white mb-8 leading-tight">
                    Crafted with <br><span class="text-neutral-600">Precision.</span>
                </h2>
                <div class="w-20 h-px bg-neutral-800 mb-8 md:mx-0 mx-auto"></div>
                <p class="text-neutral-400 text-sm md:text-base leading-relaxed font-light italic mb-10">
                    "{{ $business->description ?? 'We believe that luxury is in the details. Every piece in our collection is selected to provide a seamless blend of style and function.' }}"
                </p>
                <div class="flex flex-col md:flex-row gap-8 text-[10px] font-black uppercase tracking-widest text-neutral-500">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✦</span> Premium Quality
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✦</span> Handpicked
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Collection -->
    <section id="products" class="py-32 bg-[#0a0a0a] border-t border-white/5 relative">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16">
                <span class="text-neutral-600 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Archive Highlights</span>
                <h2 class="text-4xl md:text-5xl font-serif italic text-white">The Collection</h2>
            </div>
            
            <!-- Categories -->
             @if($business->categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <button class="menu-tab active px-8 py-3 bg-white text-black rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:bg-neutral-200" data-category="all">All Pieces</button>
                @foreach($business->categories as $category)
                <button class="menu-tab px-8 py-3 bg-transparent border border-neutral-800 text-neutral-400 rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:border-neutral-600 hover:text-white" data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
            @endif

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @forelse($business->products as $product)
                <div class="menu-item group cursor-pointer" data-category="{{ $product->category->slug ?? 'all' }}"
                     onclick="window.location.href='https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Inquiry for: ' . $product->name) }}'">
                    
                    <div class="relative aspect-[4/5] overflow-hidden mb-8 filter sepia-[.2] group-hover:sepia-0 transition-all duration-700 border border-white/5">
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                        @else
                            <div class="w-full h-full bg-neutral-900 flex items-center justify-center text-4xl text-neutral-800">✦</div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                        <div class="absolute top-6 right-6 bg-white text-black text-[9px] font-black px-4 py-2 rounded-none uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 duration-300">
                            View Details
                        </div>
                    </div>

                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-2xl font-serif italic text-neutral-200 group-hover:text-white transition-colors">{{ $product->name }}</h3>
                        @if($product->price)
                            <span class="text-white font-bold text-sm">Rs {{ number_format($product->price) }}</span>
                        @endif
                    </div>
                    <p class="text-neutral-500 text-xs leading-relaxed line-clamp-2 max-w-[90%] font-light">{{ $product->description }}</p>
                </div>
                 @empty
                <div class="col-span-full py-20 text-center text-neutral-600 text-[10px] font-black uppercase tracking-[0.4em]">
                    Updating Collection...
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

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#0c0a09]/95 backdrop-blur-md p-12 md:p-16 max-w-lg w-[90%] text-center border border-white/10 shadow-2xl fade-in">
            <h3 class="text-4xl font-serif italic text-white mb-10">Visit Us</h3>
            
            <div class="space-y-10">
                <div>
                    <p class="text-stone-500 text-[9px] font-black uppercase tracking-[0.3em] mb-3">The Boutique</p>
                    <p class="text-stone-300 text-base font-light tracking-wide">{{ $business->address ?? 'Kathmandu, Nepal' }}</p>
                </div>

                <div>
                    <p class="text-stone-500 text-[9px] font-black uppercase tracking-[0.3em] mb-3">Reservations</p>
                    @if($business->phone)
                    <p class="text-stone-300 text-base font-light tracking-wide mb-2">{{ $business->phone }}</p>
                    @endif
                    @if($business->whatsapp_number)
                     <p class="text-stone-400 text-xs uppercase tracking-widest">WhatsApp Available</p>
                    @endif
                </div>

                <div>
                    <p class="text-stone-500 text-[9px] font-black uppercase tracking-[0.3em] mb-3">Boutique Hours</p>
                    <p class="text-stone-300 text-base font-light tracking-wide">Mon - Sun: 10:00 AM - 10:00 PM</p>
                </div>
            </div>

            <div class="mt-12 flex justify-center gap-6">
                 @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-stone-300 hover:bg-white hover:text-black transition-all">📞</a>
                @endif
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-stone-300 hover:bg-white hover:text-black transition-all">💬</a>
                @endif
                @if($business->google_maps_link)
                 <a href="{{ $business->google_maps_link }}" target="_blank" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center text-stone-300 hover:bg-white hover:text-black transition-all">📍</a>
                @endif
            </div>

            @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
            <div class="mt-10 pt-10 border-t border-white/5 flex justify-center gap-8">
                @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                    <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="text-stone-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="text-stone-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                    </a>
                @endif
                @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="text-stone-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0c0a09] py-12 border-t border-white/5 text-center">
        <h2 class="text-3xl font-serif italic text-white mb-6">{{ $business->business_name }}</h2>
        <div class="flex justify-center gap-8 mb-8 text-[10px] font-bold uppercase tracking-widest text-stone-500">
            <a href="#" class="hover:text-white transition-colors">Home</a>
            <a href="#about" class="hover:text-white transition-colors">About</a>
            <a href="#products" class="hover:text-white transition-colors">Collection</a>
            <a href="#contact" class="hover:text-white transition-colors">Contact</a>
        </div>
        <p class="text-stone-700 text-[10px] uppercase tracking-wider">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>
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

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.replace('bg-transparent', 'bg-black/90');
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.replace('bg-black/90', 'bg-transparent');
                nav.classList.remove('shadow-lg');
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
