<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomizedTemplateController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\AdminGiftController;
use App\Http\Controllers\AdminSettingsController;

// Template configurations - 4 templates per category
$templates = [
    // Marriage Templates (4)
    'marriage-1' => [
        'name' => 'Romantic Elegance',
        'category' => 'marriage',
        'color' => '#ff6b6b',
        'bg' => 'from-pink-50 to-rose-100 dark:from-pink-900/20 dark:to-rose-900/20',
        'design' => 'marriage-1-elegant',
        'defaults' => [
            'heading' => 'To My Beloved',
            'subheading' => 'On Our Special Day',
            'message' => 'Today marks the beginning of our forever. I promise to love, honor, and cherish you for all the days of my life. You are my everything.',
            'from' => 'With All My Love',
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
        ]
    ],
    'marriage-2' => [
        'name' => 'Classic Romance',
        'category' => 'marriage',
        'color' => '#ff8fab',
        'bg' => 'from-rose-50 to-pink-100 dark:from-rose-900/20 dark:to-pink-900/20',
        'design' => 'marriage-2-classic',
        'defaults' => [
            'heading' => 'Forever & Always',
            'subheading' => 'Our Journey Begins',
            'message' => 'In you, I found my best friend, my soulmate, my everything. Together we will create a lifetime of beautiful memories. I love you endlessly.',
            'from' => 'Your Loving Partner'
        ]
    ],
    'marriage-3' => [
        'name' => 'Modern Love',
        'category' => 'marriage',
        'color' => '#ff6b9d',
        'bg' => 'from-purple-50 to-pink-100 dark:from-purple-900/20 dark:to-pink-900/20',
        'design' => 'marriage-3-modern',
        'defaults' => [
            'heading' => 'You & Me',
            'subheading' => 'A New Chapter',
            'message' => 'Every moment with you feels like a dream. Today we start our greatest adventure together. Thank you for choosing me to be your partner in life.',
            'from' => 'Forever Yours'
        ]
    ],
    'marriage-4' => [
        'name' => 'Timeless Bond',
        'category' => 'marriage',
        'color' => '#ff5252',
        'bg' => 'from-red-50 to-rose-100 dark:from-red-900/20 dark:to-rose-900/20',
        'design' => 'marriage-4-timeless',
        'defaults' => [
            'heading' => 'My Dearest',
            'subheading' => 'A Promise of Forever',
            'message' => 'With this ring, I give you my heart. I promise to stand by you, support you, and love you through all of life\'s adventures. You complete me.',
            'from' => 'Your Devoted Spouse'
        ]
    ],
    
    // Father's Day Templates (4)
    'fathersday-1' => [
        'name' => 'Classic Appreciation',
        'category' => 'fathersday',
        'color' => '#4ecdc4',
        'bg' => 'from-blue-50 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20',
        'design' => 'fathersday-1-classic',
        'defaults' => [
            'heading' => 'To My Amazing Father',
            'subheading' => 'On This Special Day',
            'message' => 'I want to express my deepest gratitude for everything you\'ve done. Your love, guidance, and support mean the world to me. Happy Father\'s Day!',
            'from' => 'With Love, Your Child'
        ]
    ],
    'fathersday-2' => [
        'name' => 'Hero Tribute',
        'category' => 'fathersday',
        'color' => '#45b8b0',
        'bg' => 'from-cyan-50 to-blue-100 dark:from-cyan-900/20 dark:to-blue-900/20',
        'design' => 'fathersday-2-hero',
        'defaults' => [
            'heading' => 'My Hero, My Dad',
            'subheading' => 'Thank You For Everything',
            'message' => 'You\'ve been my role model, my guide, and my biggest supporter. Your strength and wisdom inspire me every day. I\'m so proud to be your child.',
            'from' => 'Your Grateful Child'
        ]
    ],
    'fathersday-3' => [
        'name' => 'Heartfelt Thanks',
        'category' => 'fathersday',
        'color' => '#3a9d96',
        'bg' => 'from-teal-50 to-cyan-100 dark:from-teal-900/20 dark:to-cyan-900/20',
        'design' => 'fathersday-3-heartfelt',
        'defaults' => [
            'heading' => 'Dear Dad',
            'subheading' => 'You Mean The World',
            'message' => 'Thank you for all the sacrifices you\'ve made, the lessons you\'ve taught, and the unconditional love you\'ve given. You are the best father anyone could ask for.',
            'from' => 'With All My Love'
        ]
    ],
    'fathersday-4' => [
        'name' => 'Modern Tribute',
        'category' => 'fathersday',
        'color' => '#2dd4bf',
        'bg' => 'from-emerald-50 to-teal-100 dark:from-emerald-900/20 dark:to-teal-900/20',
        'design' => 'fathersday-4-modern',
        'defaults' => [
            'heading' => 'To The Best Dad',
            'subheading' => 'Celebrating You',
            'message' => 'Your love has shaped who I am today. Thank you for being patient, kind, and always there when I needed you. Happy Father\'s Day, Dad!',
            'from' => 'Your Loving Child'
        ]
    ],
    
    // Birthday Templates (4)
    'birthday-1' => [
        'name' => 'Celebration Joy',
        'category' => 'birthday',
        'color' => '#ffd93d',
        'bg' => 'from-yellow-50 to-orange-100 dark:from-yellow-900/20 dark:to-orange-900/20',
        'design' => 'birthday-1-celebration',
        'defaults' => [
            'heading' => 'Happy Birthday!',
            'subheading' => 'Celebrating You',
            'message' => 'Another year older, another year wiser! May your special day be filled with joy, laughter, and all the things you love. Here\'s to another amazing year!',
            'from' => 'With Love'
        ]
    ],
    'birthday-2' => [
        'name' => 'Party Time',
        'category' => 'birthday',
        'color' => '#ffb347',
        'bg' => 'from-orange-50 to-yellow-100 dark:from-orange-900/20 dark:to-yellow-900/20',
        'design' => 'birthday-2-party',
        'defaults' => [
            'heading' => 'It\'s Your Day!',
            'subheading' => 'Let\'s Celebrate',
            'message' => 'Today is all about you! May your birthday bring you endless happiness, wonderful surprises, and memories that will last forever. Enjoy your special day!',
            'from' => 'Your Friend'
        ]
    ],
    'birthday-3' => [
        'name' => 'Elegant Wishes',
        'category' => 'birthday',
        'color' => '#ffa500',
        'bg' => 'from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-900/20',
        'design' => 'birthday-3-elegant',
        'defaults' => [
            'heading' => 'Another Year',
            'subheading' => 'Another Blessing',
            'message' => 'On your special day, I wish you health, happiness, and all the success in the world. May this new year of your life be filled with amazing adventures!',
            'from' => 'With Warm Wishes'
        ]
    ],
    'birthday-4' => [
        'name' => 'Fun Celebration',
        'category' => 'birthday',
        'color' => '#ffcc00',
        'bg' => 'from-yellow-100 to-amber-100 dark:from-yellow-800/20 dark:to-amber-800/20',
        'design' => 'birthday-4-fun',
        'defaults' => [
            'heading' => 'Birthday Wishes!',
            'subheading' => 'Make A Wish',
            'message' => 'Hope all your birthday wishes come true! You deserve the best because you are amazing. Have a fantastic day filled with cake, laughter, and love!',
            'from' => 'Your Well-Wisher'
        ]
    ],
    
    // Valentine's Day Templates (4)
    'valentine-1' => [
        'name' => 'Romantic Love',
        'category' => 'valentine',
        'color' => '#ff6b6b',
        'bg' => 'from-red-50 to-pink-100 dark:from-red-900/20 dark:to-pink-900/20',
        'design' => 'valentine-1-romantic',
        'defaults' => [
            'heading' => 'To My Dearest',
            'subheading' => 'With All My Heart',
            'message' => 'You are my sunshine, my everything. Every day with you is a gift. I love you more than words can express. Happy Valentine\'s Day!',
            'from' => 'Forever Yours'
        ]
    ],
    'valentine-2' => [
        'name' => 'Sweet Affection',
        'category' => 'valentine',
        'color' => '#ff8fab',
        'bg' => 'from-pink-50 to-rose-100 dark:from-pink-900/20 dark:to-rose-900/20',
        'design' => 'valentine-2-sweet',
        'defaults' => [
            'heading' => 'My Love',
            'subheading' => 'You Complete Me',
            'message' => 'Every moment with you feels magical. Your smile lights up my world, and your love fills my heart with joy. I\'m so grateful to have you in my life.',
            'from' => 'Your Admirer'
        ]
    ],
    'valentine-3' => [
        'name' => 'Passionate Heart',
        'category' => 'valentine',
        'color' => '#ff5252',
        'bg' => 'from-rose-50 to-red-100 dark:from-rose-900/20 dark:to-red-900/20',
        'design' => 'valentine-3-passionate',
        'defaults' => [
            'heading' => 'My Beloved',
            'subheading' => 'Forever & Always',
            'message' => 'You are the reason my heart beats faster. Your love is the greatest gift I\'ve ever received. I fall in love with you more every single day.',
            'from' => 'Your Devoted Love'
        ]
    ],
    'valentine-4' => [
        'name' => 'Timeless Romance',
        'category' => 'valentine',
        'color' => '#ff1744',
        'bg' => 'from-red-100 to-pink-100 dark:from-red-800/20 dark:to-pink-800/20',
        'design' => 'valentine-4-timeless',
        'defaults' => [
            'heading' => 'My Everything',
            'subheading' => 'A Love Story',
            'message' => 'In your eyes, I found my home. In your heart, I found my peace. In your love, I found my forever. Happy Valentine\'s Day, my love!',
            'from' => 'Eternally Yours'
        ]
    ],
    
    // Mother's Day Templates (4)
    'mothersday-1' => [
        'name' => 'Grateful Heart',
        'category' => 'mothersday',
        'color' => '#ff8fab',
        'bg' => 'from-pink-50 to-rose-100 dark:from-pink-900/20 dark:to-rose-900/20',
        'design' => 'mothersday-1-grateful',
        'defaults' => [
            'heading' => 'To My Wonderful Mother',
            'subheading' => 'With Endless Gratitude',
            'message' => 'Thank you for your unconditional love, endless patience, and unwavering support. You are my inspiration and my greatest blessing. Happy Mother\'s Day!',
            'from' => 'Your Loving Child'
        ]
    ],
    'mothersday-2' => [
        'name' => 'Angel Tribute',
        'category' => 'mothersday',
        'color' => '#ff6b9d',
        'bg' => 'from-rose-50 to-pink-100 dark:from-rose-900/20 dark:to-pink-900/20',
        'design' => 'mothersday-2-angel',
        'defaults' => [
            'heading' => 'My Angel, My Mom',
            'subheading' => 'You Are Everything',
            'message' => 'You\'ve been my guide, my protector, and my best friend. Your love has shaped me into who I am today. I love you more than words can say.',
            'from' => 'Your Grateful Child'
        ]
    ],
    'mothersday-3' => [
        'name' => 'Heartfelt Thanks',
        'category' => 'mothersday',
        'color' => '#ff8fa3',
        'bg' => 'from-pink-100 to-rose-100 dark:from-pink-800/20 dark:to-rose-800/20',
        'design' => 'mothersday-3-heartfelt',
        'defaults' => [
            'heading' => 'Dear Mom',
            'subheading' => 'Thank You For Everything',
            'message' => 'For all the sacrifices you\'ve made, the lessons you\'ve taught, and the love you\'ve given - thank you. You are the most amazing mother in the world.',
            'from' => 'With All My Love'
        ]
    ],
    'mothersday-4' => [
        'name' => 'Beautiful Bond',
        'category' => 'mothersday',
        'color' => '#ff7aa2',
        'bg' => 'from-rose-100 to-pink-100 dark:from-rose-800/20 dark:to-pink-800/20',
        'design' => 'mothersday-4-bond',
        'defaults' => [
            'heading' => 'To The Best Mom',
            'subheading' => 'Celebrating You',
            'message' => 'Your strength, kindness, and love inspire me every day. Thank you for being the incredible woman you are. Happy Mother\'s Day!',
            'from' => 'Your Proud Child'
        ]
    ],
];

// Helper function to ensure all templates have section defaults
function ensureSectionDefaults($templateData) {
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

// Home route
Route::get('/', function () use ($templates) {
    // Ensure all templates have section defaults for preview cards
    $templatesWithDefaults = [];
    foreach ($templates as $key => $template) {
        $templatesWithDefaults[$key] = ensureSectionDefaults($template);
    }
    
    // Get active gifts for the gifts section
    $gifts = \App\Models\Gift::where('is_active', true)
        ->orderBy('sort_order')
        ->with('addons')
        ->get();
    
    return view('welcome', [
        'templates' => $templatesWithDefaults,
        'gifts' => $gifts
    ]);
});

// Create route - Template selection page (requires authentication)
Route::get('/create', function (Request $request) use ($templates) {
    if (!Auth::check()) {
        $request->session()->put('url.intended', '/create');
        return redirect()->route('login');
    }
    
    // Ensure all templates have section defaults for preview cards
    $templatesWithDefaults = [];
    foreach ($templates as $key => $template) {
        $templatesWithDefaults[$key] = ensureSectionDefaults($template);
    }
    return view('create', ['templates' => $templatesWithDefaults]);
})->name('create');

// Template routes
Route::get('/template/{template}/preview', function ($template) use ($templates) {
    $templateData = $templates[$template] ?? $templates['fathersday-1'];
    $templateData = ensureSectionDefaults($templateData);
    return view('templates.preview', ['template' => $template, 'templateData' => $templateData]);
})->name('template.preview');

Route::get('/template/{template}/customize', function ($template) use ($templates) {
    $templateData = $templates[$template] ?? $templates['fathersday-1'];
    $templateData = ensureSectionDefaults($templateData);
    
    // Try to load template-specific customization file first
    // Format: templates.customize.{category}.{template} or templates.customize.{template}
    $category = $templateData['category'] ?? 'default';
    $customizeView = null;
    
    // Try template-specific file first (e.g., templates.customize.birthday.birthday-1)
    if (view()->exists("templates.customize.{$category}.{$template}")) {
        $customizeView = "templates.customize.{$category}.{$template}";
    }
    // Try direct template file (e.g., templates.customize.birthday-1)
    elseif (view()->exists("templates.customize.{$template}")) {
        $customizeView = "templates.customize.{$template}";
    }
    // Fall back to default
    else {
        $customizeView = 'templates.customize.default';
    }
    
    return view($customizeView, ['template' => $template, 'templateData' => $templateData]);
})->middleware('auth')->name('template.customize');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);
    
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }
    
    if ($user->hasVerifiedEmail()) {
        // Don't auto-login, redirect to login page
        return redirect()->route('login')->with('success', 'Email already verified! Please log in to continue.');
    }
    
    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }
    
    // Don't auto-login, redirect to login page
    return redirect()->route('login')->with('success', 'Email verified successfully! Please log in to continue.');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent! Please check your email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Terms and Conditions
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Privacy Policy Page
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Gift routes
Route::get('/gifts', [GiftController::class, 'index'])->name('gifts.index');
Route::get('/gifts/{id}', [GiftController::class, 'show'])->name('gifts.show');
Route::get('/gifts/{id}/buy', [GiftController::class, 'quickBuy'])->name('gifts.quick-buy');
Route::get('/gifts/{id}/customize', [GiftController::class, 'customize'])->name('gifts.customize');
Route::post('/gifts/checkout', [GiftController::class, 'checkout'])->name('gifts.checkout');
Route::post('/gifts/submit-order', [GiftController::class, 'submitOrder'])->name('gifts.submit-order');
Route::get('/gifts/order-success/{id}', [GiftController::class, 'orderSuccess'])->name('gifts.order-success');

// Customized Template routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::post('/api/templates/draft', [CustomizedTemplateController::class, 'saveDraft'])->name('templates.save-draft');
    Route::post('/api/templates', [CustomizedTemplateController::class, 'store'])->name('templates.store');
    Route::get('/api/templates/{id}', [CustomizedTemplateController::class, 'getTemplate'])->name('templates.get');
    Route::put('/api/templates/{id}', [CustomizedTemplateController::class, 'update'])->name('templates.update');
    Route::get('/api/templates', [CustomizedTemplateController::class, 'index'])->name('templates.index');
    Route::delete('/api/templates/{id}', [CustomizedTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('/api/templates/delete-image', [CustomizedTemplateController::class, 'deleteImage'])->name('templates.delete-image');
    Route::post('/api/templates/check-page-name', [CustomizedTemplateController::class, 'checkPageName'])->name('templates.check-page-name');
    Route::post('/api/templates/check-recipient-name', [CustomizedTemplateController::class, 'checkRecipientName'])->name('templates.check-recipient-name');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/templates', [CustomizedTemplateController::class, 'adminIndex'])->name('templates.index');
        Route::get('/templates/{id}', [CustomizedTemplateController::class, 'adminShow'])->name('templates.show');
        Route::post('/templates/{id}/approve', [CustomizedTemplateController::class, 'adminApprove'])->name('templates.approve');
        Route::post('/templates/{id}/reject', [CustomizedTemplateController::class, 'adminReject'])->name('templates.reject');
        Route::delete('/templates/{id}', [CustomizedTemplateController::class, 'adminDelete'])->name('templates.delete');
        
        // Gift management routes
        Route::resource('gifts', AdminGiftController::class);
        Route::get('/gifts/{id}/addons', [AdminGiftController::class, 'showAddons'])->name('gifts.addons');
        Route::post('/gifts/{id}/addons', [AdminGiftController::class, 'storeAddon'])->name('gifts.addons.store');
        Route::put('/gifts/{giftId}/addons/{addonId}', [AdminGiftController::class, 'updateAddon'])->name('gifts.addons.update');
        Route::delete('/gifts/{giftId}/addons/{addonId}', [AdminGiftController::class, 'destroyAddon'])->name('gifts.addons.destroy');
        
        // Settings routes
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    });
});

use Illuminate\Support\Facades\Artisan;


// PIN verification route (must be before the slug route)
Route::post('/{slug}/verify-pin', [CustomizedTemplateController::class, 'verifyPin'])->name('templates.verify-pin');

// Gift box animation page (after PIN verification)
Route::get('/{slug}/gift-box', function ($slug) {
    $controller = app(CustomizedTemplateController::class);
    return $controller->showGiftBox(request(), $slug);
})->name('templates.gift-box');

// Migration route - run migrations directly from browser
Route::get('/migrate', function () {
    try {
        \Artisan::call('migrate', ['--force' => true]);
        $output = \Artisan::output();
        return response()->json([
            'success' => true,
            'message' => 'Migrations completed successfully',
            'output' => $output
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Migration failed',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('migrate');

// Storage link route - create storage symlink from browser
Route::get('/storage-link', function () {
    try {
        // Check if link already exists
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        if (file_exists($linkPath)) {
            // Check if it's already a symlink
            if (is_link($linkPath)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Storage link already exists',
                    'link_path' => $linkPath,
                    'target_path' => $targetPath
                ], 200);
            } else {
                // Remove existing file/directory if it's not a symlink
                if (is_dir($linkPath)) {
                    rmdir($linkPath);
                } else {
                    unlink($linkPath);
                }
            }
        }
        
        // Create the symlink
        \Artisan::call('storage:link');
        $output = \Artisan::output();
        
        return response()->json([
            'success' => true,
            'message' => 'Storage link created successfully',
            'link_path' => $linkPath,
            'target_path' => $targetPath,
            'output' => $output
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Storage link creation failed',
            'error' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTraceAsString() : null
        ], 500);
    }
})->name('storage-link');

// Serve storage files - must be before catch-all route
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    // Security check: ensure file is within storage/app/public directory
    $realPath = realpath($filePath);
    $storageDir = realpath(storage_path('app/public'));
    
    if (!$realPath || !$storageDir || !str_starts_with($realPath, $storageDir)) {
        abort(403, 'Access denied');
    }
    
    // Check if file exists
    if (!file_exists($realPath) || !is_file($realPath)) {
        abort(404, 'File not found');
    }
    
    // Determine MIME type
    $mimeType = mime_content_type($realPath);
    if (!$mimeType) {
        $extension = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
        ];
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
    }
    
    return response()->file($realPath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.serve');

// Serve static assets from public/assets directory - must be before catch-all route
Route::get('/assets/{file}', function ($file) {
    // Sanitize filename to prevent directory traversal
    $file = basename($file); // Remove any path components
    
    $filePath = public_path('assets/' . $file);
    
    // Check if file exists
    if (!file_exists($filePath) || !is_file($filePath)) {
        \Log::warning('Asset file not found', [
            'requested_file' => $file,
            'file_path' => $filePath,
            'file_exists' => file_exists($filePath),
            'is_file' => is_file($filePath),
        ]);
        abort(404, 'Asset file not found: ' . $file);
    }
    
    // Security check: ensure file is within assets directory
    $realPath = realpath($filePath);
    $assetsDir = realpath(public_path('assets'));
    
    if (!$realPath || !$assetsDir || !str_starts_with($realPath, $assetsDir)) {
        \Log::warning('Asset file access denied - outside assets directory', [
            'requested_file' => $file,
            'real_path' => $realPath,
            'assets_dir' => $assetsDir,
        ]);
        abort(403, 'Access denied');
    }
    
    // Determine MIME type
    $mimeType = mime_content_type($realPath);
    if (!$mimeType) {
        $extension = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
        ];
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
    }
    
    return response()->file($realPath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('file', '.*');

// Published template route - must be last to avoid conflicts with other routes
// This will catch any slug that doesn't match the routes above
Route::get('/{slug}', function ($slug) use ($templates) {
    \Log::info('Route hit for slug', ['slug' => $slug]);
    
    // Skip if it's a reserved route or starts with reserved prefixes
    $reservedRoutes = ['login', 'register', 'logout', 'api', 'template', 'admin', 'storage', 'vendor', 'public', 'create', 'assets'];
    $reservedPrefixes = ['api/', 'template/', 'admin/', 'assets/'];
    
    if (in_array($slug, $reservedRoutes)) {
        \Log::info('Slug is reserved route', ['slug' => $slug]);
        abort(404);
    }
    
    foreach ($reservedPrefixes as $prefix) {
        if (str_starts_with($slug, $prefix)) {
            \Log::info('Slug starts with reserved prefix', ['slug' => $slug, 'prefix' => $prefix]);
            abort(404);
        }
    }
    
    $controller = app(CustomizedTemplateController::class);
    return $controller->show(request(), $slug, $templates);
})->name('templates.show');
