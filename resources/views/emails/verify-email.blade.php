<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Hamro Yaad</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        .email-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 50%, #4ecdc4 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 20px;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        
        .verify-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
        }
        
        .verify-button:hover {
            background: linear-gradient(135deg, #ff5252 0%, #ff6b6b 100%);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            transform: translateY(-2px);
        }
        
        .link-fallback {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #ff6b6b;
        }
        
        .link-fallback p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .link-fallback a {
            color: #ff6b6b;
            word-break: break-all;
            text-decoration: none;
        }
        
        .link-fallback a:hover {
            text-decoration: underline;
        }
        
        .footer {
            background-color: #1e293b;
            color: #cbd5e1;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .footer p {
            margin-bottom: 10px;
        }
        
        .footer a {
            color: #ff6b6b;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e0e0e0, transparent);
            margin: 30px 0;
        }
        
        .info-box {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(78, 205, 196, 0.1) 100%);
            border-left: 4px solid #ff6b6b;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .info-box p {
            color: #555;
            font-size: 14px;
            margin: 0;
        }
        
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .verify-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="{{ config('app.url') }}/assets/stabndard.png" alt="Hamro Yaad" class="logo" onerror="this.style.display='none'">
            <h1>Verify Your Email</h1>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Hello {{ $user->name }}! 👋
            </div>
            
            <div class="message">
                Thank you for registering with <strong>Hamro Yaad</strong>! We're excited to have you on board.
            </div>
            
            <div class="message">
                To complete your registration and start creating beautiful memories, please verify your email address by clicking the button below:
            </div>
            
            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="verify-button">
                    Verify Email Address
                </a>
            </div>
            
            <div class="divider"></div>
            
            <div class="info-box">
                <p>
                    <strong>⚠️ Important:</strong> This verification link will expire in 60 minutes. If you didn't create an account, please ignore this email.
                </p>
            </div>
            
            <div class="link-fallback">
                <p><strong>Button not working?</strong> Copy and paste this link into your browser:</p>
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Hamro Yaad</strong></p>
            <p>Create beautiful memories and gift websites</p>
            <p style="margin-top: 20px;">
                <a href="{{ url('/') }}">Visit Website</a> | 
                <a href="{{ url('/terms') }}">Terms & Conditions</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #94a3b8;">
                This email was sent to {{ $user->email }}. If you didn't request this, please ignore it.
            </p>
        </div>
    </div>
</body>
</html>

