@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.templates.index') }}" class="inline-flex items-center text-gray-600 dark:text-[#cbd5e1] hover:text-gray-900 dark:hover:text-white mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Admin Panel
                    </a>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Review Template</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Template #{{ $template->id }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Sidebar - Template Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Template Details -->
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Template Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Recipient Name</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->recipient_name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">PIN</label>
                            <p class="text-lg font-mono text-gray-900 dark:text-white">{{ $template->pin ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Template Type</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->template }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Page Name</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->page_name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Slug</label>
                            <p class="text-sm font-mono text-gray-600 dark:text-[#cbd5e1] break-all">{{ $template->slug ?? 'Not generated yet' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Submitted By</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-[#64748b]">{{ $template->user->email ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Submitted At</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-1">Status</label>
                            @if($template->status === 'draft')
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Draft
                                </span>
                            @elseif($template->status === 'published')
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Published
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Archived
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Actions</h2>
                    
                    <div class="space-y-3">
                        @if($template->status === 'draft')
                        <button onclick="approveTemplate({{ $template->id }})" class="w-full bg-green-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-600 transition-colors">
                            Approve & Publish
                        </button>
                        <button onclick="rejectTemplate({{ $template->id }})" class="w-full bg-red-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-600 transition-colors">
                            Reject
                        </button>
                        @endif

                        <a href="{{ route('admin.templates.edit', $template->id) }}" class="w-full bg-indigo-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-600 transition-colors text-center block">
                            Edit Template Data
                        </a>
                        
                        <button onclick="deleteTemplate({{ $template->id }})" class="w-full bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition-colors border-2 border-red-700">
                            Delete Template
                        </button>
                        
                        @if($template->status === 'published' && $template->slug)
                        <a href="{{ url('/' . $template->slug) }}" target="_blank" class="w-full bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 transition-colors text-center block">
                            View Live Template
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side - Template Preview -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Template Content -->
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Template Content</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Heading</label>
                            <p class="text-xl text-gray-900 dark:text-white">{{ $template->heading ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Subheading</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->subheading ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Message</label>
                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $template->message ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">From</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $template->from ?? 'N/A' }}</p>
                        </div>
                        
                        @if($template->memory_date)
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 dark:text-[#cbd5e1] mb-2">Memory Date</label>
                            <p class="text-lg text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($template->memory_date)->format('M d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Heading Images -->
                @php
                    $headingImages = $template->heading_images;
                    if (is_string($headingImages)) {
                        $headingImages = json_decode($headingImages, true) ?? [];
                    }
                    if (!is_array($headingImages)) {
                        $headingImages = [];
                    }
                @endphp
                
                @if(count($headingImages) > 0)
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Heading Images 
                        <span class="text-sm font-normal text-gray-500 dark:text-[#64748b]">({{ count($headingImages) }})</span>
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($headingImages as $index => $imageUrl)
                            @php
                                $finalUrl = $imageUrl;
                                if (str_starts_with($imageUrl, 'http')) {
                                    $finalUrl = $imageUrl;
                                } elseif (str_starts_with($imageUrl, '/storage')) {
                                    $finalUrl = asset($imageUrl);
                                } else {
                                    $finalUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            <div class="relative group">
                                <img src="{{ $finalUrl }}" alt="Heading Image {{ $index + 1 }}" 
                                     class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-[#334155] hover:border-[#ff6b6b] transition-colors cursor-pointer"
                                     onclick="openImageModal('{{ $finalUrl }}', 'Heading Image {{ $index + 1 }}')"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect fill=\'%23ddd\' width=\'100\' height=\'100\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage%3C/text%3E%3C/svg%3E'">
                                <div class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    #{{ $index + 1 }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Additional Images (Memories) -->
                @php
                    $images = $template->images;
                    if (is_string($images)) {
                        $images = json_decode($images, true) ?? [];
                    }
                    if (!is_array($images)) {
                        $images = [];
                    }
                    $memories = $images['memories'] ?? [];
                @endphp
                
                @if(count($memories) > 0)
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Memory Images 
                        <span class="text-sm font-normal text-gray-500 dark:text-[#64748b]">({{ count($memories) }})</span>
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($memories as $index => $imageUrl)
                            @php
                                $finalUrl = $imageUrl;
                                if (str_starts_with($imageUrl, 'http')) {
                                    $finalUrl = $imageUrl;
                                } elseif (str_starts_with($imageUrl, '/storage')) {
                                    $finalUrl = asset($imageUrl);
                                } else {
                                    $finalUrl = asset('storage/' . $imageUrl);
                                }
                            @endphp
                            <div class="relative group">
                                <img src="{{ $finalUrl }}" alt="Memory Image {{ $index + 1 }}" 
                                     class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-[#334155] hover:border-[#ff6b6b] transition-colors cursor-pointer"
                                     onclick="openImageModal('{{ $finalUrl }}', 'Memory Image {{ $index + 1 }}')"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect fill=\'%23ddd\' width=\'100\' height=\'100\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage%3C/text%3E%3C/svg%3E'">
                                <div class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    #{{ $index + 1 }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(count($headingImages) === 0 && count($memories) === 0)
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                    <p class="text-gray-500 dark:text-[#64748b] text-center">No images uploaded for this template.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center" onclick="closeImageModal()">
    <div class="relative max-w-7xl max-h-[90vh] p-4" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 rounded-full p-2 z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] rounded-lg">
        <p id="modalCaption" class="text-white text-center mt-4"></p>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function openImageModal(imageUrl, caption) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
    document.body.style.overflow = '';
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

async function approveTemplate(id) {
    const result = await Swal.fire({
        title: 'Approve Template?',
        text: 'This will publish the template and generate a slug. Continue?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Approve',
        cancelButtonText: 'Cancel'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/templates/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Template Approved!',
                    html: `
                        <p class="mb-2">Template has been published successfully!</p>
                        <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded-lg mt-3">
                            <p class="text-sm font-semibold mb-1">URL:</p>
                            <p class="text-blue-600 dark:text-blue-400 break-all font-mono text-sm">${window.location.origin}/${data.slug}</p>
                        </div>
                    `,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK'
                });
                window.location.href = '{{ route("admin.templates.index") }}';
            } else {
                throw new Error(data.message || 'Failed to approve template');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to approve template',
                confirmButtonColor: '#ef4444'
            });
        }
    }
}

async function rejectTemplate(id) {
    const result = await Swal.fire({
        title: 'Reject Template?',
        text: 'This will archive the template. Continue?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Reject',
        cancelButtonText: 'Cancel'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/templates/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Template Rejected',
                    text: 'Template has been archived.',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
                window.location.href = '{{ route("admin.templates.index") }}';
            } else {
                throw new Error(data.message || 'Failed to reject template');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to reject template',
                confirmButtonColor: '#ef4444'
            });
        }
    }
}

async function deleteTemplate(id) {
    const result = await Swal.fire({
        title: 'Delete Template?',
        html: '<p class="mb-2">This will permanently delete the template and <strong>all associated images from Cloudflare storage</strong>.</p><p class="text-red-600 dark:text-red-400 font-semibold">This action cannot be undone!</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        // Show loading
        Swal.fire({
            title: 'Deleting...',
            text: 'Please wait while we delete the template and images from Cloudflare.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const response = await fetch(`/admin/templates/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Template Deleted!',
                    text: 'Template and all associated images have been deleted successfully from Cloudflare.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK'
                });
                window.location.href = '{{ route("admin.templates.index") }}';
            } else {
                throw new Error(data.message || 'Failed to delete template');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to delete template',
                confirmButtonColor: '#ef4444'
            });
        }
    }
}
</script>
@endsection
