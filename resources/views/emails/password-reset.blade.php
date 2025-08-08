<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - Joaz Hair</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #212121;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);
            padding: 30px;
            text-align: center;
        }
        .logo {
            width: 60px;
            height: 70px;
            margin: 0 auto 20px;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #212121;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #666666;
            line-height: 1.8;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }
        .reset-button:hover {
            opacity: 0.9;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #666666;
            font-size: 14px;
        }
        .link {
            color: #85BB3F;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-2.png') }}" alt="Joaz Hair" class="logo">
            <h1>Reset Your Password</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $data['name'] ?? 'there' }},
            </div>
            
            <div class="message">
                We received a request to reset your password for your Joaz Hair account. If you didn't make this request, you can safely ignore this email.
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $data['reset_url'] }}" class="reset-button">
                    Reset Password
                </a>
            </div>
            
            <div class="warning">
                <strong>Important:</strong> This password reset link will expire in 60 minutes. If you need a new link, please request another password reset.
            </div>
            
            <div class="message">
                If the button above doesn't work, you can copy and paste the following link into your browser:
                <br><br>
                <a href="{{ $data['reset_url'] }}" class="link">{{ $data['reset_url'] }}</a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Joaz Hair Extensions</strong></p>
            <p>Shop No BPF14, First Floor, Old Banex Plaza Wuse 2, Abuja, Nigeria</p>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; 2025 Joaz Hair Extension. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 