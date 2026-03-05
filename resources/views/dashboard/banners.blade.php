@extends('layouts.dashboard', ['title' => 'Banners & Offers'])

@section('content')
<div class="space-y-12">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">
                {{ $business->category == 'personal' ? 'Hero Banners & Vision 🖼️' : 'Offers & Banners 🖼️' }}
            </h1>
            <p class="text-gray-500 dark:text-[#94a3b8]">
                {{ $business->category == 'personal' ? 'Manage the visual identity and hero sections of your profile.' : 'Keep your card fresh with active promotions.' }}
            </p>
        </div>
        <button onclick="document.getElementById('addBannerModal').classList.remove('hidden')" class="bg-theme text-white px-8 py-3 rounded-2xl font-black flex items-center gap-2 hover:shadow-xl transition-all active:scale-95">
            <span>➕</span> {{ $business->category == 'personal' ? 'Add Hero Image' : 'Add Banner' }}
        </button>
    </div>

    <!-- Banners Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($banners as $banner)
        <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] p-6 shadow-xl border border-gray-100 dark:border-[#334155] relative group">
            <div class="aspect-video rounded-[2rem] bg-gray-100 dark:bg-[#0f172a] mb-6 overflow-hidden relative">
                <img src="{{ Str::startsWith($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-md text-gray-900 rounded-full text-[10px] font-black uppercase tracking-widest">
                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                </div>
            </div>

            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $banner->title ?? 'Promo Banner' }}</h3>
            <p class="text-sm text-gray-400 font-bold mb-6">{{ $banner->description ?? 'No description provided' }}</p>
            
            <div class="flex gap-4">
                <button class="flex-grow py-4 bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-white rounded-2xl font-black text-sm hover:shadow-lg transition-all">Update Offer</button>
                <form action="{{ route('dashboard.banners.destroy', $banner->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-14 h-14 flex items-center justify-center bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all">🗑️</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="text-6xl mb-6">🏜️</div>
            <h2 class="text-2xl font-black text-gray-300">{{ $business->category == 'personal' ? 'No hero visuals yet.' : 'No active offers.' }}</h2>
            <p class="text-gray-400 font-bold mt-2">{{ $business->category == 'personal' ? 'These images appear in the main slider of your profile.' : 'Banners appear at the top of your digital card.' }}</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Banner Modal -->
<div id="addBannerModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-2xl w-full max-w-xl p-10">
            <h2 class="text-3xl font-black mb-8 text-gray-900 dark:text-white">
                {{ $business->category == 'personal' ? 'New Hero Image' : 'New Banner' }}
            </h2>
            
            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside text-sm font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('dashboard.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">
                        {{ $business->category == 'personal' ? 'Heading Title' : 'Offer Title' }}
                    </label>
                    <input type="text" name="title" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-theme font-bold text-gray-900 dark:text-white" placeholder="{{ $business->category == 'personal' ? 'e.g., Innovation in Leadership' : 'e.g., Dashain Festival Offer' }}">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">
                        {{ $business->category == 'personal' ? 'Hero Image' : 'Banner Image' }}
                    </label>
                    <input type="file" name="image" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 font-bold text-gray-900 dark:text-white">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">
                        {{ $business->category == 'personal' ? 'Narrative / Purpose' : 'Description' }}
                    </label>
                    <textarea name="description" rows="3" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-theme font-bold text-gray-900 dark:text-white" placeholder="{{ $business->category == 'personal' ? 'Short context for this visual section...' : 'Details about this offer...' }}"></textarea>
                </div>

                <button type="submit" class="w-full py-5 bg-theme text-white rounded-2xl font-black text-xl shadow-xl shadow-theme/20">
                    {{ $business->category == 'personal' ? 'Set Hero Section' : 'Upload Banner' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
