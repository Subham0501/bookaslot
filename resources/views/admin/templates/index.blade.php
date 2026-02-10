@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">Admin Panel</h1>
                    <p class="text-lg text-gray-600 dark:text-[#cbd5e1]">Manage and review templates</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.gifts.index') }}" class="bg-blue-500 dark:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                        Gifts
                    </a>
                <a href="/" class="bg-gray-200 dark:bg-[#334155] text-gray-900 dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-[#475569] transition-colors">
                    Back to Home
                </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-[#cbd5e1] mb-1">Pending Reviews</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['draft'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-[#cbd5e1] mb-1">Published</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['published'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-[#cbd5e1] mb-1">Archived</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['archived'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-[#334155]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-[#cbd5e1] mb-1">Total Templates</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-4 mb-6 border border-gray-100 dark:border-[#334155]">
            <div class="flex items-center gap-4 flex-wrap">
                <span class="text-sm font-semibold text-gray-600 dark:text-[#cbd5e1]">Filter by Status:</span>
                <a href="{{ route('admin.templates.index', ['status' => 'all']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $currentStatus === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-[#334155] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-300 dark:hover:bg-[#475569]' }}">
                    All ({{ $stats['total'] }})
                </a>
                <a href="{{ route('admin.templates.index', ['status' => 'draft']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $currentStatus === 'draft' ? 'bg-yellow-500 text-white' : 'bg-gray-200 dark:bg-[#334155] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-300 dark:hover:bg-[#475569]' }}">
                    Draft ({{ $stats['draft'] }})
                </a>
                <a href="{{ route('admin.templates.index', ['status' => 'published']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $currentStatus === 'published' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-[#334155] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-300 dark:hover:bg-[#475569]' }}">
                    Published ({{ $stats['published'] }})
                </a>
                <a href="{{ route('admin.templates.index', ['status' => 'archived']) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $currentStatus === 'archived' ? 'bg-red-500 text-white' : 'bg-gray-200 dark:bg-[#334155] text-gray-700 dark:text-[#cbd5e1] hover:bg-gray-300 dark:hover:bg-[#475569]' }}">
                    Archived ({{ $stats['archived'] }})
                </a>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if($templates->count() > 0)
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-4 mb-6 border border-gray-100 dark:border-[#334155]">
            <div class="flex items-center gap-4 flex-wrap">
                <span class="text-sm font-semibold text-gray-600 dark:text-[#cbd5e1]">Bulk Actions:</span>
                <div class="flex-1 min-w-[300px]">
                    <select id="bulkSelectTemplates" class="w-full" multiple="multiple" style="width: 100%;">
                        @foreach($templates as $template)
                        <option value="{{ $template->id }}">
                            #{{ $template->id }} - {{ $template->recipient_name ?? 'N/A' }} ({{ ucfirst($template->status) }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <button onclick="bulkDeleteTemplates()" class="bg-red-500 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors">
                    Delete Selected
                </button>
                <button onclick="selectAllTemplates()" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-600 transition-colors">
                    Select All
                </button>
                <button onclick="clearSelection()" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-500 transition-colors">
                    Clear
                </button>
            </div>
        </div>
        @endif

        <!-- Templates List -->
        @if($templates->count() > 0)
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl border border-gray-100 dark:border-[#334155] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-[#0f172a] border-b border-gray-200 dark:border-[#334155]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">Recipient</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">Template</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-[#cbd5e1] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-[#334155]">
                        @foreach($templates as $template)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#0f172a] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">#{{ $template->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $template->recipient_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-[#cbd5e1]">{{ $template->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-[#cbd5e1]">{{ $template->template }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($template->status === 'draft')
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Draft
                                    </span>
                                @elseif($template->status === 'published')
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Archived
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-[#cbd5e1]">{{ $template->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.templates.show', $template->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors">
                                        Review
                                    </a>
                                    <a href="{{ route('admin.templates.edit', $template->id) }}" class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-600 transition-colors">
                                        Edit
                                    </a>
                                    <button onclick="deleteTemplate({{ $template->id }})" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl shadow-xl p-12 border border-gray-100 dark:border-[#334155] text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-[#64748b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Templates Found</h3>
            <p class="text-gray-600 dark:text-[#cbd5e1]">No templates match the current filter.</p>
        </div>
        @endif
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
/* Select2 Dark Mode Support */
.dark .select2-container--default .select2-selection--multiple {
    background-color: #1e293b;
    border: 1px solid #334155;
    color: #cbd5e1;
}

.dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #334155;
    border: 1px solid #475569;
    color: #cbd5e1;
}

.dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #cbd5e1;
}

.dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #ef4444;
}

.dark .select2-container--default .select2-search--inline .select2-search__field {
    color: #cbd5e1;
}

.dark .select2-container--default .select2-results__option {
    background-color: #1e293b;
    color: #cbd5e1;
}

.dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #334155;
    color: #ffffff;
}

.dark .select2-dropdown {
    background-color: #1e293b;
    border: 1px solid #334155;
}

.dark .select2-container--default .select2-search--dropdown .select2-search__field {
    background-color: #1e293b;
    border: 1px solid #334155;
    color: #cbd5e1;
}

.dark .select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #334155;
}
</style>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Initialize Select2
document.addEventListener('DOMContentLoaded', function() {
    $('#bulkSelectTemplates').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select templates to delete...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#bulkSelectTemplates').parent(),
        closeOnSelect: false
    });
});

function selectAllTemplates() {
    $('#bulkSelectTemplates option').prop('selected', true);
    $('#bulkSelectTemplates').trigger('change');
}

function clearSelection() {
    $('#bulkSelectTemplates').val(null).trigger('change');
}

async function bulkDeleteTemplates() {
    const selectedIds = $('#bulkSelectTemplates').val();
    
    if (!selectedIds || selectedIds.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Selection',
            text: 'Please select at least one template to delete.',
            confirmButtonColor: '#6b7280'
        });
        return;
    }

    const result = await Swal.fire({
        title: 'Delete Selected Templates?',
        html: `<p class="mb-2">You are about to delete <strong>${selectedIds.length}</strong> template(s) and <strong>all associated images from Cloudflare storage</strong>.</p><p class="text-red-600 dark:text-red-400 font-semibold">This action cannot be undone!</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Yes, Delete ${selectedIds.length} Template(s)`,
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        // Show loading
        Swal.fire({
            title: 'Deleting...',
            html: `Deleting ${selectedIds.length} template(s) and their images from Cloudflare...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let successCount = 0;
        let failCount = 0;
        const errors = [];

        // Delete templates one by one
        for (const id of selectedIds) {
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
                    successCount++;
                } else {
                    failCount++;
                    errors.push(`Template #${id}: ${data.message || 'Failed to delete'}`);
                }
            } catch (error) {
                failCount++;
                errors.push(`Template #${id}: ${error.message || 'Network error'}`);
            }
        }

        // Show results
        if (failCount === 0) {
            await Swal.fire({
                icon: 'success',
                title: 'All Templates Deleted!',
                html: `<p>Successfully deleted <strong>${successCount}</strong> template(s) and all associated images from Cloudflare.</p>`,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'OK'
            });
            window.location.reload();
        } else {
            let errorHtml = `<p>Deleted <strong>${successCount}</strong> template(s) successfully.</p>`;
            if (failCount > 0) {
                errorHtml += `<p class="mt-2 text-red-600">Failed to delete <strong>${failCount}</strong> template(s):</p>`;
                errorHtml += '<ul class="text-left mt-2 text-sm">';
                errors.forEach(error => {
                    errorHtml += `<li>• ${error}</li>`;
                });
                errorHtml += '</ul>';
            }
            
            await Swal.fire({
                icon: failCount === selectedIds.length ? 'error' : 'warning',
                title: failCount === selectedIds.length ? 'Deletion Failed' : 'Partial Success',
                html: errorHtml,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
            
            if (successCount > 0) {
                window.location.reload();
            }
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
            text: 'Please wait while we delete the template and images.',
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
                    text: 'Template and all associated images have been deleted successfully.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK'
                });
                // Reload the page to refresh the list
                window.location.reload();
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
