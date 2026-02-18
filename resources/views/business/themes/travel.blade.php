<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - Luxury Travel & Tours</title>
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
    @include('partials.analytics')
</head>
<body class="bg-[#020617] text-slate-200 font-sans antialiased selection:bg-slate-700 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-[2px] border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 text-2xl font-serif italic font-bold text-white tracking-tighter hover:text-slate-300 transition-colors">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-10 w-auto rounded-full border border-white/20">
                @endif
                {{ $business->business_name }}
            </a>
            
            <div class="hidden md:flex items-center gap-10 text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
                <a href="#about" class="hover:text-white transition-colors">The Journey</a>
                <a href="#destinations" class="hover:text-white transition-colors">Destinations</a>
                <a href="#contact" class="hover:text-white transition-colors">Contact</a>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white text-slate-900 px-6 py-3 rounded-full hover:bg-slate-200 transition-transform hover:scale-105">Plan Your Trip</a>
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
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#0f172a] border-b border-slate-800 p-6 flex flex-col gap-6 text-center shadow-2xl">
            <a href="#about" class="text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-white">The Journey</a>
            <a href="#destinations" class="text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-white">Destinations</a>
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
                <!-- Travel/Nature fallback -->
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop" class="w-full h-full object-cover opacity-60">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/40 to-black/30"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto fade-in">
            <div class="flex items-center justify-center gap-4 mb-6 opacity-80">
                <div class="w-16 h-px bg-white/60"></div>
                <span class="text-slate-200 text-[10px] md:text-xs font-black uppercase tracking-[0.4em]">Est. {{ $business->established_year ?? ($business->created_at ? $business->created_at->format('Y') : date('Y')) }}</span>
                <div class="w-16 h-px bg-white/60"></div>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif italic text-white mb-8 tracking-tighter leading-[0.9] drop-shadow-2xl">
                {{ $business->business_name }}
            </h1>
            
            <p class="text-slate-300 text-sm md:text-base font-medium tracking-[0.2em] mb-12 uppercase max-w-2xl mx-auto leading-loose">
                {{ $business->category ?? 'Luxury Travel & Tours' }}
            </p>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I would like to plan a trip.') }}" class="bg-white text-black px-10 py-4 rounded-full text-[11px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Start Your Adventure
                </a>
                @endif
                <a href="#destinations" class="group flex items-center gap-3 text-white text-[11px] font-black uppercase tracking-widest hover:text-slate-300 transition-colors">
                    View Destinations <span class="group-hover:translate-y-1 transition-transform text-lg">↓</span>
                </a>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-24 md:py-32 bg-[#020617] relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-center">
            <div class="relative">
                <div class="aspect-[4/5] rounded-none overflow-hidden relative">
                     <!-- Try to find a nice 'about' image -->
                     @php
                        $aboutImage = $business->banners->skip(1)->first()?->image ?? $business->products->first()?->image;
                     @endphp
                     @if($aboutImage)
                        <img src="{{ Str::startsWith($aboutImage, 'http') ? $aboutImage : asset('storage/' . $aboutImage) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                     @else
                        <!-- Travel specific fallback -->
                        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                     @endif
                     <div class="absolute inset-0 ring-1 ring-white/10 pointer-events-none"></div>
                </div>
                <!-- Since aesthetic -->
                <div class="absolute -bottom-10 -right-10 w-40 h-40 border border-white/20 rounded-full flex items-center justify-center text-teal-500 animate-[spin_20s_linear_infinite]">
                    <svg viewBox="0 0 100 100" width="140" height="140">
                      <defs>
                        <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                      </defs>
                      <text font-size="11" fill="currentColor" letter-spacing="2">
                        <textPath xlink:href="#circle">
                          EXPLORE • DISCOVER • LIVE • TRAVEL •
                        </textPath>
                      </text>
                    </svg>
                </div>
            </div>
            
            <div class="md:text-left text-center">
                <span class="text-teal-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">The Experience</span>
                <h2 class="text-4xl md:text-6xl font-serif italic text-white mb-8 leading-tight">
                    Beyond the <br><span class="text-slate-500">destination.</span>
                </h2>
                <div class="w-20 h-px bg-slate-800 mb-8 md:mx-0 mx-auto"></div>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed font-light mb-10">
                    {{ $business->description ?? 'We specialize in crafting unforgettable journeys. From the hidden gems of the mountains to the serene beaches of the coast, we guide you to the world\'s most breathtaking locations with a touch of luxury and comfort.' }}
                </p>
                <div class="flex flex-col md:flex-row gap-8 text-xs font-bold uppercase tracking-widest text-teal-500">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✦</span> Curated Tours
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✦</span> Exclusive Access
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages / Destinations Section -->
    <section id="destinations" class="py-24 bg-[#0f172a] relative border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Travel Packages</span>
                <h2 class="text-4xl md:text-5xl font-serif italic text-white">Our Signature Journeys</h2>
            </div>
            
            <!-- Categories -->
             @if($business->categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <button class="menu-tab active px-8 py-3 bg-white text-black rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:bg-slate-200" data-category="all">All</button>
                @foreach($business->categories as $category)
                <button class="menu-tab px-8 py-3 bg-transparent border border-slate-800 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:border-slate-600 hover:text-white" data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
            @endif

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 @forelse($business->products as $product)
                <div class="menu-item group cursor-pointer" data-category="{{ $product->category->slug ?? 'all' }}"
                     onclick="window.location.href='https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I am interested in this package: ' . $product->name) }}'">
                    
                    <div class="relative h-96 overflow-hidden mb-6 filter sepia-[.2] group-hover:sepia-0 transition-all duration-700">
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                        @else
                            <div class="w-full h-full bg-slate-900 flex items-center justify-center text-4xl text-slate-800">✈️</div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                        <div class="absolute top-4 right-4 bg-white text-black text-[10px] font-black px-3 py-1 rounded-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 duration-300">
                            Book Now
                        </div>
                    </div>

                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-2xl font-serif italic text-slate-200 group-hover:text-teal-500 transition-colors">{{ $product->name }}</h3>
                        @if($product->price)
                        <span class="text-teal-500 font-bold text-sm">Rs {{ number_format($product->price) }}</span>
                        @endif
                    </div>
                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2 max-w-[90%]">{{ $product->description }}</p>
                </div>
                 @empty
                <div class="col-span-full py-20 text-center text-slate-600 text-xs uppercase tracking-widest">
                    Updating our packages...
                </div>
                @endforelse
            </div>
            
            <div class="mt-20 text-center">
                <a href="#" class="inline-block border-b border-teal-500 text-teal-500 pb-1 text-xs font-bold uppercase tracking-widest hover:text-white hover:border-white transition-colors">Download Brochure (PDF)</a>
            </div>
        </div>
    </section>

    <!-- Reviews / Stats Section -->
    <section class="py-20 bg-[#020617] border-y border-slate-900">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] mb-8 block">Traveler Diaries</span>
            <div class="text-3xl md:text-5xl font-serif italic text-slate-300 leading-tight mb-8">
                "The trip of a lifetime. Every detail was planned to perfection, and the guides were incredibly knowledgeable."
            </div>
            <div class="flex justify-center gap-1 text-teal-500 mb-4">
                ★★★★★
            </div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Sarah Jenkins — TripAdvisor</p>
        </div>
    </section>

    <!-- Location & Contact -->
    <section id="contact" class="relative bg-[#0f172a]">
        <div class="h-[600px] w-full relative grayscale hover:grayscale-0 transition-all duration-1000">
             @if($business->google_maps_link)
             <iframe 
                width="100%" 
                height="100%" 
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                style="filter: invert(90%) hue-rotate(180deg) contrast(90%);"
                src="https://maps.google.com/maps?q={{ urlencode($business->address ?? $business->business_name) }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
            </iframe>
             @else
             <div class="w-full h-full flex items-center justify-center bg-slate-900">
                 <p class="text-slate-600">Map loading...</p>
             </div>
             @endif
        </div>

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#020617]/95 backdrop-blur-md p-12 md:p-16 max-w-lg w-[90%] text-center border border-white/10 shadow-2xl">
            <h3 class="text-3xl font-serif italic text-white mb-8">Visit Our Office</h3>
            
            <div class="space-y-8">
                <div>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Location</p>
                    <p class="text-slate-300 text-base">{{ $business->address ?? 'Kathmandu, Nepal' }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Inquiries</p>
                    @if($business->phone)
                    <p class="text-slate-300 text-base mb-1">{{ $business->phone }}</p>
                    @endif
                    @if($business->whatsapp_number)
                     <p class="text-slate-300 text-base">WhatsApp Available</p>
                    @endif
                </div>

                <div>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Office Hours</p>
                    <p class="text-slate-300 text-base">Sun - Fri: 9:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="mt-10 flex justify-center gap-4">
                 @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-slate-800 transition-colors">📞</a>
                @endif
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-slate-800 transition-colors">💬</a>
                @endif
                @if($business->google_maps_link)
                 <a href="{{ $business->google_maps_link }}" target="_blank" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-slate-800 transition-colors">📍</a>
                @endif
            </div>

            @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
            <div class="mt-8 flex justify-center gap-4">
                @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                    <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-black hover:text-white hover:border-black transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-pink-600 hover:text-white hover:border-pink-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                    </a>
                @endif
                @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="w-12 h-12 rounded-full border border-slate-600 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#020617] py-12 border-t border-white/5 text-center">
        <h2 class="text-3xl font-serif italic text-white mb-6">{{ $business->business_name }}</h2>
        <div class="flex justify-center gap-8 mb-8 text-[10px] font-bold uppercase tracking-widest text-slate-500">
            <a href="#" class="hover:text-white transition-colors">Home</a>
            <a href="#about" class="hover:text-white transition-colors">About</a>
            <a href="#destinations" class="hover:text-white transition-colors">Destinations</a>
            <a href="#contact" class="hover:text-white transition-colors">Contact</a>
        </div>
        <p class="text-slate-700 text-[10px] uppercase tracking-wider">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>
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
            }, 5000);
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

        // Menu Tabs
        const tabs = document.querySelectorAll('.menu-tab');
        const items = document.querySelectorAll('.menu-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('bg-white', 'text-black');
                    t.classList.add('bg-transparent', 'text-slate-400', 'border', 'border-slate-800');
                });
                tab.classList.remove('bg-transparent', 'text-slate-400', 'border', 'border-slate-800');
                tab.classList.add('bg-white', 'text-black');

                const category = tab.dataset.category;
                items.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
