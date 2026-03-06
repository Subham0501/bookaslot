<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookingArc</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/stabndard.png') }}">
    
    <!-- Fonts - Outfit for the premium, clean geometric feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3D5AFE', // Electric Blue
                        navy: '#010514',    // Midnight Boutique Navy
                        surface: '#F1F4FF', // Blueish/Greyish Shadow Section
                        muted: '#707393',   // Editorial Slate
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
                        '6xl': '3rem',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.01em;
        }
        .heading-bold {
            font-weight: 900;
            letter-spacing: -0.02em;
        }
        /* Search Section - BLUEISH/GREYISH BG REQUESTED */
        .search-hero-section {
            background-color: #F1F4FF; /* Blueish/Greyish Background */
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            border-bottom: 1px solid rgba(61, 90, 254, 0.05);
        }
        @media (min-width: 768px) {
            .search-hero-section {
                padding: 85px 0;
            }
        }
        /* The Search Bar is a White Floating Pill in this colored section */
        .search-bar-pill {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 1100px;
            border-radius: 40px;
            display: flex;
            flex-direction: column;
            padding: 15px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        @media (min-width: 1024px) {
            .search-bar-pill {
                height: 88px;
                border-radius: 9999px;
                flex-direction: row;
                padding: 10px;
            }
        }
        .v-divider {
            display: none;
            width: 1px;
            height: 35px;
            background-color: rgba(1, 5, 20, 0.08);
        }
        @media (min-width: 1024px) {
            .v-divider {
                display: block;
            }
        }
        .search-col {
            flex: 1;
            padding: 15px 25px;
            cursor: pointer;
            border-bottom: 1px solid rgba(1, 5, 20, 0.05);
        }
        .search-col:last-of-type {
            border-bottom: none;
        }
        @media (min-width: 1024px) {
            .search-col {
                padding: 0 50px;
                border-bottom: none;
            }
        }
        .search-col:hover .s-label { color: #3D5AFE; }
        .s-label {
            font-size: 10px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #010514;
            margin-bottom: 2px;
        }
        .s-val {
            font-size: 14px;
            font-weight: 600;
            color: #707393;
            opacity: 0.9;
        }
        .search-action-circle {
            width: 100%;
            height: 60px;
            background-color: #3D5AFE;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 10px 25px -5px rgba(61, 90, 254, 0.35);
            transition: all 0.4s;
            margin-top: 10px;
        }
        @media (min-width: 1024px) {
            .search-action-circle {
                width: 65px;
                height: 65px;
                border-radius: 9999px;
                margin-top: 0;
            }
        }
        .search-action-circle:hover {
            background-color: #010514;
            transform: scale(1.05);
        }
        .nav-button-navy {
            background-color: #010514;
            color: white;
            padding: 8px 8px 8px 25px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px -10px rgba(1, 5, 20, 0.35);
            transition: all 0.3s;
        }
        @media (min-width: 768px) {
            .nav-button-navy {
                padding: 10px 10px 10px 40px;
                font-size: 12.5px;
                gap: 15px;
            }
        }
        .nav-button-navy:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -10px rgba(1, 4, 15, 0.5);
        }
        .card-tag {
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 15px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 900;
            color: white;
        }
        .card-tag-dark {
            background: rgba(1, 5, 20, 0.04);
            border: 1px solid rgba(1, 5, 20, 0.08);
            color: #010514;
            border-radius: 10px;
        }
        .arrow-up {
            width: 38px;
            height: 38px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            font-weight: 900;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="antialiased">
    
    <!-- Top Bar -->
  

    <!-- Navigation -->
    <nav class="w-full bg-white border-b border-gray-100 py-4 md:py-6 px-6 md:px-24 sticky top-0 z-[1000]">
        <div class="max-w-[1800px] mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 md:gap-3">
                <img src="{{ asset('assets/stabndard.png') }}" alt="Logo" class="h-10 md:h-12 w-auto object-contain">
            </a>
            
            <div class="hidden lg:flex items-center space-x-8 px-6">
                <a href="{{ route('marketplace.index', ['category' => 'Travel']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors">Travel & Tour</a>
                <a href="{{ route('marketplace.index', ['category' => 'Ecommerce']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors">E-commerce</a>
                <a href="{{ route('marketplace.index', ['category' => 'Consultancy']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors">Consultancy</a>
                <a href="{{ route('marketplace.index', ['category' => 'Hotel']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors">Hotels & Restaurants</a>
                <a href="{{ route('marketplace.index', ['category' => 'Photography']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors">Events & Photo</a>
            </div>

            <a href="{{ url('/create') }}" class="nav-button-navy group whitespace-nowrap">
                <span class="hidden sm:inline">Get Started</span>
                <span class="sm:hidden">Get Card</span>
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white text-primary flex items-center justify-center shadow-xl">
                    <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="4"></path></svg>
                </div>
            </a>
        </div>
    </nav>

    <!-- Hero Branding Section -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 pt-16 md:pt-20 pb-8 md:pb-10 text-center">
        <h1 class="text-[10px] md:text-[12px] font-black text-primary uppercase tracking-[0.3em] md:tracking-[0.5em] mb-4 md:mb-6">For Professionals & Brands</h1>
        <h2 class="text-4xl md:text-[72px] font-black text-navy leading-tight md:leading-[1.1] tracking-tight mb-8 md:mb-12 uppercase">Connect. Sell. Grow.<br class="hidden md:block"><span class="text-primary">The Premium Marketplace.</span></h2>
        <p class="max-w-3xl mx-auto text-muted text-base md:text-lg font-medium leading-relaxed mb-12 md:mb-16 tracking-tight">Transform your physical presence into a powerful digital hub. Share your products, location, and contact details instantly with a single scan. Explore our premium marketplace to connect with top-tier brands and services.</p>
    </section>

    <!-- Search Section Title -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 text-center mt-20 md:mt-32">
        <h2 class="text-4xl md:text-[64px] font-black text-navy uppercase tracking-tighter leading-none mb-6">What are you <span class="text-primary">looking for?</span></h2>
        <p class="text-base md:text-xl text-muted font-medium max-w-3xl mx-auto tracking-tight leading-relaxed">Discover top-tier digital IDs, travel packages, and premium services created by our community.</p>
    </section>

    <!-- Search Section (Subtle Background Pill) -->
    <div class="mt-12 md:mt-16 py-12 md:py-20 bg-[#F1F4FF]/40 border-y border-primary/5 flex justify-center">
        <form action="{{ route('marketplace.index') }}" method="GET" class="search-bar-pill !my-0">
            <div class="search-col">
                <div class="s-label">Marketplace</div>
                <select name="category" class="s-val bg-transparent outline-none appearance-none cursor-pointer w-full">
                    <option value="">All Industries</option>
                    <option value="Travel">Travel & Tour</option>
                    <option value="Ecommerce">E-commerce</option>
                    <option value="Consultancy">Consultancy</option>
                    <option value="Hotel">Hotels & Restaurants</option>
                    <option value="Photography">Events & Photo</option>
                    <option value="Corporate">Personal & Corporate</option>
                </select>
            </div>
            <div class="v-divider"></div>
            <div class="search-col">
                <div class="s-label">Search</div>
                <input type="text" name="search" placeholder="Business or Product..." class="s-val bg-transparent outline-none w-full">
            </div>
            <div class="v-divider"></div>
            <div class="search-col">
                <div class="s-label">Price Order</div>
                <select name="sort" class="s-val bg-transparent outline-none appearance-none cursor-pointer w-full">
                    <option value="latest">Latest First</option>
                    <option value="price_low">Low to High</option>
                    <option value="price_high">High to Low</option>
                </select>
            </div>
            <div class="v-divider"></div>
            <div class="search-col order-4 lg:order-4 flex items-center justify-between !border-none">
                <div class="hidden lg:block">
                    <div class="s-label">Action</div>
                    <div class="s-val">Find </div>
                </div>
                <button type="submit" class="search-action-circle">
                    <span class="lg:hidden font-black uppercase text-[12px] tracking-widest mr-3">Find</span>
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="4"></path></svg>
                </button>
            </div>
        </form>
    </div>

    @if(isset($featuredBusinesses) && $featuredBusinesses->count() > 0)
    <!-- Featured Showcase Section (Grid) -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 mt-12 md:mt-16 mb-16 md:mb-20">
        <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-6">
            <h2 class="text-xl md:text-2xl font-black text-navy uppercase tracking-tighter">Featured <span class="text-primary">Spotlight</span></h2>
            <a href="{{ route('marketplace.index') }}" class="group flex items-center gap-2 text-[11px] font-black text-navy uppercase tracking-widest hover:text-primary transition-all">
                Explore Marketplace
                <div class="w-7 h-7 rounded-full border border-navy/10 flex items-center justify-center group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">↗</div>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 justify-center">
            @foreach($featuredBusinesses as $business)
            <div class="w-full bg-white rounded-[35px] md:rounded-[40px] overflow-hidden border border-gray-100 shadow-premium group cursor-pointer transition-all hover:-translate-y-2 hover:shadow-xl mx-auto" onclick="window.location.href='{{ $business->profile_url }}'">
                @php
                    $hero_image = $business->hero_image ? (Str::startsWith($business->hero_image, 'http') ? $business->hero_image : asset('storage/' . $business->hero_image)) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&q=80';
                @endphp
                
                <div class="relative aspect-[16/9] overflow-hidden">
                    <img src="{{ $hero_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-1.5 rounded-lg text-[9px] font-black text-navy uppercase tracking-widest shadow-md">{{ $business->category ?? 'Premium' }}</span>
                </div>

                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-6">
                        @if($business->logo)
                            @php
                                $logo_path = Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo);
                            @endphp
                            <img src="{{ $logo_path }}" class="w-10 h-10 rounded-full object-cover border border-gray-100 shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-base">
                                {{ substr($business->business_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-black text-navy leading-none tracking-tighter uppercase mb-1">{{ $business->business_name }}</h3>
                            <p class="text-[9px] font-bold text-primary uppercase tracking-widest opacity-60">{{ $business->category ?? 'Professional' }}</p>
                        </div>
                    </div>

                    <p class="text-[12px] text-muted font-medium mb-8 line-clamp-2 leading-relaxed tracking-tight min-h-[3em]">
                        {{ $business->description ?? 'Premium quality services and products.' }}
                    </p>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-50 mt-auto">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] font-black text-navy uppercase">Live Now</span>
                        </div>
                        <button class="bg-navy text-white px-5 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all">Visit Slot ↗</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <section class="max-w-[1550px] mx-auto px-6 md:px-10 mb-20 md:mb-28 mt-12 md:mt-24">
        <div class="grid grid-cols-12 gap-6 md:gap-8">
            
            <!-- LHS Segment -->
            <div class="col-span-12 md:col-span-4 flex flex-col gap-6 md:gap-8">
                <div class="h-[400px] md:h-[460px] bg-slate-900 rounded-[40px] md:rounded-[60px] relative overflow-hidden group p-10 md:p-14 cursor-pointer shadow-premium">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80" 
                         class="absolute inset-0 w-full h-full object-cover opacity-65 transition-transform duration-[1200ms] group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-85"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div class="flex gap-3">
                            <span class="card-tag">Interactive</span>
                            <span class="card-tag">QR-Powered</span>
                        </div>
                        <div>
                            <h2 class="text-3xl md:text-[38px] font-black text-white leading-[1.1] mb-6 md:mb-10 tracking-tighter uppercase">The visiting card<br>of the future.</h2>
                            <button onclick="window.location.href='/create'" class="bg-white text-navy px-8 md:px-12 py-3.5 md:py-4.5 rounded-full text-[12px] md:text-[14px] font-black hover:bg-primary hover:text-white transition-all shadow-2xl uppercase tracking-widest">Get QR Card</button>
                        </div>
                    </div>
                    <div class="absolute top-10 md:top-12 right-10 md:right-12 arrow-up">↗</div>
                </div>
                <div onclick="window.location.href='{{ route('marketplace.index', ['category' => 'Ecommerce']) }}'" class="h-[180px] md:h-[220px] bg-gray-50 rounded-[40px] md:rounded-[60px] relative overflow-hidden group p-10 md:p-12 cursor-pointer border border-gray-100 shadow-premium">
                    <img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=600&q=80" 
                         class="absolute inset-0 w-full h-full object-cover opacity-90 transition-transform duration-700 group-hover:scale-110">
                    <span class="card-tag card-tag-dark relative z-10 w-fit">Ecommerce</span>
                    <div class="absolute bottom-10 left-10 md:left-12">
                        <p class="text-[18px] md:text-[20px] font-black text-navy leading-none tracking-tighter uppercase">Global Shop Slot</p>
                    </div>
                    <div class="absolute top-8 md:top-10 right-10 md:right-14 w-8 h-8 md:w-10 md:h-10 rounded-full bg-white flex items-center justify-center text-navy font-black shadow-lg">↗</div>
                </div>
            </div>

            <!-- MID Segment -->
            <div class="col-span-12 md:col-span-4 flex flex-col gap-6 md:gap-8">
                <div onclick="window.location.href='{{ route('marketplace.index', ['category' => 'Photography']) }}'" class="h-[210px] bg-sky-50 rounded-[40px] md:rounded-[60px] relative overflow-hidden group p-10 md:p-12 cursor-pointer shadow-premium">
                    <img src="https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1500ms] group-hover:scale-105">
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-navy/10 transition-colors"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                         <span class="card-tag w-fit">Media</span>
                         <p class="text-2xl md:text-[32px] font-black text-white uppercase tracking-wider leading-none">Creative Studios</p>
                    </div>
                    <div class="absolute top-8 md:top-10 right-10 md:right-14 arrow-up">↗</div>
                </div>
                <!-- Vibe Card White -->
                <div onclick="window.location.href='{{ route('marketplace.index') }}'" class="h-[240px] bg-white border border-gray-100 rounded-[40px] md:rounded-[60px] p-8 md:p-12 flex flex-col items-center justify-center text-center shadow-premium relative group cursor-pointer">
                    <div class="flex -space-x-4 mb-6 md:mb-8">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full border-4 border-white shadow-xl relative overflow-hidden">
                             <img src="https://i.pravatar.cc/150?u=v1" class="w-full h-full">
                        </div>
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full border-4 border-white shadow-xl relative z-10 overflow-hidden">
                             <img src="https://i.pravatar.cc/150?u=v2" class="w-full h-full">
                        </div>
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full border-4 border-white shadow-xl relative overflow-hidden">
                             <img src="https://i.pravatar.cc/150?u=v3" class="w-full h-full">
                        </div>
                    </div>
                    <h3 class="text-2xl md:text-[30px] font-black text-navy leading-none mb-4 tracking-tighter">Explore Marketplace</h3>
                    <p class="text-[11px] md:text-[12px] text-muted font-bold block max-w-[260px] leading-snug tracking-tighter">// Discover Premium Business Cards & Professional Slots.</p>
                </div>
                <!-- Join Card Blue -->
                <div class="h-[230px] bg-[#3D5AFE] rounded-[40px] md:rounded-[60px] relative overflow-hidden group p-10 md:p-12 flex flex-col justify-end cursor-pointer shadow-accent">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-20 transform translate-x-12 -translate-y-12">
                         <svg viewBox="0 0 24 24" fill="white"><path d="M3 3h8v8H3zm2 2v4h4V5zm8-2h8v8h-8zm2 2v4h4V5zM3 13h8v8H3zm2 2v4h4v-4zm13-2h3v2h-3zm-3 0h2v2h-2zm3 3h3v2h-3zm-3 0h2v2h-2zm3 3h3v2h-3zm-3 0h2v2h-2zm-3-3h2v2h-2zm0-3h2v2h-2z"/></svg>
                    </div>
                    <div class="relative z-10 w-full sm:w-4/5">
                        <h4 class="text-xl md:text-[22px] font-black text-white leading-tight mb-6 md:mb-8 tracking-tighter uppercase">Premium Print <br> Cards Available</h4>
                        <button class="bg-white text-navy px-8 md:px-11 py-3 md:py-3.5 rounded-full text-[12px] md:text-[14px] font-black hover:bg-navy hover:text-white transition-all shadow-xl uppercase tracking-widest">Order Now</button>
                    </div>
                    <div class="absolute top-8 md:top-10 right-10 md:right-14 arrow-up">↗</div>
                </div>
            </div>

            <!-- RHS SEGMENT (Tall) -->
            <div onclick="window.location.href='{{ route('marketplace.index', ['category' => 'Consultancy']) }}'" class="col-span-12 md:col-span-4 h-[500px] md:min-h-[730px] bg-white rounded-[40px] md:rounded-[70px] relative overflow-hidden group p-10 md:p-16 flex flex-col justify-end shadow-premium border border-gray-100 cursor-pointer">
                <img src="https://images.unsplash.com/photo-1491336477066-31156b5e4f35?w=800&q=80" 
                     class="absolute inset-0 w-full h-full object-cover grayscale opacity-90 group-hover:grayscale-0 transition-transform duration-[1500ms] group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-90"></div>
                <div class="relative z-10 w-full">
                     <span class="card-tag inline-block mb-8 md:mb-12">Advisory</span>
                     <h3 class="text-4xl md:text-[48px] font-black text-white leading-none mb-4 md:mb-6 tracking-tighter uppercase">Consultancy</h3>
                     <p class="text-base md:text-[19px] text-white/80 font-medium leading-relaxed mb-10 md:mb-16 tracking-tighter max-w-[280px]">
                        // Professional Advice. Digital Slots for Consultancies & Advisors.
                     </p>
                     <button class="w-full py-5 md:py-6 bg-[#3D5AFE] text-white rounded-full text-[14px] md:text-[16px] font-black uppercase tracking-widest shadow-accent hover:bg-white hover:text-navy transition-all">Discover more</button>
                </div>
                <div class="absolute top-10 md:top-14 right-10 md:right-16 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white flex items-center justify-center text-navy font-black text-lg md:text-xl shadow-2xl">↗</div>
            </div>
        </div>
    </section>
    <!-- Core Features Section -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 my-24 md:my-40">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-20">
            <div class="flex flex-col gap-6 md:gap-10">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-surface rounded-[25px] md:rounded-[30px] flex items-center justify-center text-3xl md:text-4xl shadow-soft">🛍️</div>
                <h3 class="text-2xl md:text-3xl font-black text-navy tracking-tighter uppercase leading-none">Website & Products</h3>
                <p class="text-muted font-medium text-[14px] md:text-[15px] leading-relaxed">Showcase your products or services in a beautiful digital catalog. A premium landing page for your brand in seconds.</p>
            </div>
            <div class="flex flex-col gap-6 md:gap-10">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-surface rounded-[25px] md:rounded-[30px] flex items-center justify-center text-3xl md:text-4xl shadow-soft">💬</div>
                <h3 class="text-2xl md:text-3xl font-black text-navy tracking-tighter uppercase leading-none">WhatsApp & Maps Integration</h3>
                <p class="text-muted font-medium text-[14px] md:text-[15px] leading-relaxed">Direct WhatsApp ordering and one-tap Google Maps navigation. Connect your customers directly to your shop location.</p>
            </div>
            <div class="flex flex-col gap-6 md:gap-10">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-surface rounded-[25px] md:rounded-[30px] flex items-center justify-center text-3xl md:text-4xl shadow-soft">⚙️</div>
                <h3 class="text-2xl md:text-3xl font-black text-navy tracking-tighter uppercase leading-none">Powerful Admin Panel</h3>
                <p class="text-muted font-medium text-[14px] md:text-[15px] leading-relaxed">Update your banner, details, and products anytime from your dashboard. Complete control over your digital identity.</p>
            </div>
        </div>
    </section>

    <!-- Pricing Comparison Section -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 my-24 md:my-40">
        <div class="bg-navy rounded-[40px] md:rounded-[80px] p-10 md:p-24 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-10 md:p-20 opacity-10">
                 <svg class="w-48 h-48 md:w-96 md:h-96 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3zm2 2v4h4V5zm8-2h8v8h-8zm2 2v4h4V5zM3 13h8v8H3zm2 2v4h4v-4zm13-2h3v2h-3zm-3 0h2v2h-2zm3 3h3v2h-3zm-3 0h2v2h-2zm3 3h3v2h-3zm-3 0h2v2h-2zm-3-3h2v2h-2zm0-3h2v2h-2z"/></svg>
            </div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-20 items-center">
                <div>
                    <h2 class="text-4xl md:text-[58px] font-black text-white leading-[1.1] md:leading-[1] mb-8 md:mb-12 tracking-[-0.05em] uppercase">The Evolution <br class="hidden md:block">of your card.</h2>
                    <p class="text-white/60 text-base md:text-lg font-medium mb-10 md:mb-16 max-w-lg">Choose between traditional physical printing or the future-proof Digital Business Pro subscription.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <!-- Standard Card -->
                    <div class="bg-white/5 border border-white/10 p-8 md:p-12 rounded-[30px] md:rounded-[50px] backdrop-blur-xl group hover:bg-white/10 transition-all">
                        <span class="text-white/40 font-black uppercase tracking-widest text-[10px] mb-6 md:mb-8 block">Offline Option</span>
                        <h4 class="text-xl md:text-2xl font-black text-white mb-2 uppercase">Normal Business Card</h4>
                        <p class="text-white/40 text-[12px] md:text-[13px] mb-8 md:mb-10 font-medium">Standard High-Quality Print</p>
                        <div class="text-3xl md:text-4xl font-black text-white mb-8 md:mb-10">Rs 3 <span class="text-base md:text-lg text-white/30 font-bold uppercase">/ piece</span></div>
                        <ul class="space-y-3 md:space-y-4 mb-8 md:mb-10 text-[12px] md:text-[13px] text-white/60 font-medium">
                            <li class="flex items-center gap-3">○ Premium Glossy Finish</li>
                            <li class="flex items-center gap-3">○ QR code integration</li>
                            <li class="flex items-center gap-3">○ Standard Contact Info</li>
                        </ul>
                    </div>
                    
                    <!-- Pro Card -->
                    <div class="bg-primary p-8 md:p-12 rounded-[30px] md:rounded-[50px] shadow-2xl shadow-primary/40 transform hover:-translate-y-4 transition-all relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 md:p-6">
                            <span class="bg-white/20 px-3 md:px-4 py-1.5 md:py-2 rounded-full text-[9px] md:text-[10px] font-black text-white uppercase tracking-widest">Most Popular</span>
                        </div>
                        <span class="text-white/60 font-black uppercase tracking-widest text-[10px] mb-6 md:mb-8 block">Digital Slot</span>
                        <h4 class="text-xl md:text-2xl font-black text-white mb-2 uppercase">Business Pro</h4>
                        <p class="text-white/60 text-[12px] md:text-[13px] mb-8 md:mb-10 font-medium font-bold">Yearly Subscription</p>
                        <div class="text-3xl md:text-4xl font-black text-white mb-8 md:mb-10">Rs 2000 <span class="text-base md:text-lg text-white/60 font-bold uppercase">/ year</span></div>
                        <ul class="space-y-3 md:space-y-4 mb-8 md:mb-10 text-[12px] md:text-[13px] text-white font-bold">
                            <li class="flex items-center gap-3">✓ Mini Website / Unlimited Updates</li>
                            <li class="flex items-center gap-3">✓ Full Admin Dashboard Access</li>
                            <li class="flex items-center gap-3">✓ Priority Support & Analytics</li>
                            <li class="flex items-center gap-3">✓ Live WhatsApp Ordering</li>
                        </ul>
                        <button onclick="window.location.href='/create'" class="w-full py-4 md:py-5 bg-navy text-white rounded-full font-black uppercase text-[11px] md:text-[12px] tracking-widest shadow-2xl">Upgrade Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Browse Categories Section -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 mb-20 md:mb-32">
        <div class="flex flex-col md:flex-row items-center justify-between mb-12 md:mb-24 px-4 md:px-12 gap-8 text-center md:text-left">
            <h2 class="text-4xl md:text-[44px] font-black text-navy tracking-tight uppercase leading-none">Categories</h2>
            <button onclick="window.location.href='{{ route('marketplace.index') }}'" class="w-full md:w-auto bg-[#010514] text-white px-10 md:px-14 py-4 md:py-5 rounded-full md:rounded-[2rem] text-[13px] md:text-[14px] font-black uppercase tracking-widest hover:bg-[#3D5AFE] transition-all shadow-xl">Explore All</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-16">
            @php
            $displayCategories = [
                ['name' => 'Travel & Tour', 'slug' => 'Travel', 't1' => 'Vacation', 't2' => 'Adventure', 'img' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=80', 'design_url' => 'https://hamroyaad.com/mountainview'],
                ['name' => 'E-commerce', 'slug' => 'Ecommerce', 't1' => 'Shop', 't2' => 'Digital', 'img' => 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=600&q=80', 'design_url' => 'https://hamroyaad.com/futurefurinturenepal'],
                ['name' => 'Consultancy', 'slug' => 'Consultancy', 't1' => 'Business', 't2' => 'Advisor', 'img' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&q=80', 'design_url' => 'https://hamroyaad.com/sajilogerman'],
                ['name' => 'Hotels & Restaurants', 'slug' => 'Hotel', 't1' => 'Stay', 't2' => 'Dining', 'img' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=600&q=80', 'design_url' => 'https://hamroyaad.com/thakalipalace'],
                ['name' => 'Events & Photo', 'slug' => 'Photography', 't1' => 'Moments', 't2' => 'Media', 'img' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=600&q=80', 'design_url' => 'https://hamroyaad.com/clicknepal'],
                ['name' => 'Personal & Corporate', 'slug' => 'Corporate', 't1' => 'Brand', 't2' => 'Identity', 'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80', 'design_url' => 'https://hamroyaad.com/subham'],
            ];
            @endphp
            
            @foreach($displayCategories as $cat)
            <div class="group cursor-pointer">
                <div class="aspect-[1.5] bg-gray-200 rounded-[35px] md:rounded-[60px] overflow-hidden relative shadow-premium mb-8 md:mb-12">
                    <img src="{{ $cat['img'] }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute top-6 md:top-8 left-8 md:left-10 flex gap-2 md:gap-3">
                        <span class="card-tag card-tag-dark px-4 md:px-6 py-2 md:py-2.5 backdrop-blur-md bg-white/60 border-white/20 text-[10px] md:text-[11px] uppercase font-black uppercase">{{ $cat['t1'] }}</span>
                        <span class="card-tag card-tag-dark px-4 md:px-6 py-2 md:py-2.5 backdrop-blur-md bg-white/60 border-white/20 text-[10px] md:text-[11px] uppercase font-black uppercase">{{ $cat['t2'] }}</span>
                    </div>
                    <!-- View Design Overlay -->
                    <div class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                        <button onclick="window.location.href='{{ $cat['design_url'] }}'" class="bg-white text-navy px-6 md:px-8 py-2.5 md:py-3 rounded-full text-[11px] md:text-[12px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all shadow-2xl">View Design ↗</button>
                    </div>
                </div>
                <div class="flex items-center justify-between px-6 md:px-8">
                    <h4 onclick="window.location.href='{{ route('marketplace.index', ['category' => $cat['slug']]) }}'" class="text-xl md:text-[24px] font-black tracking-tighter text-navy group-hover:text-primary transition-colors leading-none uppercase">{{ $cat['name'] }}</h4>
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full border border-navy/10 flex items-center justify-center group-hover:bg-navy group-hover:text-white transition-all">↗</div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Professional Call to Action Section -->
    </section>
    
    <!-- FAQ Section -->
    <section class="max-w-[1550px] mx-auto px-6 md:px-10 mb-24 md:mb-40">
        <div class="text-center mb-16 md:mb-24">
            <h2 class="text-[10px] md:text-[12px] font-black text-primary uppercase tracking-[0.3em] md:tracking-[0.5em] mb-4 md:mb-6">Got Questions?</h2>
            <h3 class="text-4xl md:text-[56px] font-black text-navy leading-none tracking-tighter uppercase">Frequently Asked <span class="text-primary">Questions</span></h3>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white border border-gray-100 rounded-[30px] md:rounded-[40px] overflow-hidden shadow-sm hover:shadow-md transition-all">
                <button class="w-full px-8 py-6 md:py-8 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                    <span class="text-lg md:text-xl font-black text-navy uppercase tracking-tight">What is BookingArc?</span>
                    <svg class="w-5 h-5 text-primary transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <div class="hidden px-8 pb-8 text-muted font-medium leading-relaxed">
                    BookingArc is a premium digital business card platform that allows professionals and brands to create interactive digital IDs. You can share your location, products, and contact details instantly using a single QR code.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white border border-gray-100 rounded-[30px] md:rounded-[40px] overflow-hidden shadow-sm hover:shadow-md transition-all">
                <button class="w-full px-8 py-6 md:py-8 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                    <span class="text-lg md:text-xl font-black text-navy uppercase tracking-tight">How do I create my digital card?</span>
                    <svg class="w-5 h-5 text-primary transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <div class="hidden px-8 pb-8 text-muted font-medium leading-relaxed">
                    Simply click on the "Create Business Card" button, fill in your business details, upload your logo and banners, and your premium digital identity will be ready in seconds.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white border border-gray-100 rounded-[30px] md:rounded-[40px] overflow-hidden shadow-sm hover:shadow-md transition-all">
                <button class="w-full px-8 py-6 md:py-8 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                    <span class="text-lg md:text-xl font-black text-navy uppercase tracking-tight">Can I update my info later?</span>
                    <svg class="w-5 h-5 text-primary transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <div class="hidden px-8 pb-8 text-muted font-medium leading-relaxed">
                    Yes! With our Business Pro subscription, you get full access to a personal dashboard where you can update your products, pricing, banners, and contact information anytime.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white border border-gray-100 rounded-[30px] md:rounded-[40px] overflow-hidden shadow-sm hover:shadow-md transition-all">
                <button class="w-full px-8 py-6 md:py-8 flex items-center justify-between text-left group" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                    <span class="text-lg md:text-xl font-black text-navy uppercase tracking-tight">Is physical printing available?</span>
                    <svg class="w-5 h-5 text-primary transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <div class="hidden px-8 pb-8 text-muted font-medium leading-relaxed">
                    Absolutely. We offer high-quality physical business cards with QR code integration. You can order them directly through our platform starting at just Rs 3 per piece.
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-black py-20 md:py-32 px-6 md:px-24">
        <div class="max-w-[1550px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-20">
            <!-- Brand & Info -->
            <div class="md:col-span-5 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center gap-3 mb-8 md:mb-10">
                    <img src="{{ asset('assets/stabndard.png') }}" alt="Logo" class="h-10 md:h-12 w-auto object-contain">
                </div>
                
                <div class="mb-10 md:mb-12 w-full">
                    <p class="text-white/50 text-[13px] font-medium leading-relaxed mb-8 max-w-sm">Premium digital identity platform for modern professionals and brands. Build your legacy with BookingArc.</p>
                    <input type="email" placeholder="Enter email for newsletter" 
                           class="w-full bg-transparent border border-white/30 px-6 py-4 text-white text-[13px] outline-none focus:border-white transition-colors rounded-xl font-medium">
                </div>

                <div class="flex flex-col gap-6 items-center md:items-start">
                    <p class="text-[10px] md:text-[11px] font-black text-white/40 uppercase tracking-widest">Connect with us</p>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">𝕏</div>
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">f</div>
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">📸</div>
                    </div>
                </div>
            </div>

            <!-- Link Columns -->
            <div class="hidden md:block md:col-span-1"></div>

            <div class="col-span-1 md:col-span-3 text-center md:text-left">
                <h5 class="text-[10px] md:text-[11px] font-black text-white uppercase tracking-widest mb-6 md:mb-10 opacity-60">The Platform</h5>
                <ul class="flex flex-col gap-4 md:gap-5">
                    <li><a href="{{ route('welcome') }}" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('marketplace.index') }}" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Marketplace</a></li>
                    <li><a href="/create" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Create Slot</a></li>
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Order Printing</a></li>
                </ul>
            </div>

            <div class="col-span-1 md:col-span-3 text-center md:text-left">
                <h5 class="text-[10px] md:text-[11px] font-black text-white uppercase tracking-widest mb-6 md:mb-10 opacity-60">Company</h5>
                <ul class="flex flex-col gap-4 md:gap-5">
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Our Pricing</a></li>
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="https://wa.me/9845004365" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Help Center</a></li>
                </ul>
            </div>
        </div>

        <div class="max-w-[1550px] mx-auto mt-20 md:mt-32 pt-16 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 md:gap-10">
            <p class="text-[9px] md:text-[10px] font-black text-white/20 uppercase tracking-[0.3em] md:tracking-[0.5em] text-center">© 2026 BookingArc LTD. ALL RIGHTS RESERVED.</p>
            <div class="flex gap-8 md:gap-12">
                <a href="#" class="text-[9px] md:text-[10px] font-black text-white/20 hover:text-white uppercase tracking-widest transition-colors">Terms of Use</a>
                <a href="#" class="text-[9px] md:text-[10px] font-black text-white/20 hover:text-white uppercase tracking-widest transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>

</body>
</html>
