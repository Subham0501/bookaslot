<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter PIN - Hamro Yaad</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* Floating Particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* PIN Input Boxes */
        .pin-box {
            width: 60px;
            height: 70px;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            color: white;
            transition: all 0.3s ease;
        }

        .pin-box:focus {
            outline: none;
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
        }

        .pin-box.filled {
            background: rgba(255, 107, 107, 0.3);
            border-color: #ff6b6b;
        }

        /* Shimmer Effect */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        /* Pulse Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Bounce Animation */
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .bounce {
            animation: bounce 2s infinite;
        }

        /* Error Shake */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .shake {
            animation: shake 0.5s;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <!-- Floating Particles -->
        <div class="particle" style="width: 80px; height: 80px; left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="width: 120px; height: 120px; left: 20%; animation-delay: 2s;"></div>
        <div class="particle" style="width: 60px; height: 60px; left: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="width: 100px; height: 100px; left: 50%; animation-delay: 6s;"></div>
        <div class="particle" style="width: 90px; height: 90px; left: 70%; animation-delay: 8s;"></div>
        <div class="particle" style="width: 70px; height: 70px; left: 80%; animation-delay: 10s;"></div>
        <div class="particle" style="width: 110px; height: 110px; left: 90%; animation-delay: 12s;"></div>
    </div>

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="glass-card rounded-3xl p-8 md:p-12 max-w-lg w-full relative overflow-hidden">
            <!-- Shimmer Overlay -->
            <div class="shimmer absolute inset-0 rounded-3xl pointer-events-none"></div>
            
            <!-- Content -->
            <div class="relative z-10">
                <!-- Logo and Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center items-center gap-3 mb-6">
                        <img src="{{ asset('assets/logo.png') }}" alt="Hamro Yaad" class="h-16 md:h-20 w-auto bounce">
                        <span class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-pink-200 bg-clip-text text-transparent">Hamro Yaad</span>
                    </div>
                    
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-[#ff6b6b] to-[#ff5252] rounded-3xl flex items-center justify-center shadow-2xl shadow-[#ff6b6b]/50 pulse">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-white mb-3 tracking-tight">
                        Unlock Your Memory
                    </h1>
                    @if($recipient_name)
                        <p class="text-lg text-white/90 mb-2">
                            This special memory is for
                        </p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] bg-clip-text text-transparent">
                            {{ $recipient_name }}
                        </p>
                    @else
                        <p class="text-lg text-white/90">
                            Enter the PIN to access this memory
                        </p>
                    @endif
                </div>

                <!-- Error Message -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-500/20 backdrop-filter backdrop-blur-lg border border-red-400/50 rounded-2xl shake">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-red-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-100 text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- PIN Form -->
                <form action="{{ route('templates.verify-pin', $slug) }}" method="POST" class="space-y-8" id="pin-form">
                    @csrf
                    
                    <!-- PIN Input Boxes -->
                    <div class="flex justify-center gap-3 md:gap-4">
                        <input type="text" 
                               id="pin1" 
                               name="pin1" 
                               maxlength="1" 
                               pattern="[0-9]"
                               class="pin-box"
                               autocomplete="off"
                               inputmode="numeric">
                        <input type="text" 
                               id="pin2" 
                               name="pin2" 
                               maxlength="1" 
                               pattern="[0-9]"
                               class="pin-box"
                               autocomplete="off"
                               inputmode="numeric">
                        <input type="text" 
                               id="pin3" 
                               name="pin3" 
                               maxlength="1" 
                               pattern="[0-9]"
                               class="pin-box"
                               autocomplete="off"
                               inputmode="numeric">
                        <input type="text" 
                               id="pin4" 
                               name="pin4" 
                               maxlength="1" 
                               pattern="[0-9]"
                               class="pin-box"
                               autocomplete="off"
                               inputmode="numeric">
                        <input type="text" 
                               id="pin5" 
                               name="pin5" 
                               maxlength="1" 
                               pattern="[0-9]"
                               class="pin-box"
                               autocomplete="off"
                               inputmode="numeric">
                    </div>
                    
                    <!-- Hidden Input for Full PIN -->
                    <input type="hidden" id="pin" name="pin" value="">

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submit-btn"
                            class="w-full px-8 py-5 bg-gradient-to-r from-[#ff6b6b] to-[#ff5252] text-white rounded-2xl hover:shadow-2xl hover:shadow-[#ff6b6b]/50 transition-all font-bold text-lg md:text-xl transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Unlock Memory
                        </span>
                    </button>
                </form>

                <!-- Helper Text -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-white/70">
                        Enter the 5-digit PIN to unlock this special memory
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-8 text-center">
                    <a href="/" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pinInputs = ['pin1', 'pin2', 'pin3', 'pin4', 'pin5'];
        const hiddenPinInput = document.getElementById('pin');
        const form = document.getElementById('pin-form');
        const submitBtn = document.getElementById('submit-btn');

        // Initialize
        pinInputs.forEach((id, index) => {
            const input = document.getElementById(id);
            
            // Focus first input on load
            if (index === 0) {
                setTimeout(() => input.focus(), 100);
            }

            // Only allow numbers
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value) {
                    this.classList.add('filled');
                    // Move to next input
                    if (index < pinInputs.length - 1) {
                        document.getElementById(pinInputs[index + 1]).focus();
                    }
                } else {
                    this.classList.remove('filled');
                }
                
                updateHiddenPin();
                checkPinComplete();
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    document.getElementById(pinInputs[index - 1]).focus();
                    document.getElementById(pinInputs[index - 1]).value = '';
                    document.getElementById(pinInputs[index - 1]).classList.remove('filled');
                    updateHiddenPin();
                }
            });

            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = (e.clipboardData || window.clipboardData).getData('text');
                const numbers = pastedData.replace(/[^0-9]/g, '').slice(0, 5);
                
                numbers.split('').forEach((num, i) => {
                    if (pinInputs[i]) {
                        const pinInput = document.getElementById(pinInputs[i]);
                        pinInput.value = num;
                        pinInput.classList.add('filled');
                    }
                });
                
                updateHiddenPin();
                checkPinComplete();
                
                // Focus last filled or next empty
                const lastFilledIndex = Math.min(numbers.length - 1, pinInputs.length - 1);
                if (lastFilledIndex < pinInputs.length - 1) {
                    document.getElementById(pinInputs[lastFilledIndex + 1]).focus();
                } else {
                    document.getElementById(pinInputs[pinInputs.length - 1]).focus();
                }
            });
        });

        function updateHiddenPin() {
            const pin = pinInputs.map(id => document.getElementById(id).value).join('');
            hiddenPinInput.value = pin;
        }

        function checkPinComplete() {
            const pin = hiddenPinInput.value;
            if (pin.length === 5) {
                submitBtn.disabled = false;
                // Auto-submit after a short delay
                setTimeout(() => {
                    if (hiddenPinInput.value.length === 5) {
                        form.submit();
                    }
                }, 500);
            } else {
                submitBtn.disabled = true;
            }
        }

        // Disable submit button initially
        submitBtn.disabled = true;

        // Handle form submission
        form.addEventListener('submit', function(e) {
            const pin = hiddenPinInput.value;
            if (pin.length !== 5) {
                e.preventDefault();
                // Shake animation
                pinInputs.forEach(id => {
                    document.getElementById(id).classList.add('shake');
                    setTimeout(() => {
                        document.getElementById(id).classList.remove('shake');
                    }, 500);
                });
                return false;
            }
        });
    </script>
</body>
</html>
