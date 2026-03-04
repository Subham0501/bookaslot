<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomizedTemplateController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\AdminGiftController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminBusinessController;

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

// Subdomain routing for business profiles
$appUrl = config('app.url');
$appHost = parse_url($appUrl, PHP_URL_HOST);

if ($appHost && $appHost !== 'localhost') {
    Route::domain('{subdomain}.' . $appHost)->group(function () use ($templates) {
        // Business profile
        Route::get('/', function ($subdomain) {
            $business = \App\Models\Business::where('slug', $subdomain)->where('is_active', true)->first();
            if ($business) {
                return app(\App\Http\Controllers\ShowcaseController::class)->show($subdomain);
            }
            abort(404);
        })->name('subdomain.profile');
        
        // Pin verification for Memory Pages
        Route::post('/verify-pin', [\App\Http\Controllers\CustomizedTemplateController::class, 'verifyPin'])->name('subdomain.verify-pin');
        
        // Gift box and other sub-pages
        Route::get('/gift-box', function ($subdomain) {
            $controller = app(\App\Http\Controllers\CustomizedTemplateController::class);
            return $controller->showGiftBox(request(), $subdomain);
        })->name('subdomain.gift-box');
    });
}

Route::get('/', function () use ($templates) {
    // Ensure all templates have section defaults for preview cards
    $templatesWithDefaults = [];
    foreach ($templates as $key => $template) {
        $templatesWithDefaults[$key] = ensureSectionDefaults($template);
    }
    
    return view('welcome', [
        'templates' => $templatesWithDefaults,
    ]);
})->name('welcome');

Route::get('/marketplace', [App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');

// Create route - Template selection page (requires authentication)
Route::get('/create', function (Request $request) use ($templates) {
    if (Auth::check()) {
        return redirect()->route('dashboard.index');
    }
    
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

// Template Preview Route
Route::get('/templates/{template}', function ($template) {
    $validTemplates = ['travel', 'ecommerce', 'consultancy', 'hotels', 'photo', 'personal', 'portfolio'];
    
    if (in_array($template, $validTemplates)) {
        // Create a fake business object for preview
        $business = new \App\Models\Business();
        $business->name = ucfirst($template) . ' Template Preview';
        $business->slug = 'preview';
        $business->description = 'This is a preview of the ' . ucfirst($template) . ' template. Your content will appear here.';
        $business->address = '123 Business St, Innovation City';
        $business->phone = '+977 1234567890';
        $business->email = 'contact@example.com';
        $business->whatsapp_number = '9800000000';
        $business->google_maps_link = 'https://maps.app.goo.gl/VQf1cAHDthANqvwT6';
        $business->established_year = rand(2015, 2024);
        $business->created_at = now()->subYears(rand(1, 5));
        
        // Define template-specific data
        $templateData = [
            'travel' => [
                'categories' => ['Adventure', 'Relaxation', 'Cultural'],
                'products' => [
                    ['name' => 'Himalayan Trek', 'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800', 'price' => 50000, 'desc' => '10-day trek to base camp.'],
                    ['name' => 'Beach Getaway', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800', 'price' => 25000, 'desc' => 'Relaxing weekend at the beach.'],
                    ['name' => 'City Tour', 'image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800', 'price' => 5000, 'desc' => 'Full day guided city tour.'],
                ],
                'description' => 'Explore the world with our curated travel packages. From mountains to beaches, we have it all.'
            ],
            'hotels' => [
                'categories' => ['Accommodation', 'Dining', 'Spa'],
                'products' => [
                    ['name' => 'Deluxe Suite', 'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800', 'price' => 15000, 'desc' => 'Luxury suite with city view.'],
                    ['name' => 'Gourmet Dinner', 'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800', 'price' => 3000, 'desc' => '5-course fine dining experience.'],
                    ['name' => 'Full Body Massage', 'image' => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800', 'price' => 4500, 'desc' => 'Relaxing 60-minute massage.'],
                ],
                'description' => 'Experience luxury and comfort at its finest. Book your stay or dining experience with us.'
            ],
            'consultancy' => [
                'categories' => ['Strategy', 'Finance', 'Marketing'],
                'products' => [
                    ['name' => 'Business Strategy', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800', 'price' => 10000, 'desc' => 'Comprehensive business growth strategy.'],
                    ['name' => 'Financial Audit', 'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800', 'price' => 20000, 'desc' => 'Detailed financial health check.'],
                    ['name' => 'Marketing Plan', 'image' => 'https://images.unsplash.com/photo-1533750516457-a7f992034fec?w=800', 'price' => 8000, 'desc' => 'Tailored marketing roadmap.'],
                ],
                'description' => 'Expert advice to take your business to the next level. Professional consultancy services.'
            ],

             'photo' => [
                'categories' => ['Weddings', 'Portraits', 'Events'],
                'products' => [
                    ['name' => 'Wedding Package', 'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800', 'price' => 100000, 'desc' => 'Full day wedding coverage.'],
                    ['name' => 'Portrait Session', 'image' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=800', 'price' => 10000, 'desc' => '1-hour professional portrait shoot.'],
                    ['name' => 'Event Coverage', 'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800', 'price' => 25000, 'desc' => 'Corporate or social event photography.'],
                ],
                'description' => 'Capturing moments that last a lifetime. Professional photography services.'
            ],
             'ecommerce' => [
                'categories' => ['Electronics', 'Lifestyle', 'Accessories'],
                'products' => [
                    ['name' => 'Premium Headphones', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800', 'price' => 1000, 'desc' => 'High-quality noise cancelling.'],
                    ['name' => 'Smart Watch', 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800', 'price' => 2500, 'desc' => 'Fitness tracking and notifications.'],
                    ['name' => 'Analog Camera', 'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800', 'price' => 5000, 'desc' => 'Classic film photography.'],
                ],
                'description' => 'Curated lifestyle goods for the modern individual. Shop our latest collection.'
            ],
            'personal' => [
                'categories' => ['Professional', 'Skills', 'Achievements'],
                'products' => [
                    ['name' => 'Strategic Consulting', 'image' => 'https://images.unsplash.com/photo-1507679799987-c7377fbbd56a?w=800', 'price' => 0, 'desc' => 'High-level business strategy and management.'],
                    ['name' => 'Leadership Training', 'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800', 'price' => 0, 'desc' => 'Corporate leadership and team building.'],
                    ['name' => 'Speaking Engagements', 'image' => 'https://images.unsplash.com/photo-1475721027187-402ad2989a3b?w=800', 'price' => 0, 'desc' => 'Keynote speaking for business events.'],
                ],
                'description' => 'Professional profile for business leaders and management specialists.',
                'social_links' => [
                    'facebook' => 'https://facebook.com',
                    'instagram' => 'https://instagram.com'
                ]
            ],
        ];

        // Default to ecommerce if template not defined (shouldn't happen due to validTemplates check)
        $data = $templateData[$template] ?? $templateData['ecommerce'];

        // Update description
        $business->description = $data['description'];

        // Create categories
        $categories = collect();
        foreach ($data['categories'] as $index => $catName) {
            $categories->push((object)[
                'id' => $index + 1,
                'name' => $catName,
                'slug' => \Illuminate\Support\Str::slug($catName)
            ]);
        }

        // Create products
        $products = collect();
        foreach ($data['products'] as $index => $prod) {
            $cat = $categories[$index % $categories->count()];
            $products->push((object)[
                'id' => $index + 1,
                'name' => $prod['name'],
                'description' => $prod['desc'],
                'price' => $prod['price'],
                'discount_price' => $prod['price'] * 0.9, // 10% discount example
                'image' => $prod['image'],
                'category' => $cat,
                'click_count' => rand(5, 50),
                'category_id' => $cat->id
            ]);
        }
        
        // Create dummy banner
        $banners = collect([
            (object)[
                'id' => 1,
                'title' => 'Welcome to ' . $business->name,
                'description' => $data['description'],
                'image' => $data['products'][0]['image'] // Use the first product image as banner
            ]
        ]);
        
        // Pass collections with data
        $business->setRelation('products', $products);
        $business->setRelation('banners', $banners);
        $business->setRelation('categories', $categories);
        $business->setRelation('analytics', collect([]));

        return view('business.themes.' . $template, compact('business'));
    }
    
    abort(404);
})->name('templates.preview');

// Privacy Policy Page
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Gift routes
Route::get('/gifts', [GiftController::class, 'index'])->name('gifts.index');
Route::get('/gifts/customize', [GiftController::class, 'customize'])->name('gifts.customize');
Route::get('/gifts/{id}', [GiftController::class, 'show'])->name('gifts.show');
Route::get('/gifts/{id}/buy', [GiftController::class, 'quickBuy'])->name('gifts.quick-buy');
Route::get('/gifts/{id}/customize', [GiftController::class, 'customizeWithId'])->name('gifts.customize.with-id');
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
    
    // Dashboard / Business Admin routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        
        Route::get('/products', [DashboardController::class, 'products'])->name('products');
        Route::post('/products', [DashboardController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [DashboardController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [DashboardController::class, 'destroyProduct'])->name('products.destroy');
        Route::post('/categories', [DashboardController::class, 'storeCategory'])->name('categories.store');
        
        Route::get('/banners', [DashboardController::class, 'banners'])->name('banners');
        Route::post('/banners', [DashboardController::class, 'storeBanner'])->name('banners.store');
        Route::delete('/banners/{id}', [DashboardController::class, 'destroyBanner'])->name('banners.destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/templates', [CustomizedTemplateController::class, 'adminIndex'])->name('templates.index');
        Route::get('/templates/{id}', [CustomizedTemplateController::class, 'adminShow'])->name('templates.show');
        Route::get('/templates/{id}/edit', [CustomizedTemplateController::class, 'adminEdit'])->name('templates.edit');
        Route::put('/templates/{id}', [CustomizedTemplateController::class, 'adminUpdate'])->name('templates.update');
        Route::post('/templates/{id}/approve', [CustomizedTemplateController::class, 'adminApprove'])->name('templates.approve');
        Route::post('/templates/{id}/reject', [CustomizedTemplateController::class, 'adminReject'])->name('templates.reject');
        Route::delete('/templates/{id}', [CustomizedTemplateController::class, 'adminDelete'])->name('templates.delete');
        
        // Business Management Routes
        Route::get('/businesses', [AdminBusinessController::class, 'index'])->name('businesses.index');
        Route::get('/businesses/create', [AdminBusinessController::class, 'create'])->name('businesses.create');
        Route::post('/businesses', [AdminBusinessController::class, 'store'])->name('businesses.store');
        Route::delete('/businesses/{id}', [AdminBusinessController::class, 'destroy'])->name('businesses.destroy');

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

// Image optimization route - run from browser since no terminal access
Route::get('/optimize-images', function () {
    // Increase limits for processing
    ini_set('memory_limit', '512M');
    set_time_limit(600); // 10 minutes

    try {
        $files = Storage::disk('public')->allFiles();
        $count = 0;
        $totalSaved = 0;
        $details = [];

        foreach ($files as $file) {
            $fullPath = storage_path('app/public/' . $file);
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) continue;
            if (!function_exists('imagecreatefromstring')) {
                throw new \Exception('GD extension not found on server');
            }

            $oldSize = filesize($fullPath);
            if ($oldSize < 500 * 1024) continue; // Skip files < 500KB

            $imageData = file_get_contents($fullPath);
            $img = imagecreatefromstring($imageData);
            if (!$img) continue;

            $width = imagesx($img);
            $height = imagesy($img);
            $maxDim = 1200;

            $resized = false;
            if ($width > $maxDim || $height > $maxDim) {
                if ($width > $height) {
                    $newWidth = $maxDim;
                    $newHeight = (int)($height * ($maxDim / $width));
                } else {
                    $newHeight = $maxDim;
                    $newWidth = (int)($width * ($maxDim / $height));
                }
                $tmp = imagecreatetruecolor($newWidth, $newHeight);
                if ($extension === 'png') {
                    imagealphablending($tmp, false);
                    imagesavealpha($tmp, true);
                }
                imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($img);
                $img = $tmp;
                $resized = true;
            }

            ob_start();
            if ($extension === 'png') {
                imagepng($img, null, 7);
            } else {
                imagejpeg($img, null, 75);
            }
            $optimizedData = ob_get_clean();
            imagedestroy($img);

            if (strlen($optimizedData) < $oldSize) {
                file_put_contents($fullPath, $optimizedData);
                $saved = $oldSize - strlen($optimizedData);
                $count++;
                $totalSaved += $saved;
                $details[] = "Optimized $file: " . round($oldSize/1024) . "KB -> " . round(strlen($optimizedData)/1024) . "KB";
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully optimized $count images.",
            'total_space_saved' => round($totalSaved / 1024 / 1024, 2) . " MB",
            'details' => $details
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Optimization failed',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('optimize-images');

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

// Tracking route for business showcase
Route::get('/track-analytic/{businessId}', [\App\Http\Controllers\ShowcaseController::class, 'trackAnalytic'])->name('business.track');

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

    // 1. Check if it's a Business
    $business = \App\Models\Business::where('slug', $slug)->where('is_active', true)->first();
    if ($business) {
        return app(\App\Http\Controllers\ShowcaseController::class)->show($slug);
    }
    
    // 2. Fallback to Memory Page
    $controller = app(CustomizedTemplateController::class);
    return $controller->show(request(), $slug, $templates);
})->name('templates.show');
Route::get('/check-limits', function() {
    return response()->json([
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'gd_enabled' => function_exists('imagecreatefromstring'),
        'session_driver' => config('session.driver'),
    ]);
});
