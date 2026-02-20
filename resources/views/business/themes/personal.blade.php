<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->business_name }} | Professional Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --accent: #2563eb;
        }
        body { font-family: 'DM Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .hero-bg {
            background: radial-gradient(circle at top right, #f8fafc, #ffffff);
        }
        .btn-shadow {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.02);
        }
    </style>
    @include('partials.analytics')
</head>
<body class="bg-white text-slate-900 antialiased selection:bg-slate-900 selection:text-white">
    <!-- Sophisticated Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md transition-all duration-300 border-b border-transparent" id="navbar">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3">
                @php
                    $logoUrl = $business->logo;
                    if ($logoUrl && !Str::startsWith($logoUrl, ['http://', 'https://'])) {
                        $logoUrl = asset('storage/' . $logoUrl);
                    }
                @endphp
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $business->business_name }}" class="h-9 w-auto rounded-lg">
                @else
                    <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold">
                        {{ substr($business->business_name, 0, 1) }}
                    </div>
                @endif
                <span class="text-xl font-bold tracking-tight text-slate-900">{{ $business->business_name }}</span>
            </a>
            
            <div class="hidden md:flex items-center gap-10">
                <nav class="flex items-center gap-8 text-sm font-medium text-slate-500">
                    <a href="#about" class="hover:text-slate-900 transition-colors">Experience</a>
                    <a href="#milestones" class="hover:text-slate-900 transition-colors">Milestones</a>
                    <a href="#contact" class="hover:text-slate-900 transition-colors">Contact</a>
                </nav>
                @if($business->whatsapp_number)
                <a href="https://wa.me/{{ $business->whatsapp_number }}" class="bg-slate-900 text-white px-7 py-3 rounded-full text-sm font-bold hover:bg-slate-800 transition-all active:scale-95 btn-shadow">
                    Connect
                </a>
                @endif
            </div>

            <button class="md:hidden text-slate-900" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 px-6 py-8 flex flex-col gap-6 text-center font-bold">
            <a href="#about" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-slate-600">Experience</a>
            <a href="#milestones" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-slate-600">Milestones</a>
            <a href="#contact" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="text-slate-600">Contact</a>
        </div>
    </nav>

    <!-- Balanced Hero Section -->
    <header class="relative pt-40 pb-24 md:pt-52 md:pb-40 px-6 hero-bg">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 md:gap-24 items-center">
            <div class="space-y-10 order-2 lg:order-1">
             
                
                <h1 class="text-6xl md:text-8xl font-serif text-slate-950 leading-[1.05] tracking-tight">
                    Driving <span class="italic text-slate-400">results</span> through strategy.
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 max-w-lg leading-relaxed font-medium">
                    {{ $business->description ?? 'Specializing in high-level management and corporate strategy with a focus on sustainable growth.' }}
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    @if($business->phone)
                    <a href="tel:{{ $business->phone }}" class="flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all btn-shadow group">
                        <span class="bg-slate-100 p-2 rounded-lg group-hover:bg-slate-200 transition-colors">📞</span>
                        Call Me
                    </a>
                    @endif
                    @if($business->email)
                    <a href="mailto:{{ $business->email }}" class="flex items-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all btn-shadow group">
                        <span class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-colors">✉</span>
                        Email Direct
                    </a>
                    @endif
                </div>
            </div>
            
            <div class="order-1 lg:order-2 relative">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-slate-100 rounded-full opacity-50 blur-3xl"></div>
                <div class="aspect-[4/5] rounded-[2.5rem] overflow-hidden bg-slate-50 shadow-2xl relative border border-white">
                    @php
                        $heroUrl = $business->hero_image ?? $business->logo;
                        if ($heroUrl && !Str::startsWith($heroUrl, ['http://', 'https://'])) {
                            $heroUrl = asset('storage/' . $heroUrl);
                        }
                    @endphp
                    @if($heroUrl)
                        <img src="{{ $heroUrl }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" onerror="this.src='https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=800';">
                    @else
                        <div class="w-full h-full bg-slate-50 flex flex-col items-center justify-center p-12 text-center">
                            <div class="w-20 h-20 bg-slate-200 rounded-full mb-6 flex items-center justify-center text-3xl">👤</div>
                            <h3 class="text-slate-400 font-bold tracking-widest uppercase text-xs">{{ $business->business_name }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Refined Experience Section -->
    <section id="about" class="py-24 md:py-32 px-6 border-t border-slate-100">
        <div class="max-w-6xl mx-auto">
            <div class="mb-20 text-center max-w-3xl mx-auto space-y-4">
                <span class="text-blue-600 text-[11px] font-black uppercase tracking-[0.3em]">The Approach</span>
                <h2 class="text-4xl md:text-6xl font-serif text-slate-950 tracking-tight leading-tight">Expertise forged in <br><span class="italic text-slate-400">professional</span> practice.</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-10 bg-slate-50 rounded-[2rem] border border-transparent hover:border-slate-200 hover:bg-white hover:shadow-2xl transition-all duration-500 group">
                    <div class="text-3xl mb-8 group-hover:scale-110 transition-transform">✦</div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">{{ $business->social_links['spec_1_title'] ?? 'Strategic Growth' }}</h4>
                    <p class="text-slate-500 leading-relaxed">{{ $business->social_links['spec_1_desc'] ?? 'Driving results through data-backed methodologies and visionary planning.' }}</p>
                </div>
                
                <div class="p-10 bg-slate-50 rounded-[2rem] border border-transparent hover:border-slate-200 hover:bg-white hover:shadow-2xl transition-all duration-500 group">
                    <div class="text-3xl mb-8 group-hover:scale-110 transition-transform">◈</div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">{{ $business->social_links['spec_2_title'] ?? 'Executive Action' }}</h4>
                    <p class="text-slate-500 leading-relaxed">{{ $business->social_links['spec_2_desc'] ?? 'Transforming complex challenges into streamlined operational successes.' }}</p>
                </div>

                <div class="p-10 bg-slate-900 text-white rounded-[2rem] shadow-xl flex flex-col justify-center">
                    <h4 class="text-2xl font-serif italic mb-6">"Strategy is about making choices, trade-offs; it's about deliberately choosing to be different."</h4>
                    <span class="text-[10px] font-black uppercase tracking-widest opacity-50">{{ $business->business_name }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Milestone Gallery -->
    <section id="milestones" class="py-24 md:py-32 px-6 bg-slate-50/50">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
                <div>
                    <span class="text-slate-400 text-[11px] font-black uppercase tracking-[0.3em] mb-4 block">Archive</span>
                    <h2 class="text-4xl md:text-5xl font-serif tracking-tight text-slate-950">Significant Milestones</h2>
                </div>
                
                @if($business->categories->count() > 0)
                <div class="flex flex-wrap gap-2">
                    <button class="menu-tab active px-6 py-2.5 bg-slate-900 text-white rounded-full text-xs font-bold transition-all shadow-lg" data-category="all">Gallery</button>
                    @foreach($business->categories as $category)
                    <button class="menu-tab px-6 py-2.5 bg-white text-slate-500 border border-slate-100 rounded-full text-xs font-bold transition-all hover:border-slate-300" data-category="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($business->products as $product)
                <div class="menu-item group bg-white border border-slate-100 rounded-[2rem] overflow-hidden hover:shadow-2xl transition-all duration-500" data-category="{{ $product->category->slug ?? 'all' }}">
                    <div class="aspect-[16/11] relative overflow-hidden">
                        @php
                            $imageUrl = $product->image;
                            if ($imageUrl && !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                $imageUrl = asset('storage/' . $imageUrl);
                            }
                        @endphp
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-200 text-6xl italic font-serif">M</div>
                        @endif
                    </div>
                    <div class="p-10">
                        <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 mb-3 block">{{ $product->category->name ?? 'Project' }}</span>
                        <h3 class="text-2xl font-bold mb-4 tracking-tight">{{ $product->name }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 font-medium line-clamp-2 italic opacity-80">{{ $product->description }}</p>
                        <a href="https://wa.me/{{ $business->whatsapp_number }}?text={{ urlencode('Greetings, I would like to inquire about: ' . $product->name) }}" class="flex items-center gap-3 text-slate-900 font-bold text-xs uppercase tracking-widest group-hover:gap-5 transition-all">
                            Review Details ➔
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                    <span class="text-5xl block mb-6">📂</span>
                    <span class="text-slate-400 font-bold uppercase tracking-widest text-[11px]">No milestones documented yet</span>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Strategic Contact -->
    <section id="contact" class="py-32 md:py-48 px-6 bg-white overflow-hidden relative">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="space-y-12">
                <h2 class="text-5xl md:text-8xl font-serif tracking-tight leading-[0.9] italic">Secure your <br><span class="text-slate-300">next move.</span></h2>
                <div class="space-y-8">
                    @if($business->whatsapp_number)
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-xl group-hover:rotate-12 transition-transform">💬</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">WhatsApp Secure</p>
                            <a href="https://wa.me/{{ $business->whatsapp_number }}" class="text-xl font-bold hover:text-blue-600 transition-colors">Start Inmediate Inquiry</a>
                        </div>
                    </div>
                    @endif
                    @if($business->email)
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 bg-slate-50 text-slate-900 border border-slate-100 rounded-2xl flex items-center justify-center text-xl group-hover:-rotate-12 transition-transform shadow-sm">✉</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Official Inquiry</p>
                            <a href="mailto:{{ $business->email }}" class="text-xl font-bold hover:text-blue-600 transition-colors">{{ $business->email }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="bg-slate-50 rounded-[3rem] p-12 md:p-16 border border-slate-100 shadow-sm text-center">
                 <h4 class="text-2xl font-bold mb-6">Inquiry Process</h4>
                 <p class="text-slate-500 mb-10 leading-relaxed font-medium">For official engagements and strategic partnerships, please use one of the direct channels. Response time typically within 12 business hours.</p>
                 <a href="https://wa.me/{{ $business->whatsapp_number }}" target="_blank" class="block w-full py-5 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-900/10 hover:bg-slate-800 transition-all active:scale-95">Initiate Engagement</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6 h-full flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex flex-col items-center md:items-start gap-4">
                <span class="text-2xl font-serif italic text-slate-900">{{ $business->business_name }}</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">Precision Through Strategy • 2024</span>
            </div>
            
            <div class="flex flex-wrap justify-center gap-10">
                @if(isset($business->social_links['linkedin']) && $business->social_links['linkedin'])
                    <a href="{{ $business->social_links['linkedin'] }}" target="_blank" class="text-slate-900 font-bold uppercase tracking-widest text-[9px] border-b border-slate-900/20 hover:border-slate-900 transition-all">LinkedIn</a>
                @endif
                @if(isset($business->social_links['facebook']) && $business->social_links['facebook'])
                    <a href="{{ $business->social_links['facebook'] }}" target="_blank" class="text-slate-500 hover:text-slate-900 transition-colors font-bold uppercase tracking-widest text-[9px]">Facebook</a>
                @endif
                @if(isset($business->social_links['instagram']) && $business->social_links['instagram'])
                    <a href="{{ $business->social_links['instagram'] }}" target="_blank" class="text-slate-500 hover:text-slate-900 transition-colors font-bold uppercase tracking-widest text-[9px]">Instagram</a>
                @endif
            </div>
            
            <div class="text-slate-400 text-[10px] font-bold">
                 © Registered Professional Portfolio
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('bg-white/95', 'shadow-sm', 'border-slate-100');
            } else {
                nav.classList.remove('bg-white/95', 'shadow-sm', 'border-slate-100');
            }
        });

        // Tab system
        const tabs = document.querySelectorAll('.menu-tab');
        const items = document.querySelectorAll('.menu-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('bg-slate-900', 'text-white', 'shadow-lg');
                    t.classList.add('bg-white', 'text-slate-500', 'border-slate-100');
                });
                tab.classList.remove('bg-white', 'text-slate-500', 'border-slate-100');
                tab.classList.add('bg-slate-900', 'text-white', 'shadow-lg');

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
