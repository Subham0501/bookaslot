<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - Portfolio</title>
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
<body class="bg-[#18181b] text-zinc-200 font-sans antialiased selection:bg-violet-900 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-gradient-to-b from-black/80 to-transparent backdrop-blur-[2px] border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 text-2xl font-serif italic font-bold text-white tracking-tighter hover:text-violet-300 transition-colors">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-10 w-auto rounded-full border border-white/20">
                @endif
                {{ $business->business_name }}
            </a>
            
            <div class="hidden md:flex items-center gap-10 text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">
                <a href="#about" class="hover:text-white transition-colors">About</a>
                <a href="#portfolio" class="hover:text-white transition-colors">Work</a>
                <a href="#contact" class="hover:text-white transition-colors">Contact</a>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-white text-zinc-900 px-6 py-3 rounded-full hover:bg-zinc-200 transition-transform hover:scale-105">Hire Me</a>
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
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#27272a] border-b border-zinc-700 p-6 flex flex-col gap-6 text-center shadow-2xl">
            <a href="#about" class="text-sm font-bold uppercase tracking-widest text-zinc-400 hover:text-white">About</a>
            <a href="#portfolio" class="text-sm font-bold uppercase tracking-widest text-zinc-400 hover:text-white">Work</a>
            <a href="#contact" class="text-sm font-bold uppercase tracking-widest text-zinc-400 hover:text-white">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative h-screen min-h-[600px] overflow-hidden flex items-center justify-center">
        <!-- Background Slider (or specific personal image) -->
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
                <!-- Abstract/Creative fallback -->
                <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-50">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#18181b] via-[#18181b]/60 to-black/30"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto fade-in">
            <div class="flex items-center justify-center gap-4 mb-6 opacity-80">
                <div class="w-16 h-px bg-white/60"></div>
                <span class="text-zinc-200 text-[10px] md:text-xs font-black uppercase tracking-[0.4em]">{{ $business->category ?? 'Professional Portfolio' }}</span>
                <div class="w-16 h-px bg-white/60"></div>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif italic text-white mb-8 tracking-tighter leading-[0.9] drop-shadow-2xl">
                {{ $business->business_name }}
            </h1>
            
            <p class="text-zinc-300 text-sm md:text-base font-medium tracking-[0.2em] mb-12 uppercase max-w-2xl mx-auto leading-loose">
                Creative • Visionary • Professional
            </p>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I am interested in your services.') }}" class="bg-white text-black px-10 py-4 rounded-full text-[11px] font-black uppercase tracking-widest hover:bg-zinc-200 transition-all hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Let's Collaborate
                </a>
                @endif
                <a href="#portfolio" class="group flex items-center gap-3 text-white text-[11px] font-black uppercase tracking-widest hover:text-violet-300 transition-colors">
                    View My Work <span class="group-hover:translate-y-1 transition-transform text-lg">↓</span>
                </a>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-24 md:py-32 bg-[#18181b] relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-violet-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-center">
            <div class="relative">
                <div class="aspect-[3/4] rounded-none overflow-hidden relative grayscale hover:grayscale-0 transition-all duration-1000">
                     <!-- Profile Image -->
                     @if($business->logo)
                        <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" class="w-full h-full object-cover">
                     @else
                        <!-- Profile fallback -->
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1887&auto=format&fit=crop" class="w-full h-full object-cover">
                     @endif
                     <div class="absolute inset-0 ring-1 ring-white/10 pointer-events-none"></div>
                </div>
                <!-- Since aesthetic -->
                <div class="absolute -bottom-10 -right-10 w-40 h-40 border border-white/20 rounded-full flex items-center justify-center text-violet-400 animate-[spin_20s_linear_infinite]">
                    <svg viewBox="0 0 100 100" width="140" height="140">
                      <defs>
                        <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                      </defs>
                      <text font-size="11" fill="currentColor" letter-spacing="2">
                        <textPath xlink:href="#circle">
                          CREATIVE • PASSION • SKILL •
                        </textPath>
                      </text>
                    </svg>
                </div>
            </div>
            
            <div class="md:text-left text-center">
                <span class="text-violet-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">About Me</span>
                <h2 class="text-4xl md:text-6xl font-serif italic text-white mb-8 leading-tight">
                    Driven by passion, <br><span class="text-zinc-500">defined by quality.</span>
                </h2>
                <div class="w-20 h-px bg-zinc-800 mb-8 md:mx-0 mx-auto"></div>
                <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light mb-10">
                    {{ $business->description ?? 'I am a dedicated professional with a passion for excellence. My work is a reflection of my commitment to delivering high-quality results and creating meaningful experiences.' }}
                </p>
                
                <div class="flex flex-col gap-4 text-xs font-bold uppercase tracking-widest text-violet-400">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✦</span> Specialized Expertise
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✦</span> Innovative Solutions
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✦</span> Client-Centric Approach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio / Services Section -->
    <section id="portfolio" class="py-24 bg-[#27272a] relative border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Selected Works</span>
                <h2 class="text-4xl md:text-5xl font-serif italic text-white">Portfolio Highlights</h2>
            </div>
            
             <!-- Categories -->
             @if($business->categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <button class="menu-tab active px-8 py-3 bg-white text-black rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:bg-zinc-200" data-category="all">All</button>
                @foreach($business->categories as $category)
                <button class="menu-tab px-8 py-3 bg-transparent border border-zinc-700 text-zinc-400 rounded-full text-[10px] font-black uppercase tracking-widest transition-all hover:border-zinc-500 hover:text-white" data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
            @endif

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 @forelse($business->products as $product)
                <div class="menu-item group cursor-pointer" data-category="{{ $product->category->slug ?? 'all' }}"
                     onclick="window.location.href='https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Target: ' . $product->name) }}'">
                    
                    <div class="relative h-80 overflow-hidden mb-6 filter grayscale hover:grayscale-0 transition-all duration-700 bg-zinc-900 border border-white/5">
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl text-zinc-700">💼</div>
                        @endif
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-transparent transition-colors"></div>
                        
                        <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black to-transparent">
                             <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                 <h3 class="text-xl font-serif italic text-white mb-1">{{ $product->name }}</h3>
                                 <p class="text-zinc-400 text-[10px] uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity delay-100 duration-500">View Details</p>
                             </div>
                        </div>
                    </div>
                </div>
                 @empty
                <div class="col-span-full py-20 text-center text-zinc-600 text-xs uppercase tracking-widest">
                    Updating portfolio...
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Location & Contact -->
    <section id="contact" class="py-24 bg-[#18181b] border-t border-zinc-800">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Get In Touch</span>
            <h2 class="text-4xl md:text-5xl font-serif italic text-white mb-12">Let's create something specific.</h2>
            
            <div class="flex justify-center gap-6">
                 @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-white hover:text-black hover:scale-110 transition-all duration-300">
                    <span class="text-2xl">📞</span>
                </a>
                @endif
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-[#25D366] hover:text-white hover:border-[#25D366] hover:scale-110 transition-all duration-300">
                     <span class="text-2xl">💬</span>
                </a>
                @endif
                @if($business->google_maps_link)
                 <a href="{{ $business->google_maps_link }}" target="_blank" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-white hover:text-black hover:scale-110 transition-all duration-300">
                     <span class="text-2xl">📍</span>
                 </a>
                @endif
            </div>

            @if(isset($business->social_links) && (isset($business->social_links['tiktok']) || isset($business->social_links['instagram']) || isset($business->social_links['facebook'])))
            <div class="flex justify-center gap-6 mt-6">
                @if(isset($business->social_links['tiktok']) && $business->social_links['tiktok'])
                    <a href="{{ $business->social_links['tiktok'] }}" target="_blank" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-black hover:text-white hover:border-black hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                    </a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-pink-600 hover:text-white hover:border-pink-600 hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M7.5 3h9a4.5 4.5 0 014.5 4.5v9a4.5 4.5 0 01-4.5 4.5h-9A4.5 4.5 0 013 16.5v-9A4.5 4.5 0 017.5 3z"></path></svg>
                    </a>
                @endif
                 @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center text-zinc-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
            @endif
            
            <div class="mt-12 text-zinc-500 text-sm">
                <p>{{ $business->address ?? 'Kathmandu, Nepal' }}</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#18181b] py-8 border-t border-white/5 text-center">
        <p class="text-zinc-700 text-[10px] uppercase tracking-wider">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>
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
                    t.classList.add('bg-transparent', 'text-zinc-400', 'border', 'border-zinc-800');
                });
                tab.classList.remove('bg-transparent', 'text-zinc-400', 'border', 'border-zinc-800');
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
