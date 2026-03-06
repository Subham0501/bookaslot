<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace Explorer | Hamro Yaad</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/stabndard.png') }}">
    
    <!-- Fonts - Outfit -->
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
                        primary: '#3D5AFE',
                        navy: '#010514',
                        surface: '#F1F4FF',
                        muted: '#707393',
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
        .search-container {
            background-color: #F1F4FF;
            padding: 60px 0;
            border-bottom: 1px solid rgba(61, 90, 254, 0.05);
        }
        .search-pill {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 1100px;
            border-radius: 35px;
            display: flex;
            flex-direction: column;
            padding: 12px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            margin: 0 auto;
        }
        @media (min-width: 768px) {
            .search-pill {
                height: 80px;
                border-radius: 9999px;
                flex-direction: row;
                padding: 8px;
            }
        }
        .v-divider {
            width: 1px;
            height: 35px;
            background-color: rgba(1, 4, 15, 0.08);
        }
        .search-input {
            flex: 1;
            padding: 0 30px;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            font-weight: 600;
            color: #010514;
        }
        .search-input::placeholder {
            color: #707393;
            opacity: 0.6;
        }
        .category-pill {
            padding: 10px 24px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            transition: all 0.3s;
            border: 1px solid #E2E8F0;
            color: #707393;
            background: white;
        }
        .category-pill.active {
            background: #010514;
            color: white;
            border-color: #010514;
        }
        .category-pill:hover:not(.active) {
            border-color: #3D5AFE;
            color: #3D5AFE;
        }
        .business-card {
            background: white;
            border-radius: 45px;
            overflow: hidden;
            transition: all 0.4s;
            border: 1px solid #F1F4FF;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .business-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px -15px rgba(1, 5, 20, 0.1);
            border-color: rgba(61, 90, 254, 0.2);
        }
        .card-image-wrapper {
            aspect-ratio: 16/10;
            position: relative;
            overflow: hidden;
            border-radius: 40px 40px 0 0;
        }
        .card-tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 6px 16px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #010514;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .nav-btn-navy {
            background-color: #010514;
            color: white;
            padding: 8px 8px 8px 25px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        @media (min-width: 768px) {
            .nav-btn-navy {
                padding: 10px 10px 10px 35px;
                font-size: 12px;
                gap: 15px;
            }
        }
        .btn-blue {
            background-color: #3D5AFE;
            color: white;
            padding: 12px 28px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 800;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-blue:hover {
            background-color: #010514;
            transform: translateY(-2px);
        }
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
                <a href="{{ route('marketplace.index', ['category' => 'Travel']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors {{ request('category') == 'Travel' ? 'text-primary' : '' }}">Travel & Tour</a>
                <a href="{{ route('marketplace.index', ['category' => 'Ecommerce']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors {{ request('category') == 'Ecommerce' ? 'text-primary' : '' }}">E-commerce</a>
                <a href="{{ route('marketplace.index', ['category' => 'Consultancy']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors {{ request('category') == 'Consultancy' ? 'text-primary' : '' }}">Consultancy</a>
                <a href="{{ route('marketplace.index', ['category' => 'Hotel']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors {{ request('category') == 'Hotel' ? 'text-primary' : '' }}">Hotels & Restaurants</a>
                <a href="{{ route('marketplace.index', ['category' => 'Photography']) }}" class="text-[10px] font-black text-muted uppercase tracking-widest hover:text-primary transition-colors {{ request('category') == 'Photography' ? 'text-primary' : '' }}">Events & Photo</a>
            </div>

            <a href="{{ url('/create') }}" class="nav-btn-navy group whitespace-nowrap">
                <span class="hidden sm:inline">Get Started</span>
                <span class="sm:hidden">Get Card</span>
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white text-primary flex items-center justify-center shadow-xl">
                    <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="4"></path></svg>
                </div>
            </a>
        </div>
    </nav>

    <!-- Search Section -->
    <section class="search-container px-6 py-12 md:py-20">
        <div class="max-w-[1200px] mx-auto text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-6xl heading-bold text-navy mb-4 md:mb-6 tracking-tighter uppercase">Explore Marketplace</h1>
            <p class="text-base md:text-lg text-muted font-medium max-w-2xl mx-auto tracking-tight">Discover top-tier digital IDs, travel packages, and premium services created by our community.</p>
        </div>
        
        <form action="{{ route('marketplace.index') }}" method="GET" class="search-pill">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search company or service..." class="search-input py-4 md:py-0 w-full border-b md:border-b-0 border-gray-50">
            <div class="v-divider"></div>
            <select name="sort" class="search-input !px-8 py-4 md:py-0 cursor-pointer appearance-none bg-transparent w-full" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            <button type="submit" class="w-full md:w-[64px] h-[54px] md:h-[64px] bg-primary rounded-2xl md:rounded-full flex items-center justify-center text-white shadow-lg hover:bg-navy transition-all flex-shrink-0 gap-2 mt-4 md:mt-0">
                <span class="md:hidden font-black uppercase text-[12px] tracking-widest">Search Catalog</span>
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="4"></path></svg>
            </button>
        </form>
    </section>

    <!-- Categories Section -->
    <section class="max-w-[1300px] mx-auto px-6 py-12">
        <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pb-4">
            <a href="{{ route('marketplace.index') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">All Categories</a>
            @foreach($categories as $cat)
                <a href="{{ route('marketplace.index', ['category' => $cat]) }}" class="category-pill {{ request('category') == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </section>

    <!-- Business Listings -->
    <section class="max-w-[1300px] mx-auto px-6 pb-20 md:pb-32">
        @if($businesses->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
                @foreach($businesses as $business)
                    @php
                        $heroUrl = $business->hero_image;
                        if ($heroUrl && !Str::startsWith($heroUrl, ['http://', 'https://'])) {
                            $heroUrl = asset('storage/' . $heroUrl);
                        }
                        if (!$heroUrl) {
                            $heroUrl = 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&q=80';
                        }
                        
                        // If search matched a specific product with an image, use that instead
                        if ($business->search_matched_image) {
                            $matchedImage = $business->search_matched_image;
                            if (Str::startsWith($matchedImage, ['http://', 'https://'])) {
                                $heroUrl = $matchedImage;
                            } else {
                                $heroUrl = asset('storage/' . $matchedImage);
                            }
                        } else {
                            // Fallback to category defaults if no hero image or matched product image
                            if (!$business->hero_image) {
                                if ($business->category == 'Photography') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80';
                                }
                                elseif ($business->category == 'Travel') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&q=80';
                                }
                                elseif ($business->category == 'Hotel') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=800&q=80';
                                }
                                elseif ($business->category == 'Ecommerce') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&q=80';
                                }
                                elseif ($business->category == 'Consultancy') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&q=80';
                                }
                                elseif ($business->category == 'Corporate') {
                                    $heroUrl = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80';
                                }
                            }
                        }

                        $designUrl = '/profile/' . $business->id; // Default to business profile
                    @endphp
                    <div class="business-card group">
                        <div class="card-image-wrapper">
                            <img src="{{ $heroUrl }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <span class="card-tag">{{ $business->category ?? 'Service' }}</span>
                        </div>
                        <div class="p-6 md:p-10 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-6">
                                @if($business->logo)
                                    <img src="{{ Str::startsWith($business->logo, ['http://', 'https://']) ? $business->logo : asset('storage/' . $business->logo) }}" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border border-gray-100">
                                @else
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-lg md:text-xl">
                                        {{ substr($business->business_name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex flex-col gap-0.5">
                                    <h3 class="text-xl md:text-2xl font-black text-navy leading-none tracking-tighter">
                                        {{ $business->search_matched_name ?? $business->business_name }}
                                    </h3>
                                    @if($business->search_matched_name)
                                        <p class="text-[10px] md:text-[11px] font-bold text-primary/60 uppercase tracking-widest leading-none mt-1">
                                            {{ $business->business_name }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-[13px] md:text-[14px] text-muted font-medium mb-6 md:mb-8 line-clamp-2 leading-relaxed tracking-tight">
                                {{ $business->search_matched_description ?? ($business->description ?? 'Discover premium quality services and products listed in our marketplace by ' . $business->business_name . '.') }}
                            </p>
                            
                            <div class="mt-auto flex flex-col sm:flex-row items-start sm:items-center justify-between border-t border-gray-50 pt-6 md:pt-8 gap-6">
                                <div>
                                    <p class="text-[9px] md:text-[10px] font-black text-muted uppercase tracking-widest mb-1">Price</p>
                                    <p class="text-lg md:text-xl font-black text-primary tracking-tighter">
                                        {{ $business->products_min_price ? 'NPR ' . number_format($business->products_min_price) : 'Contact Us' }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-2 w-full sm:w-auto">
                                    <a href="{{ $business->profile_url }}" target="_blank" class="btn-blue h-fit w-full sm:w-auto justify-center">
                                        View Link
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="3"></path></svg>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-20">
                {{ $businesses->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-gray-50 rounded-[45px] border-2 border-dashed border-gray-200">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                    <svg class="w-10 h-10 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-navy mb-3 tracking-tighter">No businesses found</h3>
                <p class="text-muted font-medium">Try adjusting your search filters or categories.</p>
                <a href="{{ route('marketplace.index') }}" class="btn-blue mt-8">Clear all filters</a>
            </div>
        @endif
    </section>

    <!-- Professional CTA Section -->
    <section class="max-w-[1300px] mx-auto px-6 pb-20 md:pb-32">
        <div class="bg-navy rounded-[45px] p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/20 to-transparent"></div>
            <div class="relative z-10 flex flex-col items-center">
                <h2 class="text-2xl md:text-4xl font-black text-white mb-4 tracking-tighter uppercase leading-tight">New professional? <br class="md:hidden"> Create your slot here</h2>
                <p class="text-white/60 font-medium mb-8 max-w-lg">Get listed in our premium marketplace and connect with thousands of customers instantly.</p>
                <a href="https://wa.me/9845004365" target="_blank" class="bg-primary text-white px-10 py-5 rounded-full text-sm font-black uppercase tracking-widest hover:bg-white hover:text-navy transition-all shadow-2xl flex items-center gap-3">
                    <span>Contact WhatsApp</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-black py-20 md:py-32 px-6 md:px-24">
        <div class="max-w-[1300px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-20">
            <!-- Brand & Newsletter -->
            <div class="md:col-span-4 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center gap-3 mb-8 md:mb-10">
                    <img src="{{ asset('assets/stabndard.png') }}" alt="Logo" class="h-10 md:h-12 w-auto object-contain">
                </div>
                
                <div class="mb-10 md:mb-12 w-full">
                    <input type="email" placeholder="Enter email for updates" 
                           class="w-full bg-transparent border border-white/30 px-6 py-4 text-white text-[13px] outline-none focus:border-white transition-colors">
                </div>

                <div class="flex flex-col gap-6 items-center md:items-start">
                    <p class="text-[10px] md:text-[11px] font-black text-white/40 uppercase tracking-widest">Connect with us</p>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">𝕏</div>
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">f</div>
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">📸</div>
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/10 flex items-center justify-center text-white text-base md:text-lg hover:bg-white/20 transition-all cursor-pointer">🌐</div>
                    </div>
                </div>
            </div>

            <!-- Empty Spacer for Alignment -->
            <div class="hidden md:block md:col-span-1"></div>

            <!-- Link Columns -->
            <div class="col-span-1 md:col-span-2 text-center md:text-left">
                <h5 class="text-[10px] md:text-[11px] font-black text-white uppercase tracking-widest mb-6 md:mb-10 opacity-60">The Platform</h5>
                <ul class="flex flex-col gap-4 md:gap-5">
                    <li><a href="{{ route('welcome') }}" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">About</a></li>
                    <li><a href="{{ route('marketplace.index') }}" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Marketplace</a></li>
                    <li><a href="/create" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Create Slot</a></li>
                </ul>
            </div>

            <div class="col-span-1 md:col-span-2 text-center md:text-left">
                <h5 class="text-[10px] md:text-[11px] font-black text-white uppercase tracking-widest mb-6 md:mb-10 opacity-60">Learn More</h5>
                <ul class="flex flex-col gap-4 md:gap-5">
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Pricing</a></li>
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">Mobile App</a></li>
                    <li><a href="#" class="text-[13px] font-medium text-white/50 hover:text-white transition-colors">API</a></li>
                </ul>
            </div>

            <div class="col-span-1 md:col-span-3">
                <h5 class="text-[10px] md:text-[11px] font-black text-white uppercase tracking-widest mb-6 md:mb-10 opacity-60 text-center md:text-left text-center md:text-left">Ads via the Deck</h5>
                <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                    <img src="https://images.unsplash.com/photo-1542744094-24638eff58bb?w=400&q=80" 
                         class="w-full aspect-video object-cover rounded-lg mb-6 shadow-2xl opacity-80">
                    <p class="text-[11px] md:text-[13px] text-white/70 font-medium leading-relaxed mb-6 text-center md:text-left">
                        Unite your creative team in one place. Share visual files & get feedback instantly.
                    </p>
                    <div class="text-center md:text-left">
                        <a href="#" class="text-[11px] md:text-[12px] font-black text-white uppercase border-b border-white pb-1 group hover:text-primary hover:border-primary transition-all">Try it now <span class="group-hover:translate-x-1 inline-block transition-transform">↗</span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-[1300px] mx-auto mt-20 md:mt-32 pt-16 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 md:gap-10">
            <p class="text-[9px] md:text-[10px] font-black text-white/20 uppercase tracking-[0.3em] md:tracking-[0.5em] text-center">© 2026 BookingArc LTD. ALL RIGHTS RESERVED.</p>
            <div class="flex gap-8 md:gap-12">
                <a href="#" class="text-[9px] md:text-[10px] font-black text-white/20 hover:text-white uppercase tracking-widest transition-colors">Terms of Use</a>
                <a href="#" class="text-[9px] md:text-[10px] font-black text-white/20 hover:text-white uppercase tracking-widest transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>

</body>
</html>
