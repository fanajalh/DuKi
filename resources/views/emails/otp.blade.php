<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Nunito', Arial, sans-serif; background: #f1f5f9; margin: 0; padding: 20px; }
        .container { max-width: 400px; margin: 0 auto; background: #fffbeb; border: 4px solid #1e293b; border-radius: 24px; overflow: hidden; box-shadow: 6px 6px 0px 0px #1e293b; }
        .header { background: #f472b6; border-bottom: 4px solid #1e293b; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 900; color: #1e293b; }
        .header p { margin: 4px 0 0; font-weight: 700; color: #1e293b; font-size: 14px; }
        .body { padding: 32px 24px; text-align: center; }
        .body p { color: #334155; font-weight: 700; font-size: 15px; margin-bottom: 16px; }
        .otp-box { background: white; border: 4px solid #1e293b; border-radius: 16px; padding: 20px; display: inline-block; margin: 16px 0; box-shadow: 4px 4px 0px 0px #1e293b; }
        .otp-code { font-size: 36px; font-weight: 900; color: #e11d48; letter-spacing: 8px; margin: 0; }
        .warning { background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 12px; margin-top: 16px; font-size: 12px; color: #92400e; font-weight: 700; }
        .footer { background: #f1f5f9; border-top: 4px solid #1e293b; padding: 16px; text-align: center; font-size: 11px; color: #64748b; font-weight: 700; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐷 DuKi App</h1>
            <p>Reset Kata Sandi</p>
        </div>
        <div class="body">
            <p>Halo! Kamu baru saja meminta kode OTP untuk mereset kata sandi akun DuKi-mu.</p>
            <p>Masukkan kode di bawah ini:</p>
            <div class="otp-box">
                <p class="otp-code">{{ $otp }}</p>
            </div>
            <div class="warning">
                ⚠️ Kode ini berlaku selama 15 menit. Jangan bagikan kode ini ke siapapun ya!
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} DuKi - Duo & Kita. Nabung Bareng, Senyum Terus! 💖
        </div>
    </div>
</body>
</html>
