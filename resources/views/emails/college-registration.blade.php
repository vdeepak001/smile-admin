<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        .wrapper {
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }

        .greeting strong {
            color: #667eea;
            font-weight: 600;
        }

        .intro-text {
            font-size: 15px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .credentials-section {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 25px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .credential-item {
            margin-bottom: 20px;
        }

        .credential-item:last-child {
            margin-bottom: 0;
        }

        .credential-label {
            color: #667eea;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            display: block;
            margin-bottom: 8px;
        }

        .credential-value {
            font-size: 16px;
            color: #333;
            font-family: 'Courier New', monospace;
            background-color: #fff;
            padding: 12px;
            border-radius: 4px;
            word-break: break-all;
            font-weight: 500;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 50px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .security-notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 6px;
            margin: 30px 0;
        }

        .security-notice h3 {
            color: #856404;
            font-size: 14px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .security-notice ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .security-notice li {
            color: #856404;
            font-size: 13px;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }

        .security-notice li:before {
            content: "•";
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        .divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 30px 0;
        }

        .support-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e5e5;
        }

        .footer-text {
            font-size: 13px;
            color: #999;
            margin: 0;
        }

        .footer-text strong {
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>Welcome to {{ config('app.name') }}</h1>
                <p>College Management System</p>
            </div>

            <!-- Content -->
            <div class="content">
                <p class="greeting">
                    Hi <strong>{{ $contactPerson }}</strong>,
                </p>

                <p class="intro-text">
                    Your college account has been successfully created in our system. Below you'll find your login
                    credentials to get started.
                </p>

                <!-- Credentials Section -->
                <div class="credentials-section">
                    <div class="credential-item">
                        <span class="credential-label">College Name</span>
                        <div class="credential-value">{{ $collegeName }}</div>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">Login Email</span>
                        <div class="credential-value">{{ $email }}</div>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">Password</span>
                        <div class="credential-value">{{ $password }}</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="button-container">
                    <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
                </div>

                <!-- Divider -->
                <div class="divider"></div>



                <!-- Support Info -->
                <p class="support-text">
                    If you have any questions or need assistance, our support team is here to help. Feel free to reach
                    out to us anytime.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p class="footer-text">
                    Best regards,<br>
                    <strong>{{ config('app.name') }} Team</strong>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
