<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Gift - Hamro Yaad</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-25px) rotate(-3deg);
            }
            50% {
                transform: translateY(-50px) rotate(0deg);
            }
            75% {
                transform: translateY(-25px) rotate(3deg);
            }
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0) scale(1) rotate(0deg);
            }
            25% {
                transform: translateY(-40px) scale(1.15) rotate(-5deg);
            }
            50% {
                transform: translateY(-60px) scale(1.2) rotate(0deg);
            }
            75% {
                transform: translateY(-40px) scale(1.15) rotate(5deg);
            }
        }
        
        @keyframes sparkle {
            0%, 100% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1.5) rotate(180deg);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
                filter: drop-shadow(0 0 20px {{ $theme_color }}80);
            }
            50% {
                opacity: 0.9;
                transform: scale(1.08);
                filter: drop-shadow(0 0 40px {{ $theme_color }}cc);
            }
        }
        
        @keyframes glow {
            0%, 100% {
                filter: drop-shadow(0 0 30px {{ $theme_color }}80) drop-shadow(0 0 60px {{ $theme_color }}40);
            }
            50% {
                filter: drop-shadow(0 0 50px {{ $theme_color }}cc) drop-shadow(0 0 100px {{ $theme_color }}80);
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }
        
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .gift-box {
            animation: float 4s ease-in-out infinite, pulse 2.5s ease-in-out infinite, glow 3s ease-in-out infinite;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }
        
        .gift-box:hover {
            transform: scale(1.2) rotate(5deg) !important;
            animation-play-state: paused;
            filter: drop-shadow(0 0 60px {{ $theme_color }}ff) drop-shadow(0 0 120px {{ $theme_color }}aa) !important;
        }
        
        .gift-box:active {
            transform: scale(0.9) rotate(-2deg);
        }
        
        .gift-box-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .gift-box-wrapper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, {{ $theme_color }}40 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
            z-index: -1;
        }
        
        .sparkle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: {{ $theme_color }};
            border-radius: 50%;
            box-shadow: 0 0 15px {{ $theme_color }}, 0 0 30px {{ $theme_color }}, 0 0 45px {{ $theme_color }};
            animation: sparkle 2s infinite;
        }
        
        .confetti {
            position: fixed;
            width: 12px;
            height: 12px;
            background: {{ $theme_color }};
            border-radius: 50%;
            animation: confetti-fall 3s linear infinite;
            box-shadow: 0 0 10px {{ $theme_color }};
        }
        
        .confetti.triangle {
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 10px solid {{ $theme_color }};
            background: none;
        }
        
        .confetti.star {
            background: none;
            width: 12px;
            height: 12px;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg) scale(0.5);
                opacity: 0;
            }
        }
        
        body {
            background: linear-gradient(135deg, {{ $theme_color }}20 0%, {{ $theme_color }}08 30%, {{ $theme_color }}15 60%, {{ $theme_color }}05 100%);
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, {{ $theme_color }}15 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, {{ $theme_color }}10 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .theme-color {
            color: {{ $theme_color }};
        }
        
        .theme-bg {
            background-color: {{ $theme_color }};
        }
        
        .theme-border {
            border-color: {{ $theme_color }};
        }
        
        .gift-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent
            );
            animation: shimmer 3s infinite;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            border: 3px solid {{ $theme_color }};
            opacity: 0.6;
            animation: ripple-animation 2s infinite;
        }
        
        @keyframes ripple-animation {
            0% {
                width: 0;
                height: 0;
                opacity: 0.6;
            }
            100% {
                width: 200px;
                height: 200px;
                opacity: 0;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 relative">
    <!-- Confetti -->
    <div id="confetti-container" class="fixed inset-0 pointer-events-none z-10"></div>
    
    <!-- Sparkles -->
    <div id="sparkles-container" class="fixed inset-0 pointer-events-none z-20"></div>
    
    <!-- Main Content -->
    <div class="text-center z-30 relative">
        <div class="mb-8">
            @if($recipient_name)
                <p class="text-3xl md:text-4xl font-bold mb-4 drop-shadow-lg theme-color">
                    {{ $recipient_name }}
                </p>
            @endif
            <p class="text-xl md:text-2xl text-gray-700 font-semibold drop-shadow-md">
                You have a special memory waiting for you!
            </p>
        </div>
        
        <!-- Gift Box -->
        <div class="relative inline-block mb-8 z-30">
            <!-- Ripple effects -->
            <div class="ripple" style="top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 0s;"></div>
            <div class="ripple" style="top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 0.7s;"></div>
            <div class="ripple" style="top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 1.4s;"></div>
            
            <!-- Sparkles around gift box -->
            <div class="sparkle" style="top: -30px; left: 30px; animation-delay: 0s;"></div>
            <div class="sparkle" style="top: 30px; right: -30px; animation-delay: 0.5s;"></div>
            <div class="sparkle" style="bottom: -30px; left: -30px; animation-delay: 1s;"></div>
            <div class="sparkle" style="top: -15px; right: 15px; animation-delay: 1.5s;"></div>
            <div class="sparkle" style="top: 50%; left: -40px; animation-delay: 0.8s;"></div>
            <div class="sparkle" style="top: 50%; right: -40px; animation-delay: 1.2s;"></div>
            
            <div class="gift-box-wrapper">
                <div class="gift-box" id="gift-box" onclick="openGift()">
                    <div class="gift-shimmer"></div>
                    <!-- Premium Gift Box SVG Design -->
                    <svg width="400" height="400" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0 15px 40px rgba(0,0,0,0.4));">
                        <defs>
                            <!-- Box gradients for 3D effect -->
                            <linearGradient id="boxTop" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }};stop-opacity:1" />
                                <stop offset="50%" style="stop-color:{{ $theme_color }}ee;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}cc;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="boxFront" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }}dd;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:{{ $theme_color }}bb;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}99;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="boxSide" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }}aa;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}88;stop-opacity:1" />
                            </linearGradient>
                            <!-- Ribbon gradient -->
                            <linearGradient id="ribbonGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }};stop-opacity:1" />
                                <stop offset="50%" style="stop-color:{{ $theme_color }}ff;stop-opacity:0.95" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}dd;stop-opacity:0.9" />
                            </linearGradient>
                            <!-- Bow gradients -->
                            <radialGradient id="bowCenter" cx="50%" cy="50%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }}ff;stop-opacity:1" />
                                <stop offset="70%" style="stop-color:{{ $theme_color }}dd;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}bb;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="bowLoop" cx="50%" cy="50%">
                                <stop offset="0%" style="stop-color:{{ $theme_color }}ff;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:{{ $theme_color }}cc;stop-opacity:1" />
                            </radialGradient>
                            <!-- Pattern for box texture -->
                            <pattern id="boxPattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <rect width="20" height="20" fill="none"/>
                                <line x1="0" y1="0" x2="20" y2="20" stroke="{{ $theme_color }}" stroke-width="0.5" opacity="0.1"/>
                            </pattern>
                        </defs>
                        
                        <!-- Box shadow -->
                        <ellipse cx="200" cy="340" rx="120" ry="20" fill="#000000" opacity="0.25"/>
                        
                        <!-- Box Front Face (main body) -->
                        <rect x="80" y="180" width="240" height="160" fill="url(#boxFront)" rx="6" ry="6"/>
                        <rect x="80" y="180" width="240" height="160" fill="url(#boxPattern)" rx="6" ry="6"/>
                        
                        <!-- Box Top Face (lid) - perspective -->
                        <path d="M 80 180 L 320 180 L 340 160 L 100 160 Z" fill="url(#boxTop)"/>
                        <path d="M 80 180 L 320 180 L 340 160 L 100 160 Z" fill="url(#boxPattern)"/>
                        
                        <!-- Box Right Side Face - perspective -->
                        <path d="M 320 180 L 340 160 L 340 320 L 320 340 Z" fill="url(#boxSide)"/>
                        
                        <!-- Lid edge highlight -->
                        <line x1="100" y1="160" x2="340" y2="160" stroke="#ffffff" stroke-width="2" opacity="0.3"/>
                        
                        <!-- Box edge highlights for 3D effect -->
                        <line x1="80" y1="180" x2="80" y2="340" stroke="#ffffff" stroke-width="1.5" opacity="0.2"/>
                        <line x1="320" y1="180" x2="320" y2="340" stroke="#000000" stroke-width="1" opacity="0.15"/>
                        <line x1="80" y1="340" x2="320" y2="340" stroke="#000000" stroke-width="1.5" opacity="0.2"/>
                        
                        <!-- Ribbon Vertical (behind box) -->
                        <rect x="195" y="50" width="12" height="280" fill="url(#ribbonGrad)" rx="2"/>
                        <!-- Ribbon shadow -->
                        <rect x="197" y="50" width="8" height="280" fill="#000000" opacity="0.2" rx="2"/>
                        
                        <!-- Ribbon Horizontal (behind box) -->
                        <rect x="80" y="255" width="240" height="12" fill="url(#ribbonGrad)" rx="2"/>
                        <!-- Ribbon shadow -->
                        <rect x="80" y="257" width="240" height="8" fill="#000000" opacity="0.2" rx="2"/>
                        
                        <!-- Ribbon Vertical (in front) -->
                        <rect x="193" y="180" width="14" height="160" fill="url(#ribbonGrad)" rx="2"/>
                        <!-- Ribbon highlight -->
                        <rect x="194" y="180" width="2" height="160" fill="#ffffff" opacity="0.4" rx="1"/>
                        
                        <!-- Ribbon Horizontal (in front) -->
                        <rect x="80" y="253" width="240" height="14" fill="url(#ribbonGrad)" rx="2"/>
                        <!-- Ribbon highlight -->
                        <rect x="80" y="254" width="240" height="2" fill="#ffffff" opacity="0.4" rx="1"/>
                        
                        <!-- Elegant Bow - Center Knot -->
                        <circle cx="200" cy="80" r="28" fill="url(#bowCenter)"/>
                        <circle cx="200" cy="80" r="22" fill="{{ $theme_color }}dd"/>
                        <circle cx="200" cy="80" r="16" fill="{{ $theme_color }}ff"/>
                        <!-- Bow center highlight -->
                        <ellipse cx="195" cy="75" rx="8" ry="10" fill="#ffffff" opacity="0.5"/>
                        
                        <!-- Bow Left Loop -->
                        <ellipse cx="155" cy="105" rx="32" ry="24" fill="url(#bowLoop)"/>
                        <ellipse cx="155" cy="105" rx="26" ry="18" fill="{{ $theme_color }}ee"/>
                        <ellipse cx="155" cy="105" rx="18" ry="12" fill="{{ $theme_color }}ff"/>
                        <!-- Loop highlight -->
                        <ellipse cx="150" cy="100" rx="12" ry="8" fill="#ffffff" opacity="0.4"/>
                        
                        <!-- Bow Right Loop -->
                        <ellipse cx="245" cy="105" rx="32" ry="24" fill="url(#bowLoop)"/>
                        <ellipse cx="245" cy="105" rx="26" ry="18" fill="{{ $theme_color }}ee"/>
                        <ellipse cx="245" cy="105" rx="18" ry="12" fill="{{ $theme_color }}ff"/>
                        <!-- Loop highlight -->
                        <ellipse cx="250" cy="100" rx="12" ry="8" fill="#ffffff" opacity="0.4"/>
                        
                        <!-- Ribbon ends - left -->
                        <path d="M 80 253 L 70 243 L 70 263 L 80 253" fill="{{ $theme_color }}dd"/>
                        <path d="M 70 243 L 65 248 L 70 253 L 75 248 Z" fill="{{ $theme_color }}bb"/>
                        
                        <!-- Ribbon ends - right -->
                        <path d="M 320 253 L 330 243 L 330 263 L 320 253" fill="{{ $theme_color }}dd"/>
                        <path d="M 330 243 L 325 248 L 330 253 L 335 248 Z" fill="{{ $theme_color }}bb"/>
                        
                        <!-- Shine reflections on box -->
                        <ellipse cx="140" cy="220" rx="50" ry="80" fill="#ffffff" opacity="0.2"/>
                        <ellipse cx="260" cy="220" rx="50" ry="80" fill="#ffffff" opacity="0.15"/>
                        <ellipse cx="200" cy="260" rx="80" ry="25" fill="#ffffff" opacity="0.12"/>
                        
                        <!-- Corner highlights -->
                        <circle cx="90" cy="190" r="3" fill="#ffffff" opacity="0.6"/>
                        <circle cx="310" cy="190" r="3" fill="#ffffff" opacity="0.6"/>
                        <circle cx="90" cy="330" r="3" fill="#ffffff" opacity="0.4"/>
                        <circle cx="310" cy="330" r="3" fill="#ffffff" opacity="0.4"/>
                    </svg>
                </div>
            </div>
            
            <p class="text-gray-700 text-xl md:text-2xl font-bold mt-8 drop-shadow-lg animate-pulse theme-color" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                Click the gift box to open your memory! 🎁
            </p>
        </div>
    </div>
    
    <script>
        // Create confetti with variety
        function createConfetti() {
            const container = document.getElementById('confetti-container');
            const themeColor = '{{ $theme_color }}';
            const colors = [themeColor, themeColor + 'cc', themeColor + '99', '#ffd700', '#ffffff', '#ff6b9d'];
            const shapes = ['circle', 'triangle', 'star'];
            
            for (let i = 0; i < 80; i++) {
                const confetti = document.createElement('div');
                const shape = shapes[Math.floor(Math.random() * shapes.length)];
                confetti.className = 'confetti ' + shape;
                
                if (shape === 'circle') {
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                } else if (shape === 'triangle') {
                    confetti.style.borderLeftColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRightColor = 'transparent';
                    confetti.style.borderBottomColor = colors[Math.floor(Math.random() * colors.length)];
                } else if (shape === 'star') {
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                }
                
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (2 + Math.random() * 3) + 's';
                confetti.style.width = (8 + Math.random() * 8) + 'px';
                confetti.style.height = confetti.style.width;
                container.appendChild(confetti);
            }
        }
        
        // Create sparkles
        function createSparkles() {
            const container = document.getElementById('sparkles-container');
            
            setInterval(() => {
                const sparkle = document.createElement('div');
                sparkle.className = 'sparkle';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.animationDelay = Math.random() * 2 + 's';
                sparkle.style.width = (6 + Math.random() * 4) + 'px';
                sparkle.style.height = sparkle.style.width;
                container.appendChild(sparkle);
                
                setTimeout(() => {
                    sparkle.remove();
                }, 3000);
            }, 300);
        }
        
        // Open gift function with enhanced animation
        function openGift() {
            const giftBox = document.getElementById('gift-box');
            
            // Disable further clicks
            giftBox.style.pointerEvents = 'none';
            
            // Enhanced opening animation
            giftBox.style.animation = 'bounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            
            // Create explosion of confetti
            for (let i = 0; i < 3; i++) {
                setTimeout(() => {
                    createConfetti();
                }, i * 200);
            }
            
            // Add rotation effect
            let rotation = 0;
            const rotateInterval = setInterval(() => {
                rotation += 15;
                giftBox.style.transform = `rotate(${rotation}deg) scale(1.2)`;
            }, 50);
            
            // Redirect after animation
            setTimeout(() => {
                clearInterval(rotateInterval);
                window.location.href = '{{ route("templates.show", $slug) }}';
            }, 1000);
        }
        
        // Initialize animations
        createConfetti();
        createSparkles();
    </script>
</body>
</html>

