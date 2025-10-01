<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin:0; padding:0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        p { color: #555; }
        .otp { font-size: 24px; font-weight: bold; color: #2e86de; }
        .footer { margin-top: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset OTP</h2>
        <p>Hello,</p>
        <p>Your OTP for password reset is:</p>
        <p class="otp">{{ $otp }}</p>
        <p>This OTP is valid for 10 minutes. If you did not request a password reset, please ignore this email.</p>
        <div class="footer">
            &copy; {{ date('Y') }} Your App. All rights reserved.
        </div>
    </div>
</body>
</html>
