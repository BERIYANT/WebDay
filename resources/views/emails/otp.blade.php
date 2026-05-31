<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Lupa Password - WebDay</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 580px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #f97316 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header img {
            height: 48px;
            width: auto;
            margin-bottom: 12px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 16px;
        }
        .content p {
            font-size: 14px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 24px;
        }
        .otp-container {
            background-color: #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 0.25em;
            color: #7c3aed;
            margin: 0;
            display: inline-block;
            font-family: monospace;
        }
        .note {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            margin-top: 24px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            font-weight: 600;
        }
        .footer a {
            color: #7c3aed;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <!-- Emulated logo standard fallback if image not configured -->
            <h1>WebDay Challenge</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Halo, {{ ucwords($userName) }}!</h2>
            <p>
                Kami menerima permintaan untuk mengatur ulang kata sandi akun WebDay Challenge Anda. Gunakan kode OTP 6-digit di bawah ini untuk memverifikasi identitas Anda:
            </p>

            <!-- OTP Box -->
            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <p>
                *Kode OTP ini **hanya berlaku selama 15 menit**. Demi keamanan akun Anda, jangan pernah membagikan kode ini kepada siapapun.
            </p>

            <div class="note">
                Jika Anda tidak merasa mengajukan pemulihan kata sandi ini, silakan abaikan email ini dengan aman. Kata sandi akun Anda akan tetap terjaga.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2026 WebDay Challenge Platform. Semua Hak Dilindungi.<br>
            Mengubah kebiasaan buruk menjadi kebiasaan baik harian.
        </div>

    </div>

</body>
</html>
