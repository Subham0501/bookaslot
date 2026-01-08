<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Success - Hamro Yaad</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(45deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.2) rotate(45deg);
            }
            100% {
                transform: scale(1) rotate(45deg);
                opacity: 1;
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .checkmark {
            animation: checkmark 0.6s ease-in-out;
        }
        
        .message-content {
            animation: fadeIn 0.8s ease-in-out 0.3s both;
        }
        
        body {
            background: linear-gradient(135deg, {{ $customizedTemplate->theme_color ?? '#667eea' }}15 0%, {{ $customizedTemplate->theme_color ?? '#764ba2' }}05 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 max-w-lg w-full">
        <div class="text-center">
            <!-- Success Icon -->
            <div class="w-24 h-24 mx-auto mb-6 relative">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                    <svg class="w-12 h-12 text-white checkmark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Success Message -->
            <div class="message-content">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    🎉 Success! 🎉
                </h1>
                
                @if($customizedTemplate->recipient_name)
                <p class="text-xl md:text-2xl font-semibold mb-6" style="color: {{ $customizedTemplate->theme_color ?? '#667eea' }};">
                    {{ $customizedTemplate->recipient_name }}
                </p>
                @endif
                
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 mb-6 border-2" style="border-color: {{ $customizedTemplate->theme_color ?? '#667eea' }}30;">
                    <p class="text-lg md:text-xl text-gray-700 mb-4 leading-relaxed">
                        Your memory URL has been generated successfully!
                    </p>
                    <p class="text-base md:text-lg text-gray-600 mb-6">
                        To purchase and activate your memory page, please contact us via WhatsApp.
                    </p>
                    
                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/9779845004365?text=Hi, I want to purchase my memory page" 
                       target="_blank"
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg transition-all font-semibold text-lg mb-4">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Contact via WhatsApp
                    </a>
                </div>
                
                <p class="text-sm text-gray-500 mb-6">
                    Your memory page is ready! Contact us to make it live.
                </p>
                
                <!-- Optional: Link to view the page (if admin has approved) -->
                @if($customizedTemplate->status === 'published')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('templates.show', $slug) }}" 
                       class="inline-block px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        View Memory Page →
                    </a>
                </div>
                @endif
            </div>
            
            <div class="mt-8 text-center">
                <a href="/" class="text-gray-500 hover:text-gray-700 text-sm">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>

