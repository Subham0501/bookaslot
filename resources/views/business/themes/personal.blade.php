<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} - Professional Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-main: 'Inter', sans-serif;
            --font-accent: 'Playfair Display', serif;
        }
        body { font-family: var(--font-main); }
        .font-accent { font-family: var(--font-accent); }
    </style>
    @include('partials.analytics')
</head>
<body class="bg-[#0f172a] text-slate-200 antialiased selection:bg-blue-500 selection:text-white">
    <!-- Professional Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-500 bg-[#0f172a]/80 backdrop-blur-xl border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 group">
                @if($business->logo)
                    <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" alt="{{ $business->business_name }}" class="h-10 w-auto rounded-lg ring-1 ring-white/10 group-hover:scale-105 transition-transform">
                @else
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-lg shadow-lg shadow-blue-600/20 group-hover:scale-105 transition-all">
                        {{ substr($business->business_name, 0, 1) }}
                    </div>
                @endif
                <span class="text-xl font-bold tracking-tight text-white group-hover:text-blue-400 transition-colors">{{ $business->business_name }}</span>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <div class="flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-400 border-r border-white/10 pr-8">
                    <a href="#about" class="hover:text-white transition-colors">About</a>
                    <a href="#portfolio" class="hover:text-white transition-colors">Achievements</a>
                    <a href="#contact" class="hover:text-white transition-colors">Contact</a>
                </div>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-blue-500 transition-all hover:shadow-lg hover:shadow-blue-600/20 active:scale-95">
                    Connect Now
                </a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white p-2 hover:bg-white/5 rounded-lg transition-colors" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-[#1e293b] border-b border-white/5 p-8 flex flex-col gap-6 text-center shadow-2xl animate-in slide-in-from-top duration-300">
            <a href="#about" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white">About</a>
            <a href="#portfolio" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white">Work</a>
            <a href="#contact" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white">Contact</a>
        </div>
    </nav>

    <!-- Professional Hero Section -->
    <header class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden bg-[#0f172a]">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-600/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
          
            
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-bold text-white mb-8 tracking-tighter leading-[0.9] drop-shadow-2xl">
                {{ $business->business_name }}
            </h1>
            
            <p class="text-slate-400 text-sm md:text-base font-medium tracking-[0.2em] mb-12 uppercase max-w-2xl mx-auto leading-loose">
                Specialized in Strategic Management • Corporate Excellence • Professional Vision
            </p>
            
            <div class="flex flex-wrap gap-4 justify-center items-center">
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Greetings! I would like to connect with you.') }}" class="bg-[#25D366] text-white px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-[#25D366]/20 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .011 5.403.008 12.039c0 2.12.54 4.19 1.564 6.04L0 24l6.108-1.603a11.777 11.777 0 005.938 1.61h.005c6.634 0 12.037-5.405 12.041-12.041.002-3.214-1.246-6.234-3.513-8.502z"/></svg>
                    WhatsApp
                </a>
                @endif
                
                @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="bg-white text-slate-900 px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all hover:scale-105 shadow-xl shadow-white/5 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Direct Call
                </a>
                @endif

                @if($business->email)
                <a href="mailto:{{ $business->email }}" class="bg-[#1e293b] text-white border border-white/10 px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#334155] transition-all hover:scale-105 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    Email Me
                </a>
                @endif
            </div>

            <!-- Social Links -->
            <div class="flex justify-center gap-8 mt-16">
                @if(isset($business->social_links['facebook']))
                <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="text-slate-500 hover:text-blue-500 transition-all hover:scale-125">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                @endif

                @if(isset($business->social_links['instagram']))
                <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="text-slate-500 hover:text-pink-500 transition-all hover:scale-125">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.132 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126s1.336 1.079 2.126 1.384c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384s1.079-1.335 1.384-2.126c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126s-1.335-1.079-2.126-1.384c-.765-.296-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07s-3.585-.015-4.85-.074c-1.17-.061-1.805-.256-2.227-.421-.562-.224-.96-.479-1.382-.899-.419-.419-.679-.824-.896-1.38-.164-.42-.36-1.065-.413-2.235-.057-1.274-.07-1.649-.07-4.859s.015-3.585.074-4.85c.061-1.17.256-1.805.421-2.227.224-.562.479-.96.899-1.382.419-.419.824-.679 1.38-.896.42-.164 1.065-.36 2.235-.413 1.274-.057 1.649-.07 4.859-.07zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                @endif
            </div>
            
            <div class="mt-20 flex justify-center border-t border-white/5 pt-12">
                <a href="#about" class="group flex flex-col items-center gap-4 text-slate-500 hover:text-white transition-colors">
                    <span class="text-[10px] font-bold uppercase tracking-[0.4em]">Explore Professional Journey</span>
                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7"></path></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-24 md:py-32 bg-[#0f172a] relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-center">
            <div class="relative">
                <div class="aspect-[3/4] rounded-2xl overflow-hidden relative shadow-2xl ring-1 ring-white/10 group">
                     <!-- Profile Image -->
                     @if($business->hero_image)
                        <img src="{{ Str::startsWith($business->hero_image, 'http') ? $business->hero_image : asset('storage/' . $business->hero_image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                     @elseif($business->logo)
                        <img src="{{ Str::startsWith($business->logo, 'http') ? $business->logo : asset('storage/' . $business->logo) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                     @else
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                     @endif
                     <div class="absolute inset-0 bg-blue-600/10 mix-blend-overlay"></div>
                </div>
              
            </div>
            
            <div class="md:text-left text-center">
                <span class="text-blue-400 text-[10px] font-bold uppercase tracking-[0.4em] mb-4 block">Strategic Vision</span>
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-8 leading-tight tracking-tighter">
                    Innovation driven by <br><span class="text-slate-500">Corporate Excellence.</span>
                </h2>
                <div class="w-20 h-1 bg-blue-600 mb-8 md:mx-0 mx-auto rounded-full"></div>
                <p class="text-slate-400 text-base md:text-lg leading-relaxed mb-10">
                    {{ $business->description ?? 'Specializing in corporate strategy and high-level management, I bring a wealth of experience in driving organizational growth and fostering innovative business solutions. My approach is rooted in precision, reliability, and a forward-thinking mindset.' }}
                </p>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <div class="text-blue-400 text-lg">✦</div>
                        <div class="text-white font-bold text-sm tracking-wide">
                            {{ $business->social_links['spec_1_title'] ?? 'Strategic Planning' }}
                        </div>
                        <p class="text-slate-500 text-xs">
                            {{ $business->social_links['spec_1_desc'] ?? 'Visionary approach to business growth.' }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <div class="text-blue-400 text-lg">✦</div>
                        <div class="text-white font-bold text-sm tracking-wide">
                            {{ $business->social_links['spec_2_title'] ?? 'Elite Leadership' }}
                        </div>
                        <p class="text-slate-500 text-xs">
                            {{ $business->social_links['spec_2_desc'] ?? 'Managing high-performance teams.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements / Portfolio Section -->
    <section id="portfolio" class="py-24 bg-[#1e293b] relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <span class="text-blue-400 text-[10px] font-bold uppercase tracking-[0.4em] mb-4 block">Milestones</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Professional Achievements</h2>
                </div>
                
                @if($business->categories->count() > 0)
                <div class="flex flex-wrap gap-3">
                    <button class="menu-tab active px-6 py-2.5 bg-blue-600 text-white rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20" data-category="all">All</button>
                    @foreach($business->categories as $category)
                    <button class="menu-tab px-6 py-2.5 bg-white/5 text-slate-400 rounded-lg text-xs font-bold uppercase tracking-widest transition-all hover:bg-white/10 hover:text-white" data-category="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 @forelse($business->products as $product)
                <div class="menu-item group bg-[#0f172a] rounded-2xl overflow-hidden border border-white/5 hover:border-blue-500/50 transition-all duration-500" data-category="{{ $product->category->slug ?? 'all' }}">
                    <div class="relative h-64 overflow-hidden">
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl bg-slate-800">💼</div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-60"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">{{ $product->name }}</h3>
                            <span class="bg-blue-600/10 text-blue-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Case Study</span>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2">
                            {{ $product->description ?? 'Detailed overview of strategic implementation and results.' }}
                        </p>
                        <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('I would like to know more about: ' . $product->name) }}" class="inline-flex items-center gap-2 text-blue-400 text-xs font-bold uppercase tracking-widest hover:gap-4 transition-all">
                            Learn More <span>→</span>
                        </a>
                    </div>
                </div>
                 @empty
                <div class="col-span-full py-20 text-center text-slate-600 text-xs uppercase tracking-widest bg-white/5 rounded-3xl border border-dashed border-white/10">
                    Milestones are being synchronized...
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Professional CTA -->
    <section id="contact" class="py-24 bg-[#0f172a] relative border-t border-white/5">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-10 shadow-2xl shadow-blue-600/40 rotate-12">
                <svg class="w-10 h-10 text-white -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <span class="text-blue-400 text-[10px] font-bold uppercase tracking-[0.4em] mb-4 block">Global Connectivity</span>
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-12 tracking-tight">Ready for the next <br><span class="text-slate-500">strategic partnership?</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                 @if($business->phone)
                <a href="tel:{{ $business->phone }}" class="p-8 rounded-2xl bg-white/5 border border-white/5 hover:border-blue-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Voice Call</div>
                    <div class="text-white font-bold">{{ $business->phone }}</div>
                </a>
                @endif
                
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="p-8 rounded-2xl bg-white/5 border border-white/5 hover:border-[#25D366]/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-[#25D366] flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .011 5.403.008 12.039c0 2.12.54 4.19 1.564 6.04L0 24l6.108-1.603a11.777 11.777 0 005.938 1.61h.005c6.634 0 12.037-5.405 12.041-12.041.002-3.214-1.246-6.234-3.513-8.502z"/></svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">WhatsApp</div>
                    <div class="text-white font-bold">Secure Message</div>
                </a>
                @endif

                @if($business->email)
                <a href="mailto:{{ $business->email }}" class="p-8 rounded-2xl bg-white/5 border border-white/5 hover:border-blue-500/50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Email Address</div>
                    <div class="text-white font-bold">Official Inquiry</div>
                </a>
                @endif
            </div>
        </div>
    </section>

            <div class="mt-24 text-slate-500 text-xs font-bold uppercase tracking-[0.2em] opacity-40">
                <p>{{ $business->address ?? 'Corporate Headquarters • Global Operations' }}</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0f172a] py-12 border-t border-white/5 text-center">
        <p class="text-slate-600 text-[10px] font-bold uppercase tracking-widest">&copy; {{ date('Y') }} {{ $business->business_name }} • Strategic Excellence • All rights reserved.</p>
    </footer>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl', 'bg-[#0f172a]');
            } else {
                nav.classList.remove('shadow-2xl', 'bg-[#0f172a]');
            }
        });

        // Simple Tab filtering
        const tabs = document.querySelectorAll('.menu-tab');
        const items = document.querySelectorAll('.menu-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-600/20');
                    t.classList.add('bg-white/5', 'text-slate-400');
                });
                tab.classList.remove('bg-white/5', 'text-slate-400');
                tab.classList.add('bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-600/20');

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
