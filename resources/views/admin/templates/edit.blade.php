@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.templates.show', $template->id) }}" class="inline-flex items-center text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Template
                    </a>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Edit Template</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Template #{{ $template->id }}</p>
                </div>
                <div class="flex gap-4">
                    <button type="submit" form="editTemplateForm" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <form id="editTemplateForm" action="{{ route('admin.templates.update', $template->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar - Settings -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            General Settings
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="recipient_name" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Recipient Name</label>
                                <input type="text" name="recipient_name" id="recipient_name" value="{{ $template->recipient_name }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none dark:bg-[#0f172a] dark:text-white">
                            </div>
                            
                            <div>
                                <label for="pin" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">PIN (Password)</label>
                                <input type="text" name="pin" id="pin" value="{{ $template->pin }}" maxlength="5" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none font-mono dark:bg-[#0f172a] dark:text-white">
                                <p class="text-xs text-gray-400 mt-1">5-digit numerical code</p>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none dark:bg-[#0f172a] dark:text-white">
                                    <option value="draft" {{ $template->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $template->status === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ $template->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="theme_color" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Theme Color</label>
                                    <div class="flex gap-2">
                                        <input type="color" name="theme_color" id="theme_color" value="{{ $template->theme_color ?? '#ff6b6b' }}" class="h-10 w-12 rounded border border-gray-200 dark:border-[#334155] bg-transparent">
                                        <input type="text" value="{{ $template->theme_color ?? '#ff6b6b' }}" class="w-full px-2 py-2 text-xs rounded-lg border border-gray-200 dark:border-[#334155] dark:bg-[#0f172a] dark:text-white" onchange="document.getElementById('theme_color').value = this.value">
                                    </div>
                                </div>
                                <div>
                                    <label for="bg_color" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">BG Color</label>
                                    <div class="flex gap-2">
                                        <input type="color" name="bg_color" id="bg_color" value="{{ $template->bg_color ?? '#ffffff' }}" class="h-10 w-12 rounded border border-gray-200 dark:border-[#334155] bg-transparent">
                                        <input type="text" value="{{ $template->bg_color ?? '#ffffff' }}" class="w-full px-2 py-2 text-xs rounded-lg border border-gray-200 dark:border-[#334155] dark:bg-[#0f172a] dark:text-white" onchange="document.getElementById('bg_color').value = this.value">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Info (Read Only) -->
                    <div class="bg-gray-100 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-200 dark:border-[#334155]">
                        <h3 class="text-sm font-bold text-gray-500 dark:text-[#64748b] uppercase tracking-wider mb-4">Metadata</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Template Type:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $template->template }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Submitted By:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $template->user->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Created:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $template->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Edit -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-[#334155]">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Text Content
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="heading" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Main Heading</label>
                                <input type="text" name="heading" id="heading" value="{{ $template->heading }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none text-xl font-bold dark:bg-[#0f172a] dark:text-white">
                            </div>
                            
                            <div>
                                <label for="subheading" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Subheading</label>
                                <input type="text" name="subheading" id="subheading" value="{{ $template->subheading }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none text-lg dark:bg-[#0f172a] dark:text-white">
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Message Content</label>
                                <textarea name="message" id="message" rows="6" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none dark:bg-[#0f172a] dark:text-white">{{ $template->message }}</textarea>
                            </div>
                            
                            <div>
                                <label for="from" class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">From (Signature)</label>
                                <input type="text" name="from" id="from" value="{{ $template->from }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-[#334155] focus:ring-2 focus:ring-blue-500 outline-none dark:bg-[#0f172a] dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-[#334155]">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Image Management
                        </h2>

                        <!-- Heading Images -->
                        <div class="mb-10">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Heading Images</h3>
                                <button type="button" onclick="document.getElementById('heading_images_input').click()" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Photo
                                </button>
                                <input type="file" id="heading_images_input" class="hidden" multiple accept="image/*" onchange="handleNewImages(this, 'heading-container', 'heading_images[]')">
                            </div>
                            
                            <div id="heading-container" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                    $headingImages = $template->heading_images ?? [];
                                @endphp
                                @foreach($headingImages as $url)
                                <div class="relative group aspect-square rounded-xl overflow-hidden border-2 border-gray-100 dark:border-[#334155]">
                                    <img src="{{ Str::startsWith($url, 'http') ? $url : asset('storage/' . $url) }}" class="w-full h-full object-cover">
                                    <input type="hidden" name="heading_images[]" value="{{ $url }}">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Memory Images -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Memory Images</h3>
                                <button type="button" onclick="document.getElementById('memory_images_input').click()" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Photo
                                </button>
                                <input type="file" id="memory_images_input" class="hidden" multiple accept="image/*" onchange="handleNewImages(this, 'memory-container', 'images[memories][]')">
                            </div>
                            
                            <div id="memory-container" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                    $memories = $template->images['memories'] ?? [];
                                @endphp
                                @foreach($memories as $url)
                                <div class="relative group aspect-square rounded-xl overflow-hidden border-2 border-gray-100 dark:border-[#334155]">
                                    <img src="{{ Str::startsWith($url, 'http') ? $url : asset('storage/' . $url) }}" class="w-full h-full object-cover">
                                    <input type="hidden" name="images[memories][]" value="{{ $url }}">
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
async function handleNewImages(input, containerId, fieldName) {
    const container = document.getElementById(containerId);
    const files = input.files;
    
    for (const file of files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const base64 = e.target.result;
            
            const div = document.createElement('div');
            div.className = 'relative group aspect-square rounded-xl overflow-hidden border-2 border-blue-200 dark:border-blue-900 shadow-md ring-2 ring-blue-500/20';
            div.innerHTML = `
                <img src="${base64}" class="w-full h-full object-cover">
                <input type="hidden" name="${fieldName}" value="${base64}">
                <div class="absolute inset-0 bg-blue-500/10 pointer-events-none"></div>
                <div class="absolute top-2 left-2 bg-blue-500 text-white text-[10px] px-1.5 py-0.5 rounded font-bold uppercase">New</div>
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
    // Reset input so discovery can happen again for same files
    input.value = '';
}

document.getElementById('editTemplateForm').onsubmit = async function(e) {
    e.preventDefault();
    
    // Show saving status
    Swal.fire({
        title: 'Saving changes...',
        text: 'Please wait while we update the template.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const formData = new FormData(this);
    const url = this.action;
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Template changes have been saved successfully.',
                confirmButtonColor: '#10b981'
            }).then(() => {
                window.location.href = "{{ route('admin.templates.show', $template->id) }}";
            });
        } else {
            throw new Error(data.message || 'Failed to update template');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Something went wrong while saving.',
            confirmButtonColor: '#ef4444'
        });
    }
};
</script>
@endsection
