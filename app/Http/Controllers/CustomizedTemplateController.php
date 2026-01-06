<?php

namespace App\Http\Controllers;

use App\Models\CustomizedTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomizedTemplateController extends Controller
{
    /**
     * Save draft incrementally (without PIN/recipient requirement).
     */
    public function saveDraft(Request $request)
    {
        // Increase limits for image uploads
        ini_set('memory_limit', '512M');
        set_time_limit(300); // 5 minutes
        
        // Log request size for debugging
        $contentLength = $request->header('Content-Length', 0);
        \Log::info('Saving draft template', [
            'user_id' => Auth::id(),
            'content_length' => $contentLength,
            'content_length_mb' => round($contentLength / 1024 / 1024, 2) . 'MB'
        ]);
        
        // Warn if payload is very large
        if ($contentLength > 50 * 1024 * 1024) { // 50MB
            \Log::warning('Very large payload detected', [
                'size_mb' => round($contentLength / 1024 / 1024, 2)
            ]);
        }
        
        try {
            // Validate draft_id separately to handle invalid IDs gracefully
            $draftId = $request->input('draft_id');
            if ($draftId) {
                // Check if draft exists and belongs to user
                $existingDraft = CustomizedTemplate::where('id', $draftId)
                    ->where('user_id', Auth::id())
                    ->where('status', 'draft')
                    ->first();
                
                // If draft doesn't exist or doesn't belong to user, set to null
                if (!$existingDraft) {
                    $draftId = null;
                    \Log::warning('Invalid draft_id provided, will create new draft', ['provided_id' => $request->input('draft_id')]);
                }
            }
            
            $validated = $request->validate([
                'template' => 'nullable|string',
                'page_name' => 'nullable|string|max:255',
                'heading' => 'nullable|string|max:255',
                'subheading' => 'nullable|string|max:255',
                'message' => 'nullable|string',
                'from' => 'nullable|string|max:255',
                'youtube_url' => 'nullable|url|max:500',
                'memory_date' => 'nullable|date',
                'heading_images' => 'nullable|array|max:50',
                'heading_images.*' => 'nullable|string',
                'theme_color' => 'nullable|string|max:7',
                'bg_color' => 'nullable|string|max:7',
                'images' => 'nullable|array|max:50', // Accept flat array or nested structure
                'images.*' => 'nullable|string', // For flat array format
                'images.memories' => 'nullable|array|max:50', // For nested format
                'images.memories.*' => 'nullable|string',
            ]);
            
            // Set validated draft_id (null if invalid)
            $validated['draft_id'] = $draftId;
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Draft validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
        
        // Set default template if not provided
        if (empty($validated['template'])) {
            $validated['template'] = 'default';
        }
        
        // Handle heading images uploads (base64 images)
        if ($request->has('heading_images') && is_array($request->heading_images) && !empty($request->heading_images)) {
            try {
                \Log::info('Processing heading images', [
                    'count' => count($request->heading_images),
                    'draft_id' => $draftId,
                    'user_id' => Auth::id()
                ]);
                
                // Filter out already saved paths (not base64) and remove duplicates
                $newImages = [];
                $existingImages = [];
                $seenUrls = []; // Track URLs to prevent duplicates
                
                foreach ($request->heading_images as $image) {
                    if (is_string($image) && Str::startsWith($image, 'data:image')) {
                        // New base64 image - convert to file
                        $newImages[] = $image;
                    } elseif (is_string($image) && (Str::startsWith($image, '/storage') || Str::startsWith($image, 'http'))) {
                        // Already saved path - keep it, but skip duplicates
                        if (!in_array($image, $seenUrls, true)) {
                            $existingImages[] = $image;
                            $seenUrls[] = $image;
                        }
                    }
                }
                
                \Log::info('Heading images filtered', [
                    'new_base64_count' => count($newImages),
                    'existing_paths_count' => count($existingImages)
                ]);
                
                // Convert new base64 images to file paths
                if (!empty($newImages)) {
                    \Log::info('Converting base64 images to files...');
                    $convertedImages = $this->handleBase64Images($newImages, Auth::id(), 'heading_images');
                    \Log::info('Images converted successfully', ['count' => count($convertedImages)]);
                    $validated['heading_images'] = array_merge($existingImages, $convertedImages);
                } else {
                    $validated['heading_images'] = $existingImages;
                }
                
                \Log::info('Heading images processed', ['total_count' => count($validated['heading_images'])]);
            } catch (\Exception $e) {
                \Log::error('Heading images upload error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                // Keep existing images if update fails
                if (!isset($validated['heading_images'])) {
                    $validated['heading_images'] = [];
                }
            }
        }
        
        // Handle additional images uploads (base64 images)
        // Support both flat array format [url1, url2, ...] and nested format { memories: [...] }
        $imagesInput = $request->input('images');
        $imagesArray = [];
        
        if (is_array($imagesInput)) {
            // Check if it's a flat array or nested structure
            if (isset($imagesInput['memories']) && is_array($imagesInput['memories'])) {
                // Nested format: { memories: [...] }
                $imagesArray = $imagesInput['memories'];
            } else {
                // Flat array format: [url1, url2, ...]
                // Check if keys are numeric (flat array) or if it's actually a nested structure
                $hasNumericKeys = count(array_filter(array_keys($imagesInput), 'is_numeric')) === count($imagesInput);
                if ($hasNumericKeys || empty($imagesInput)) {
                    $imagesArray = $imagesInput;
                } else {
                    // It's a nested structure but not with 'memories' key, extract first array found
                    foreach ($imagesInput as $key => $value) {
                        if (is_array($value)) {
                            $imagesArray = $value;
                            break;
                        }
                    }
                }
            }
        }
        
        \Log::info('Checking for additional images', [
            'has_images' => $request->has('images'),
            'images_input_type' => gettype($imagesInput),
            'images_input_is_array' => is_array($imagesInput),
            'images_array_count' => count($imagesArray),
            'images_sample' => count($imagesArray) > 0 ? substr($imagesArray[0], 0, 50) : 'none',
            'draft_id' => $draftId,
            'user_id' => Auth::id()
        ]);
        
        if (!empty($imagesArray)) {
            try {
                \Log::info('Processing additional images', [
                    'count' => count($imagesArray),
                    'draft_id' => $draftId,
                    'user_id' => Auth::id()
                ]);
                
                // Filter out already saved paths (not base64) and remove duplicates
                $newImages = [];
                $existingImages = [];
                $seenUrls = []; // Track URLs to prevent duplicates
                
                foreach ($imagesArray as $image) {
                    if (is_string($image) && Str::startsWith($image, 'data:image')) {
                        // New base64 image - convert to file
                        $newImages[] = $image;
                    } elseif (is_string($image) && (Str::startsWith($image, '/storage') || Str::startsWith($image, 'http'))) {
                        // Already saved path - keep it, but skip duplicates
                        if (!in_array($image, $seenUrls, true)) {
                            $existingImages[] = $image;
                            $seenUrls[] = $image;
                        }
                    }
                }
                
                \Log::info('Additional images filtered', [
                    'new_base64_count' => count($newImages),
                    'existing_paths_count' => count($existingImages)
                ]);
                
                // Convert new base64 images to file paths
                if (!empty($newImages)) {
                    \Log::info('Converting base64 additional images to files...');
                    $convertedImages = $this->handleBase64Images($newImages, Auth::id(), 'images');
                    \Log::info('Additional images converted successfully', ['count' => count($convertedImages)]);
                    $validated['images'] = ['memories' => array_merge($existingImages, $convertedImages)];
                } else {
                    $validated['images'] = ['memories' => $existingImages];
                }
                
                \Log::info('Additional images processed', ['total_count' => count($validated['images']['memories'])]);
            } catch (\Exception $e) {
                \Log::error('Additional image upload error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                // Keep existing images if update fails
                if (!isset($validated['images'])) {
                    $validated['images'] = [];
                }
            }
        } else {
            \Log::info('No additional images to process', [
                'has_images' => $request->has('images'),
                'images_input' => $imagesInput,
                'images_array_count' => count($imagesArray)
            ]);
        }
        
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'draft';
        
        // If draft_id exists and is valid, update it; otherwise create new
        $draftId = $validated['draft_id'] ?? null;
        if (!empty($draftId)) {
            $customizedTemplate = CustomizedTemplate::where('id', $draftId)
                ->where('user_id', Auth::id())
                ->where('status', 'draft')
                ->first();
            
            if ($customizedTemplate) {
                unset($validated['draft_id']);
                
                // Images are already processed above - they contain both existing paths and newly converted paths
                // The frontend sends the complete list, so we just use what's in $validated
                // If images weren't provided in request OR if empty arrays were sent, keep existing ones
                if (!isset($validated['heading_images']) || (is_array($validated['heading_images']) && empty($validated['heading_images']))) {
                    if ($customizedTemplate->heading_images && is_array($customizedTemplate->heading_images) && count($customizedTemplate->heading_images) > 0) {
                        $validated['heading_images'] = $customizedTemplate->heading_images;
                        \Log::info('Preserving existing heading_images', ['count' => count($validated['heading_images'])]);
                    }
                }
                if (!isset($validated['images']) || (is_array($validated['images']) && empty($validated['images']))) {
                    if ($customizedTemplate->images && is_array($customizedTemplate->images) && isset($customizedTemplate->images['memories']) && count($customizedTemplate->images['memories']) > 0) {
                        $validated['images'] = $customizedTemplate->images;
                        \Log::info('Preserving existing images', ['count' => count($validated['images']['memories'])]);
                    }
                }
                
                // Generate slug if page_name changed and slug doesn't exist
                if (!empty($validated['page_name']) && empty($customizedTemplate->slug)) {
                    $validated['slug'] = CustomizedTemplate::generateSlug($validated['page_name'], Auth::id(), $validated['template']);
                }
                
                $customizedTemplate->update($validated);
                \Log::info('Draft updated', [
                    'template_id' => $customizedTemplate->id,
                    'heading_images_count' => is_array($validated['heading_images'] ?? null) ? count($validated['heading_images']) : 0,
                    'images_count' => isset($validated['images']['memories']) ? count($validated['images']['memories']) : 0,
                ]);
            } else {
                unset($validated['draft_id']);
                if (!empty($validated['page_name'])) {
                    $validated['slug'] = CustomizedTemplate::generateSlug($validated['page_name'], Auth::id(), $validated['template']);
                }
                $customizedTemplate = CustomizedTemplate::create($validated);
                \Log::info('Draft created (fallback)', ['template_id' => $customizedTemplate->id]);
            }
        } else {
            // Before creating new draft, check if there's an existing draft for this user/page_name
            // This prevents creating duplicates when draft_id is not provided
            $existingDraft = null;
            if (!empty($validated['page_name'])) {
                // Try to find existing draft with same page_name and user
                $existingDraft = CustomizedTemplate::where('user_id', Auth::id())
                    ->where('page_name', $validated['page_name'])
                    ->where('status', 'draft')
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                if ($existingDraft) {
                    \Log::info('Found existing draft, updating instead of creating new', [
                        'existing_id' => $existingDraft->id,
                        'page_name' => $validated['page_name']
                    ]);
                    
                    // Update existing draft instead of creating new
                    unset($validated['draft_id']);
                    
                    // Merge images if provided
                    if (isset($validated['heading_images']) && is_array($validated['heading_images'])) {
                        // Use new images
                    } elseif ($existingDraft->heading_images) {
                        $validated['heading_images'] = $existingDraft->heading_images;
                    }
                    
                    if (isset($validated['images']) && is_array($validated['images'])) {
                        // Use new images
                    } elseif ($existingDraft->images) {
                        $validated['images'] = $existingDraft->images;
                    }
                    
                    $existingDraft->update($validated);
                    $customizedTemplate = $existingDraft;
                    
                    \Log::info('Draft updated (found existing)', [
                        'template_id' => $customizedTemplate->id,
                        'heading_images_count' => is_array($validated['heading_images'] ?? null) ? count($validated['heading_images']) : 0,
                        'images_count' => isset($validated['images']['memories']) ? count($validated['images']['memories']) : 0,
                    ]);
                }
            }
            
            // Only create new draft if no existing draft was found
            if (!$existingDraft) {
                // Create new draft - allow creation even without page_name if images exist
                $hasImages = (!empty($validated['heading_images']) && is_array($validated['heading_images']) && count($validated['heading_images']) > 0) ||
                             (!empty($validated['images']['memories']) && is_array($validated['images']['memories']) && count($validated['images']['memories']) > 0);
                
                // If no page_name but we have images, use a temporary name
                if (empty($validated['page_name']) && $hasImages) {
                    $validated['page_name'] = 'draft-' . Auth::id() . '-' . time();
                    \Log::info('Creating draft with temporary page_name for images', ['user_id' => Auth::id()]);
                }
                
                if (!empty($validated['page_name'])) {
                    $validated['slug'] = CustomizedTemplate::generateSlug($validated['page_name'], Auth::id(), $validated['template']);
                    
                    // Double-check if a draft with this slug already exists (globally unique constraint)
                    $slugDraft = CustomizedTemplate::where('slug', $validated['slug'])
                        ->where('status', 'draft')
                        ->first();
                    
                    if ($slugDraft) {
                        // Update existing draft instead of creating new
                        \Log::info('Found existing draft by slug, updating instead of creating', [
                            'existing_id' => $slugDraft->id,
                            'slug' => $validated['slug']
                        ]);
                        
                        // Merge images if provided
                        if (isset($validated['heading_images']) && is_array($validated['heading_images']) && count($validated['heading_images']) > 0) {
                            // Use new images
                        } elseif ($slugDraft->heading_images) {
                            $validated['heading_images'] = $slugDraft->heading_images;
                        }
                        
                        if (isset($validated['images']) && is_array($validated['images']) && count($validated['images']) > 0) {
                            // Use new images
                        } elseif ($slugDraft->images) {
                            $validated['images'] = $slugDraft->images;
                        }
                        
                        $slugDraft->update($validated);
                        $customizedTemplate = $slugDraft;
                        
                        \Log::info('Draft updated (found by slug)', [
                            'template_id' => $customizedTemplate->id,
                            'heading_images_count' => is_array($validated['heading_images'] ?? null) ? count($validated['heading_images']) : 0,
                            'images_count' => isset($validated['images']['memories']) ? count($validated['images']['memories']) : 0,
                        ]);
                    } else {
                        // No existing draft with this slug, safe to create
                        try {
                $customizedTemplate = CustomizedTemplate::create($validated);
                \Log::info('Draft created (new)', [
                    'template_id' => $customizedTemplate->id,
                    'has_images' => $hasImages,
                    'heading_images_count' => is_array($validated['heading_images'] ?? null) ? count($validated['heading_images']) : 0,
                    'images_count' => isset($validated['images']['memories']) ? count($validated['images']['memories']) : 0,
                ]);
                        } catch (\Illuminate\Database\QueryException $e) {
                            // Handle duplicate slug error - try to find and update existing draft
                            if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'slug_unique')) {
                                \Log::warning('Duplicate slug error, attempting to find and update existing draft', ['slug' => $validated['slug']]);
                                $existingBySlug = CustomizedTemplate::where('slug', $validated['slug'])->first();
                                if ($existingBySlug) {
                                    // Merge images
                                    if (isset($validated['heading_images']) && is_array($validated['heading_images']) && count($validated['heading_images']) > 0) {
                                        // Use new images
                                    } elseif ($existingBySlug->heading_images) {
                                        $validated['heading_images'] = $existingBySlug->heading_images;
                                    }
                                    
                                    if (isset($validated['images']) && is_array($validated['images']) && count($validated['images']) > 0) {
                                        // Use new images
                                    } elseif ($existingBySlug->images) {
                                        $validated['images'] = $existingBySlug->images;
                                    }
                                    
                                    $existingBySlug->update($validated);
                                    $customizedTemplate = $existingBySlug;
                                    \Log::info('Draft updated after duplicate slug error', ['template_id' => $customizedTemplate->id]);
                                } else {
                                    throw $e; // Re-throw if we can't find the existing draft
                                }
                            } else {
                                throw $e; // Re-throw if it's a different error
                            }
                        }
                    }
                } else {
                    // No page_name, create without slug (will be generated in model boot)
                    $customizedTemplate = CustomizedTemplate::create($validated);
                    \Log::info('Draft created (new, no page_name)', [
                        'template_id' => $customizedTemplate->id,
                        'has_images' => $hasImages,
                    ]);
                }
            }
        }
        
        \Log::info('✅ Draft save completed successfully', [
            'draft_id' => $customizedTemplate->id,
            'heading_images_count' => is_array($customizedTemplate->heading_images ?? null) ? count($customizedTemplate->heading_images) : 0,
            'images_count' => isset($customizedTemplate->images['memories']) ? count($customizedTemplate->images['memories']) : 0,
            'heading_images' => $customizedTemplate->heading_images ?? [],
        ]);
        
        return response()->json([
            'success' => true,
            'draft_id' => $customizedTemplate->id,
            'slug' => $customizedTemplate->slug,
            'data' => $customizedTemplate,
        ]);
    }

    /**
     * Store a newly created customized template (final save with PIN).
     */
    public function store(Request $request)
    {
        \Log::info('Template store request received', [
            'user_id' => Auth::id(),
            'has_template' => $request->has('template'),
            'has_recipient_name' => $request->has('recipient_name'),
            'has_pin' => $request->has('pin'),
        ]);
        
        // Get draft_id early to use in validation
        $draftId = $request->input('draft_id');
        
        try {
        $validated = $request->validate([
            'template' => 'nullable|string',
            'page_name' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'from' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:500',
            'memory_date' => 'nullable|date',
            'heading_images' => 'nullable|array|max:50',
            'heading_images.*' => 'nullable|string',
            'section1_title' => 'nullable|string|max:255',
            'section1_content' => 'nullable|string',
            'section2_title' => 'nullable|string|max:255',
            'section2_content' => 'nullable|string',
            'section3_title' => 'nullable|string|max:255',
            'section3_content' => 'nullable|string',
            'section4_title' => 'nullable|string|max:255',
            'section4_content' => 'nullable|string',
            'section5_title' => 'nullable|string|max:255',
            'section5_content' => 'nullable|string',
            'theme_color' => 'nullable|string|max:7',
            'bg_color' => 'nullable|string|max:7',
            'bg_style' => 'nullable|string|in:gradient,solid,image',
            'images' => 'nullable|array',
            'images.memories' => 'nullable|array|max:50',
            'images.memories.*' => 'nullable|string',
            'status' => 'nullable|string|in:draft,published,archived',
            'slug' => 'nullable|string|max:255',
            'recipient_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customized_templates', 'recipient_name')
                    ->where('user_id', Auth::id())
                    ->ignore($draftId),
            ],
            'pin' => 'required|string|size:5|regex:/^[0-9]{5}$/',
        ]);

            \Log::info('Validation passed', ['recipient_name' => $validated['recipient_name'] ?? 'N/A']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Store method error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
            }
            
        // Set default template if not provided
        if (empty($validated['template'])) {
            $validated['template'] = 'default';
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'draft'; // Keep as draft even after PIN
        
        // Check if draft_id exists - update existing draft instead of creating new
        $existingDraft = null;
        if ($draftId) {
            $existingDraft = CustomizedTemplate::where('id', $draftId)
                ->where('user_id', Auth::id())
                ->where('status', 'draft')
                ->first();
        }

        // Handle heading images uploads (base64 images)
        if ($request->has('heading_images') && is_array($request->heading_images) && !empty($request->heading_images)) {
            try {
                $validated['heading_images'] = $this->handleBase64Images($request->heading_images, Auth::id(), 'heading_images');
            } catch (\Exception $e) {
                \Log::error('Heading images upload error: ' . $e->getMessage());
                // Preserve existing images if available
                $validated['heading_images'] = $existingDraft && $existingDraft->heading_images ? $existingDraft->heading_images : [];
            }
        } else {
            // Preserve existing images from draft if not in request
            $validated['heading_images'] = $existingDraft && $existingDraft->heading_images ? $existingDraft->heading_images : [];
        }

        // Handle additional images uploads (base64 images)
        if ($request->has('images') && is_array($request->images) && !empty($request->images)) {
            try {
                // Store additional images in images array
                $validated['images'] = ['memories' => $this->handleBase64Images($request->images, Auth::id(), 'images')];
            } catch (\Exception $e) {
                \Log::error('Image upload error: ' . $e->getMessage());
                // Preserve existing images if available
                $validated['images'] = $existingDraft && $existingDraft->images ? $existingDraft->images : [];
            }
        } else {
            // Preserve existing images from draft if not in request
            $validated['images'] = $existingDraft && $existingDraft->images ? $existingDraft->images : [];
        }
        
        if ($existingDraft) {
            // Update existing draft with PIN and recipient
            $existingDraft->update($validated);
            \Log::info('Updating existing draft with PIN', [
                'template_id' => $existingDraft->id,
                'recipient_name' => $validated['recipient_name'] ?? 'N/A',
                'heading_images_count' => is_array($validated['heading_images']) ? count($validated['heading_images']) : 0,
            ]);
            $customizedTemplate = $existingDraft;
        } else {
            // Draft not found or no draft_id, create new
            if (!empty($validated['page_name'])) {
                $validated['slug'] = CustomizedTemplate::generateSlug($validated['page_name'], Auth::id(), $validated['template']);
            }
            $customizedTemplate = CustomizedTemplate::create($validated);
            \Log::info('Creating new customized template', [
                'template_id' => $customizedTemplate->id,
            'user_id' => $validated['user_id'],
            'recipient_name' => $validated['recipient_name'] ?? 'N/A',
            'status' => $validated['status'],
        ]);
        }

        \Log::info('Template created successfully', [
            'template_id' => $customizedTemplate->id,
            'slug' => $customizedTemplate->slug,
            'page_name' => $customizedTemplate->page_name,
            'status' => $customizedTemplate->status,
        ]);

        // Generate URL - use the slug directly
        $url = url('/' . $customizedTemplate->slug);

        return response()->json([
            'success' => true,
            'message' => 'Your memory has been created successfully!',
            'url' => $url,
            'slug' => $customizedTemplate->slug,
            'data' => $customizedTemplate,
        ]);
    }

    /**
     * Update an existing customized template.
     */
    public function update(Request $request, $id)
    {
        $customizedTemplate = CustomizedTemplate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'from' => 'nullable|string|max:255',
            'section1_title' => 'nullable|string|max:255',
            'section1_content' => 'nullable|string',
            'section2_title' => 'nullable|string|max:255',
            'section2_content' => 'nullable|string',
            'section3_title' => 'nullable|string|max:255',
            'section3_content' => 'nullable|string',
            'section4_title' => 'nullable|string|max:255',
            'section4_content' => 'nullable|string',
            'section5_title' => 'nullable|string|max:255',
            'section5_content' => 'nullable|string',
            'theme_color' => 'nullable|string|max:7',
            'bg_color' => 'nullable|string|max:7',
            'bg_style' => 'nullable|string|in:gradient,solid,image',
            'images' => 'nullable|array',
            'status' => 'nullable|string|in:draft,published,archived',
        ]);

        // Handle image uploads if provided
        if ($request->has('images') && is_array($request->images)) {
            $validated['images'] = $this->handleImageUploads($request->images, Auth::id(), $customizedTemplate->images);
        }

        $customizedTemplate->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully!',
            'data' => $customizedTemplate,
        ]);
    }

    /**
     * Get a customized template by slug and display as website.
     */
    public function show(Request $request, $slug, $templates = null)
    {
        \Log::info('Accessing template with slug', ['slug' => $slug]);
        
        $customizedTemplate = CustomizedTemplate::where('slug', $slug)
            ->where('status', 'published') // Only allow published templates
            ->with('user')
            ->first();
            
        if (!$customizedTemplate) {
            \Log::error('Template not found or not published', [
                'slug' => $slug,
                'all_slugs' => CustomizedTemplate::pluck('slug')->toArray()
            ]);
            abort(404, 'Memory page not found');
        }

        \Log::info('Template found', [
            'id' => $customizedTemplate->id,
            'slug' => $customizedTemplate->slug,
            'status' => $customizedTemplate->status,
            'recipient_name' => $customizedTemplate->recipient_name,
        ]);

        // Check if PIN is verified in session
        $pinVerified = $request->session()->get("template_pin_verified_{$slug}", false);
        
        \Log::info('PIN verification status', [
            'slug' => $slug,
            'pin_verified' => $pinVerified,
        ]);
        
        if (!$pinVerified) {
            // Show PIN entry page
            \Log::info('Showing PIN verification page');
            return view('templates.pin-verification', [
                'slug' => $slug,
                'recipient_name' => $customizedTemplate->recipient_name,
            ]);
        }

        \Log::info('PIN verified, showing published template');

        // Directly return the published view with the customized template
        // We don't need template configs since we're using a custom published view
        return view('templates.published', [
            'customizedTemplate' => $customizedTemplate,
        ]);
    }

    /**
     * Verify PIN and allow access to template.
     */
    public function verifyPin(Request $request, $slug)
    {
        $request->validate([
            'pin' => 'required|string|size:5|regex:/^[0-9]{5}$/',
        ]);

        $customizedTemplate = CustomizedTemplate::where('slug', $slug)
            ->where('status', 'published') // Only allow published templates
            ->firstOrFail();

        if ($customizedTemplate->pin === $request->pin) {
            // Store PIN verification in session
            $request->session()->put("template_pin_verified_{$slug}", true);
            
            // Redirect to gift box animation page
            return redirect()->route('templates.gift-box', $slug);
        }

        return back()->with('error', 'Invalid PIN. Please try again.');
    }

    /**
     * Show gift box animation page after PIN verification.
     */
    public function showGiftBox(Request $request, $slug)
    {
        $customizedTemplate = CustomizedTemplate::where('slug', $slug)
            ->where('status', 'published') // Only allow published templates
            ->firstOrFail();
        
        // Check if PIN is verified
        $pinVerified = $request->session()->get("template_pin_verified_{$slug}", false);
        
        if (!$pinVerified) {
            // If PIN not verified, redirect to PIN entry
            return redirect()->route('templates.show', $slug);
        }
        
        return view('templates.gift-box', [
            'slug' => $slug,
            'recipient_name' => $customizedTemplate->recipient_name,
            'theme_color' => $customizedTemplate->theme_color ?? '#ff6b6b',
        ]);
    }

    /**
     * Ensure section defaults exist.
     */
    private function ensureSectionDefaults($templateData)
    {
        $defaultSections = [
            'section1_title' => 'Our Love',
            'section1_content' => 'Every moment with you feels like a dream. Your love fills my heart with joy and happiness.',
            'section2_title' => 'Our First Day',
            'section2_content' => 'The day we met changed everything. I knew from that moment that you were special.',
            'section3_title' => 'Our Journey',
            'section3_content' => 'Together we\'ve created countless beautiful memories. Each day with you is a new adventure.',
            'section4_title' => 'Our Promise',
            'section4_content' => 'I promise to stand by you, support you, and love you through all of life\'s adventures.',
            'section5_title' => 'Forever',
            'section5_content' => 'Today, tomorrow, and forever - I choose you. You are my everything.'
        ];
        
        if (!isset($templateData['defaults'])) {
            $templateData['defaults'] = [];
        }
        
        $templateData['defaults'] = array_merge($defaultSections, $templateData['defaults']);
        return $templateData;
    }

    /**
     * Get template configurations.
     * This should match the templates array from routes/web.php
     */
    private function getTemplateConfigs()
    {
        // Extract templates from routes file
        // In production, consider moving this to config/templates.php
        $routesFile = base_path('routes/web.php');
        $content = file_get_contents($routesFile);
        
        // Extract the templates array using regex
        if (preg_match('/\$templates\s*=\s*\[(.*?)\];/s', $content, $matches)) {
            // This is complex - for now return empty and let route pass it
            return [];
        }
        
        return [];
    }

    /**
     * Get a single customized template by ID (for API).
     */
    public function getTemplate($id)
    {
        $template = CustomizedTemplate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Ensure heading_images is always an array (handle JSON string case)
        $headingImages = $template->heading_images;
        if (is_string($headingImages)) {
            $headingImages = json_decode($headingImages, true) ?? [];
        }
        if (!is_array($headingImages)) {
            $headingImages = [];
        }
        // Set the modified array back to the model
        $template->setAttribute('heading_images', $headingImages);

        // Ensure images.memories is always an array
        $images = $template->images;
        if (is_string($images)) {
            $images = json_decode($images, true) ?? [];
        }
        if (!is_array($images)) {
            $images = [];
        }
        if (!isset($images['memories']) || !is_array($images['memories'])) {
            $images['memories'] = [];
        }
        // Set the modified array back to the model
        $template->setAttribute('images', $images);

        \Log::info('📥 getTemplate called', [
            'template_id' => $template->id,
            'heading_images_count' => count($headingImages),
            'heading_images' => $headingImages,
            'images_count' => count($images['memories'] ?? []),
        ]);

        return response()->json([
            'success' => true,
            'data' => $template,
        ]);
    }

    /**
     * Get all customized templates for the authenticated user.
     */
    public function index()
    {
        $templates = CustomizedTemplate::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $templates,
        ]);
    }

    /**
     * Delete a customized template.
     */
    public function destroy($id)
    {
        $customizedTemplate = CustomizedTemplate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete associated images
        if ($customizedTemplate->images) {
            $this->deleteImages($customizedTemplate->images);
        }

        $customizedTemplate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully!',
        ]);
    }

    /**
     * Handle image uploads and return paths.
     */
    private function handleImageUploads(array $images, int $userId, ?array $existingImages = null): array
    {
        $uploadedImages = $existingImages ?? [];

        // Handle hero image
        if (isset($images['hero']) && is_string($images['hero']) && Str::startsWith($images['hero'], 'data:image')) {
            $uploadedImages['hero'] = $this->saveBase64Image($images['hero'], $userId, 'hero');
        } elseif (isset($images['hero']) && is_string($images['hero'])) {
            $uploadedImages['hero'] = $images['hero']; // Already a path
        }

        // Handle section2 image
        if (isset($images['section2']) && is_string($images['section2']) && Str::startsWith($images['section2'], 'data:image')) {
            $uploadedImages['section2'] = $this->saveBase64Image($images['section2'], $userId, 'section2');
        } elseif (isset($images['section2']) && is_string($images['section2'])) {
            $uploadedImages['section2'] = $images['section2'];
        }

        // Handle section3 images
        if (isset($images['section3']) && is_array($images['section3'])) {
            $uploadedImages['section3'] = $uploadedImages['section3'] ?? [];
            foreach (['image1', 'image2', 'image3'] as $key) {
                if (isset($images['section3'][$key])) {
                    if (is_string($images['section3'][$key]) && Str::startsWith($images['section3'][$key], 'data:image')) {
                        $uploadedImages['section3'][$key] = $this->saveBase64Image($images['section3'][$key], $userId, "section3-{$key}");
                    } elseif (is_string($images['section3'][$key])) {
                        $uploadedImages['section3'][$key] = $images['section3'][$key];
                    }
                }
            }
        }

        // Handle memories array
        if (isset($images['memories']) && is_array($images['memories'])) {
            $uploadedImages['memories'] = [];
            foreach ($images['memories'] as $index => $memory) {
                if (is_string($memory) && Str::startsWith($memory, 'data:image')) {
                    $uploadedImages['memories'][] = $this->saveBase64Image($memory, $userId, "memory-{$index}");
                } elseif (is_string($memory)) {
                    $uploadedImages['memories'][] = $memory;
                }
            }
        }

        return $uploadedImages;
    }

    /**
     * Cached S3 client instance for reuse across multiple uploads
     */
    private static $s3Client = null;
    
    /**
     * Get or create a reusable S3 client
     */
    private function getS3Client(): ?\Aws\S3\S3Client
    {
        if (self::$s3Client === null && class_exists('\Aws\S3\S3Client')) {
            try {
                self::$s3Client = new \Aws\S3\S3Client([
                    'version' => 'latest',
                    'region' => config('filesystems.disks.cloudflare.region', 'auto'),
                    'endpoint' => config('filesystems.disks.cloudflare.endpoint'),
                    'credentials' => [
                        'key' => config('filesystems.disks.cloudflare.key'),
                        'secret' => config('filesystems.disks.cloudflare.secret'),
                    ],
                    'use_path_style_endpoint' => config('filesystems.disks.cloudflare.use_path_style_endpoint', false),
                    // Add connection pooling and timeout settings
                    'http' => [
                        'timeout' => 30,
                        'connect_timeout' => 10,
                    ],
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create S3 client', ['error' => $e->getMessage()]);
                self::$s3Client = null;
            }
        }
        return self::$s3Client;
    }
    
    /**
     * Handle array of base64 images.
     */
    private function handleBase64Images(array $images, int $userId, string $type): array
    {
        // Enforce maximum 50 images limit
        if (count($images) > 50) {
            \Log::warning('Image limit exceeded', ['count' => count($images), 'type' => $type]);
            throw new \Exception('Maximum 50 images allowed. Please remove some images.');
        }
        
        // Increase memory limit temporarily for large uploads
        $originalMemoryLimit = ini_get('memory_limit');
        ini_set('memory_limit', '512M');
        
        // Set max execution time for long uploads
        $originalMaxExecution = ini_get('max_execution_time');
        set_time_limit(300); // 5 minutes
        
        $uploadedImages = [];
        $seenBase64 = []; // Track base64 images to prevent duplicates
        $seenUrls = []; // Track URLs to prevent duplicates
        $base64Count = 0;
        
        // Count base64 images first
        foreach ($images as $image) {
            if (is_string($image) && Str::startsWith($image, 'data:image')) {
                $base64Count++;
            }
        }
        
        \Log::info('Starting image processing', [
            'type' => $type,
            'total_images' => count($images),
            'base64_count' => $base64Count,
            'memory_limit' => ini_get('memory_limit')
        ]);
        
        try {
            foreach ($images as $index => $image) {
                if (is_string($image) && Str::startsWith($image, 'data:image')) {
                    // Create a hash of the base64 content to detect duplicates
                    $base64Hash = md5($image);
                    
                    // Skip if we've already processed this exact base64 image
                    if (isset($seenBase64[$base64Hash])) {
                        \Log::info('Skipping duplicate base64 image', [
                            'type' => $type,
                            'index' => $index,
                            'hash' => substr($base64Hash, 0, 8)
                        ]);
                        $uploadedImages[] = $seenBase64[$base64Hash]; // Use the already uploaded URL
                        continue;
                    }
                    
                    $uploadedUrl = $this->saveBase64Image($image, $userId, "{$type}-{$index}");
                    if (!empty($uploadedUrl)) {
                        $uploadedImages[] = $uploadedUrl;
                        $seenBase64[$base64Hash] = $uploadedUrl; // Store for duplicate detection
                    }
                    
                    // Free memory after processing each base64 image
                    unset($image);
                    
                } elseif (is_string($image)) {
                    // Skip duplicate URLs
                    if (in_array($image, $seenUrls, true)) {
                        \Log::info('Skipping duplicate URL', [
                            'type' => $type,
                            'index' => $index,
                            'url' => substr($image, 0, 50) . '...'
                        ]);
                        continue;
                    }
                    
                    $uploadedImages[] = $image; // Already a path
                    $seenUrls[] = $image;
                }
            }
        } finally {
            // Restore original settings
            ini_set('memory_limit', $originalMemoryLimit);
            if ($originalMaxExecution !== false) {
                set_time_limit((int)$originalMaxExecution);
            }
        }

        \Log::info('Images processed with duplicate detection', [
            'type' => $type,
            'input_count' => count($images),
            'output_count' => count($uploadedImages),
            'duplicates_skipped' => count($images) - count($uploadedImages)
        ]);

        return $uploadedImages;
    }

    /**
    /**
     * Get MIME type from file extension (fallback when fileinfo extension is not available)
     */
    private function getMimeTypeFromExtension(string $extension): string
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'bmp' => 'image/bmp',
            'ico' => 'image/x-icon',
        ];
        
        $extension = strtolower($extension);
        return $mimeTypes[$extension] ?? 'image/jpeg';
    }

    private function saveBase64Image(string $base64Image, int $userId, string $prefix): string
    {
        // Extract image data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            $extension = strtolower($matches[1]);
            
            // Normalize JPEG extensions (jpeg -> jpg for consistency)
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }
            
            $imageData = base64_decode(substr($base64Image, strpos($base64Image, ',') + 1));
            
            if ($imageData === false) {
                \Log::error('Failed to decode base64 image');
                return '';
            }
            
            // Free the base64 string from memory immediately
            unset($base64Image);
            
            $filename = $prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
            $path = "templates/{$userId}/{$filename}";
            
            // Determine which disk to use (Cloudflare R2 if configured, otherwise public)
            $disk = env('CLOUDFLARE_R2_BUCKET') ? 'cloudflare' : 'public';
            
            // For Cloudflare R2, no need to create directories (S3-compatible)
            if ($disk === 'cloudflare') {
                // Use cached S3 client to avoid creating new connections for each image
                $s3Client = $this->getS3Client();
                
                if ($s3Client) {
                    try {
                        $bucket = config('filesystems.disks.cloudflare.bucket');
                        $mimeType = $this->getMimeTypeFromExtension($extension);
                        
                        $putObjectParams = [
                            'Bucket' => $bucket,
                            'Key' => $path,
                            'Body' => $imageData,
                            'ContentType' => $mimeType,
                        ];
                        
                        // Cloudflare R2 may not support ACL, so make it optional
                        // Public access is typically configured at bucket level in R2
                        if (env('CLOUDFLARE_R2_USE_ACL', false)) {
                            $putObjectParams['ACL'] = 'public-read';
                        }
                        
                        $result = $s3Client->putObject($putObjectParams);
                        
                        $saved = isset($result['ETag']);
                        
                        // Free image data from memory
                        unset($imageData);
                    } catch (\Exception $e) {
                        \Log::error('Failed to upload to Cloudflare R2 using S3 client', [
                            'error' => $e->getMessage(),
                            'path' => $path
                        ]);
                        $saved = false;
                    }
                } else {
                    $saved = false;
                    \Log::warning('S3 client not available, will use fallback method');
                }
                
                // Fallback: Use Storage facade with temporary file (helps with MIME detection)
                if (!$saved) {
                    try {
                        // Create a temporary file with correct extension to help MIME detection
                        $tempFile = sys_get_temp_dir() . '/' . uniqid('upload_') . '_' . $filename;
                        file_put_contents($tempFile, $imageData);
                        
                        // Use putFileAs which may handle MIME type better
                        $savedPath = Storage::disk('cloudflare')->putFileAs(
                            "templates/{$userId}",
                            $tempFile,
                            $filename,
                            ['visibility' => 'public']
                        );
                        
                        // Clean up temp file
                        if (file_exists($tempFile)) {
                            unlink($tempFile);
                        }
                        
                        $saved = !empty($savedPath);
                    } catch (\Exception $e) {
                        if (isset($tempFile) && file_exists($tempFile)) {
                            unlink($tempFile);
                        }
                        \Log::error('Fallback upload failed', [
                            'error' => $e->getMessage(),
                            'path' => $path
                        ]);
                        $saved = false;
                    }
                }
                
                if ($saved) {
                    // Verify file was actually saved
                    $fileExists = Storage::disk('cloudflare')->exists($path);
                    
                    if (!$fileExists) {
                        \Log::error('File was not found after saving to Cloudflare R2', ['path' => $path]);
                        return '';
                    }
                    
                    // Get the public URL from Cloudflare R2
                    // Use the configured R2 URL from .env, or generate from endpoint
                    $r2Url = env('CLOUDFLARE_R2_URL');
                    if ($r2Url) {
                        // Ensure URL doesn't have trailing slash
                        $r2Url = rtrim($r2Url, '/');
                        // URL encode the path segments (like the example: WhatsApp%20Image...)
                        // Split path by / and encode each segment
                        $pathSegments = explode('/', $path);
                        $encodedSegments = array_map('rawurlencode', $pathSegments);
                        $encodedPath = implode('/', $encodedSegments);
                        // Build full URL: R2_URL + / + encoded_path
                        $url = $r2Url . '/' . $encodedPath;
                    } else {
                        // Fallback to Storage::url() method
                        $url = Storage::disk('cloudflare')->url($path);
                    }
                    
                    // Test if URL is accessible (optional check)
                    $fileSize = Storage::disk('cloudflare')->size($path);
                    
                    \Log::info('Image saved to Cloudflare R2 successfully', [
                        'path' => $path,
                        'encoded_path' => $encodedPath ?? $path,
                        'url' => $url,
                        'r2_url_config' => env('CLOUDFLARE_R2_URL'),
                        'file_exists' => $fileExists,
                        'file_size' => $fileSize
                    ]);
                    return $url;
                } else {
                    \Log::error('Failed to save image to Cloudflare R2', ['path' => $path]);
                    return '';
                }
            } else {
                // Fallback to local storage
            $directory = "templates/{$userId}";
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $saved = Storage::disk('public')->put($path, $imageData);
            
            if ($saved) {
                $url = Storage::url($path);
                    \Log::info('Image saved to local storage successfully', ['path' => $path, 'url' => $url]);
                return $url;
            } else {
                    \Log::error('Failed to save image to local storage', ['path' => $path]);
                return '';
                }
            }
        }

        \Log::warning('Invalid base64 image format');
        return $base64Image; // Return as-is if not valid base64
    }

    /**
     * Delete images from storage.
     */
    private function deleteImages(array $images): void
    {
        foreach ($images as $key => $value) {
            if (is_string($value)) {
                $this->deleteImageFile($value);
            } elseif (is_array($value)) {
                foreach ($value as $item) {
                    if (is_string($item)) {
                        $this->deleteImageFile($item);
                    }
                }
            }
        }
    }

    /**
     * Delete a single image file (supports both Cloudflare R2 and local storage).
     */
    private function deleteImageFile(string $path): void
    {
        // Check if it's a Cloudflare R2 URL
        $cloudflareUrl = env('CLOUDFLARE_R2_URL');
        if ($cloudflareUrl && Str::startsWith($path, $cloudflareUrl)) {
            // Extract the path from the full URL
            $relativePath = Str::after($path, $cloudflareUrl . '/');
            Storage::disk('cloudflare')->delete($relativePath);
            \Log::info('Deleted image from Cloudflare R2', ['path' => $relativePath]);
        } elseif (Str::startsWith($path, '/storage/')) {
            // Local storage path
            $relativePath = Str::after($path, '/storage/');
            Storage::disk('public')->delete($relativePath);
            \Log::info('Deleted image from local storage', ['path' => $relativePath]);
        } elseif (Str::startsWith($path, 'http')) {
            // Try to extract path from any HTTP URL
            $parsedUrl = parse_url($path);
            if (isset($parsedUrl['path'])) {
                $relativePath = ltrim($parsedUrl['path'], '/');
                // Try Cloudflare R2 first if configured
                if (env('CLOUDFLARE_R2_BUCKET')) {
                    Storage::disk('cloudflare')->delete($relativePath);
                } else {
                    // Fallback to local storage
                    Storage::disk('public')->delete($relativePath);
                }
            }
        }
    }

    /**
     * Check if a recipient name is already taken (for the current user).
     */
    public function checkRecipientName(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'draft_id' => 'nullable|integer', // Exclude current draft from check
        ]);

        $recipientName = $request->input('recipient_name');
        $draftId = $request->input('draft_id');
        
        if (empty($recipientName) || trim($recipientName) === '') {
            return response()->json([
                'available' => false,
                'message' => 'Recipient name cannot be empty',
            ]);
        }

        // Check if recipient name exists for this user (excluding current draft if provided)
        $query = CustomizedTemplate::where('recipient_name', $recipientName)
            ->where('user_id', Auth::id());
        
        if ($draftId) {
            // Exclude current draft from check
            $query->where('id', '!=', $draftId);
            
            // Also check if the current draft already has this recipient name (allow it)
            $currentDraft = CustomizedTemplate::find($draftId);
            if ($currentDraft && $currentDraft->recipient_name === $recipientName && $currentDraft->user_id === Auth::id()) {
                // User's own draft with this recipient name - allow it
                return response()->json([
                    'available' => true,
                    'message' => 'Recipient name is available',
                ]);
            }
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This recipient name has already been taken. Please choose a different name.' : 'Recipient name is available',
        ]);
    }

    /**
     * Check if a page name is already taken (globally, across all users).
     */
    public function checkPageName(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'draft_id' => 'nullable|integer', // Exclude current draft from check
        ]);

        $pageName = $request->input('page_name');
        $draftId = $request->input('draft_id');
        
        if (empty($pageName) || trim($pageName) === '') {
            return response()->json([
                'available' => false,
                'message' => 'Page name cannot be empty',
            ]);
        }

        // Generate slug from page name (check globally, not per user)
        $baseSlug = Str::slug($pageName ?: 'untitled-template');
        
        // Check if slug exists globally (excluding current draft if provided)
        $query = CustomizedTemplate::where('slug', $baseSlug);
        
        if ($draftId) {
            // Exclude current draft from check
            $query->where('id', '!=', $draftId);
            
            // Also check if the current draft already has this slug (allow it)
            $currentDraft = CustomizedTemplate::find($draftId);
            if ($currentDraft && $currentDraft->slug === $baseSlug && $currentDraft->user_id === Auth::id()) {
                // User's own draft with this slug - allow it
                return response()->json([
                    'available' => true,
                    'slug' => $baseSlug,
                    'message' => 'Page name is available',
                ]);
            }
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'available' => !$exists,
            'slug' => $baseSlug,
            'message' => $exists ? 'This page name is already taken. Please choose a different name.' : 'Page name is available',
        ]);
    }

    /**
     * Delete a single image via API (for frontend use).
     * Deletes from both Cloudflare R2 storage and database.
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'image_url' => 'required|string',
        ]);

        $imageUrl = $request->input('image_url');
        
        // Only allow deletion if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        try {
            $userId = Auth::id();
            $updated = false;
            
            // Find all templates belonging to this user that might contain this image
            $templates = CustomizedTemplate::where('user_id', $userId)->get();
            
            foreach ($templates as $template) {
                $needsUpdate = false;
                
                // Normalize the image URL for comparison (remove query strings, decode, etc.)
                $normalizeUrl = function($url) {
                    if (empty($url)) return '';
                    // Remove query strings
                    $url = strtok($url, '?');
                    // Decode URL encoding
                    $url = urldecode($url);
                    // Remove trailing slashes
                    $url = rtrim($url, '/');
                    return $url;
                };
                
                $normalizedImageUrl = $normalizeUrl($imageUrl);
                
                // Check and remove from heading_images
                if ($template->heading_images && is_array($template->heading_images)) {
                    $originalCount = count($template->heading_images);
                    $template->heading_images = array_values(array_filter($template->heading_images, function($url) use ($imageUrl, $normalizedImageUrl, $normalizeUrl) {
                        if (empty($url)) return false;
                        $normalizedUrl = $normalizeUrl($url);
                        // Compare normalized URLs
                        return $normalizedUrl !== $normalizedImageUrl && 
                               $url !== $imageUrl &&
                               !Str::endsWith($normalizedUrl, $normalizedImageUrl) && 
                               !Str::endsWith($normalizedImageUrl, $normalizedUrl);
                    }));
                    
                    if (count($template->heading_images) < $originalCount) {
                        $needsUpdate = true;
                        \Log::info('Removed image from heading_images', [
                            'template_id' => $template->id,
                            'image_url' => $imageUrl,
                            'remaining_count' => count($template->heading_images)
                        ]);
                    }
                }
                
                // Check and remove from images array (which may contain 'memories', 'section2', etc.)
                if ($template->images && is_array($template->images)) {
                    $images = $template->images;
                    
                    // Check memories array
                    if (isset($images['memories']) && is_array($images['memories'])) {
                        $originalCount = count($images['memories']);
                        $images['memories'] = array_values(array_filter($images['memories'], function($url) use ($imageUrl, $normalizedImageUrl, $normalizeUrl) {
                            if (empty($url)) return false;
                            $normalizedUrl = $normalizeUrl($url);
                            return $normalizedUrl !== $normalizedImageUrl && 
                                   $url !== $imageUrl &&
                                   !Str::endsWith($normalizedUrl, $normalizedImageUrl) && 
                                   !Str::endsWith($normalizedImageUrl, $normalizedUrl);
                        }));
                        
                        if (count($images['memories']) < $originalCount) {
                            $needsUpdate = true;
                            \Log::info('Removed image from images.memories', [
                                'template_id' => $template->id,
                                'image_url' => $imageUrl,
                                'remaining_count' => count($images['memories'])
                            ]);
                        }
                    }
                    
                    // Check other image arrays (section2, section3, hero, etc.)
                    foreach ($images as $key => $value) {
                        if ($key === 'memories') continue; // Already handled
                        
                        if (is_array($value)) {
                            foreach ($value as $subKey => $subValue) {
                                if (is_string($subValue) && !empty($subValue)) {
                                    $normalizedSubValue = $normalizeUrl($subValue);
                                    if ($normalizedSubValue === $normalizedImageUrl || 
                                        $subValue === $imageUrl ||
                                        Str::endsWith($normalizedSubValue, $normalizedImageUrl) || 
                                        Str::endsWith($normalizedImageUrl, $normalizedSubValue)) {
                                        unset($images[$key][$subKey]);
                                        $needsUpdate = true;
                                        \Log::info('Removed image from images array', [
                                            'template_id' => $template->id,
                                            'key' => $key,
                                            'sub_key' => $subKey,
                                            'image_url' => $imageUrl
                                        ]);
                                    }
                                }
                            }
                            // Re-index array if needed
                            if (isset($images[$key]) && is_array($images[$key])) {
                                $images[$key] = array_values($images[$key]);
                            }
                        } elseif (is_string($value) && !empty($value)) {
                            $normalizedValue = $normalizeUrl($value);
                            if ($normalizedValue === $normalizedImageUrl || 
                                $value === $imageUrl ||
                                Str::endsWith($normalizedValue, $normalizedImageUrl) || 
                                Str::endsWith($normalizedImageUrl, $normalizedValue)) {
                                unset($images[$key]);
                                $needsUpdate = true;
                                \Log::info('Removed image from images array', [
                                    'template_id' => $template->id,
                                    'key' => $key,
                                    'image_url' => $imageUrl
                                ]);
                            }
                        }
                    }
                    
                    if ($needsUpdate) {
                        $template->images = $images;
                    }
                }
                
                // Save the template if it was updated
                if ($needsUpdate) {
                    $template->save();
                    $updated = true;
                }
            }
            
            // Delete the file from storage (Cloudflare R2 or local)
            $this->deleteImageFile($imageUrl);
            
            \Log::info('Image deleted via API', [
                'user_id' => $userId,
                'image_url' => $imageUrl,
                'database_updated' => $updated,
                'templates_checked' => $templates->count(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully from storage and database',
                'database_updated' => $updated,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to delete image via API', [
                'user_id' => Auth::id(),
                'image_url' => $imageUrl,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Show all templates with filtering options.
     */
    public function adminIndex(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $status = $request->get('status', 'draft'); // Default to draft
        
        $query = CustomizedTemplate::with('user');
        
        // Filter by status
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $templates = $query->orderBy('created_at', 'desc')->get();
        
        // Get stats
        $stats = [
            'draft' => CustomizedTemplate::where('status', 'draft')->count(),
            'published' => CustomizedTemplate::where('status', 'published')->count(),
            'archived' => CustomizedTemplate::where('status', 'archived')->count(),
            'total' => CustomizedTemplate::count(),
        ];

        return view('admin.templates.index', [
            'templates' => $templates,
            'stats' => $stats,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Admin: Show single draft template for review.
     */
    public function adminShow($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $template = CustomizedTemplate::with('user')->findOrFail($id);

        return view('admin.templates.show', [
            'template' => $template,
        ]);
    }

    /**
     * Admin: Approve and publish a draft template.
     */
    public function adminApprove(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        $template = CustomizedTemplate::findOrFail($id);

        if ($template->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Template is not in draft status',
            ], 400);
        }

        // Generate slug from recipient_name-user_id format
        if (!empty($template->recipient_name)) {
            $slugBase = Str::slug($template->recipient_name) . '-' . $template->user_id;
            $slug = $slugBase;
            $counter = 1;
            
            // Ensure uniqueness
            while (CustomizedTemplate::where('slug', $slug)->where('id', '!=', $template->id)->exists()) {
                $slug = $slugBase . '-' . $counter;
                $counter++;
            }
            
            $template->slug = $slug;
        } else {
            $template->slug = 'template-' . $template->user_id . '-' . time();
        }

        // Update status to published
        $template->status = 'published';
        $template->save();

        \Log::info('Template approved by admin', [
            'template_id' => $template->id,
            'slug' => $template->slug,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template approved and published successfully!',
            'data' => $template,
            'slug' => $template->slug,
        ]);
    }

    /**
     * Admin: Reject a draft template.
     */
    public function adminReject(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        $template = CustomizedTemplate::findOrFail($id);

        if ($template->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Template is not in draft status',
            ], 400);
        }

        // Update status to archived (rejected)
        $template->status = 'archived';
        $template->save();

        \Log::info('Template rejected by admin', [
            'template_id' => $template->id,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template rejected successfully!',
        ]);
    }

    /**
     * Admin: Delete a template and all associated images from Cloudflare.
     */
    public function adminDelete(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        $template = CustomizedTemplate::findOrFail($id);

        try {
            // Delete all associated images from Cloudflare/storage
            if ($template->heading_images && is_array($template->heading_images)) {
                foreach ($template->heading_images as $imageUrl) {
                    if (is_string($imageUrl) && !empty($imageUrl)) {
                        $this->deleteImageFile($imageUrl);
                    }
                }
            }

            if ($template->images && is_array($template->images)) {
                $this->deleteImages($template->images);
            }

            // Delete the template record
            $templateId = $template->id;
            $template->delete();

            \Log::info('Template deleted by admin', [
                'template_id' => $templateId,
                'admin_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Template and all associated images deleted successfully!',
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to delete template', [
                'template_id' => $id,
                'admin_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete template: ' . $e->getMessage(),
            ], 500);
        }
    }
}
