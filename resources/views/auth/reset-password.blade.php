<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setel Ulang Kata Sandi - Day Challenge</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS with custom theme config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            500: '#8b5cf6', // premium purple/violet
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        orange: {
                            500: '#f97316',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #f97316 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col lg:flex-row">

    <!-- Left Side: Reset Password Form (50% width on large screens) -->
    <div class="w-full lg:w-1/2 flex flex-col justify-between p-6 sm:p-12 bg-slate-50/50">
        
        <!-- Header Brand Logo -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="h-6 w-auto" alt="Logo">
            <a href="{{ route('landing') }}" class="font-extrabold text-sm text-slate-800 hover:text-primary-600 transition-colors">Day Challenge</a>
        </div>

        <!-- Center Card container -->
        <div class="my-auto py-8 flex justify-center">
            <div class="w-full max-w-[390px] bg-white p-8 rounded-3xl border border-slate-200/50 shadow-md space-y-6">
                
                <div class="space-y-1.5">
                    <h1 class="text-[22px] font-black text-slate-900 tracking-tight leading-none">Verifikasi & Pembaruan</h1>
                    <p class="text-[11px] text-slate-400 font-semibold leading-relaxed">Masukkan kode OTP 6-digit dari Gmail Anda untuk mengatur ulang sandi</p>
                </div>

                <!-- Success feedback system -->
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 p-3 rounded-2xl text-[10px] font-semibold flex items-start gap-1.5 shadow-sm">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Error validation lists -->
                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-100 text-rose-800 p-3 rounded-2xl text-[10px] font-semibold space-y-1">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-500"></i>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Actual Form Fields -->
                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Prefilled Email (Readonly) -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-[11px] font-bold text-slate-700 block">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" readonly required class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-xs font-semibold outline-none text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- OTP Code field (6 digits) -->
                    <div class="space-y-1.5">
                        <label for="otp" class="text-[11px] font-bold text-slate-700 block">Kode OTP 6-Digit</label>
                        <div class="relative">
                            <i data-lucide="key-round" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="otp" id="otp" maxlength="6" required placeholder="Contoh: 123456" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-3 pl-11 pr-4 text-xs font-bold text-center tracking-[0.25em] outline-none text-slate-800 transition-colors">
                        </div>
                    </div>

                    <!-- Password field -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-[11px] font-bold text-slate-700 block">Password Baru</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="password" id="password" required placeholder="Masukkan password (min 6 karakter)" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-3 pl-11 pr-11 text-xs font-semibold outline-none text-slate-800 transition-colors">
                            
                            <!-- Visibility toggle button -->
                            <button type="button" onclick="togglePassword('password', 'eye-icon-1')" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                <i data-lucide="eye" id="eye-icon-1" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password field -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-[11px] font-bold text-slate-700 block">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi password baru" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-3 pl-11 pr-11 text-xs font-semibold outline-none text-slate-800 transition-colors">
                            
                            <!-- Visibility toggle button -->
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2')" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                <i data-lucide="eye" id="eye-icon-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit trigger button -->
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl shadow shadow-primary-500/10 hover:scale-[1.01] transition-transform text-xs flex items-center justify-center gap-1.5">
                        <span>Perbarui Password</span>
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    </button>
                </form>

                <!-- Separator line -->
                <div class="border-t border-slate-100 my-4"></div>

                <!-- Back to forgot password (request new OTP) link -->
                <p class="text-center text-[11px] font-semibold text-slate-500">
                    Tidak menerima kode? <a href="{{ route('password.request') }}" class="text-primary-600 hover:underline font-bold">Kirim ulang OTP</a>
                </p>

            </div>
        </div>

        <!-- Footer terms info -->
        <div class="text-center text-[9px] font-bold text-slate-400">
            &copy; 2026 Day Challenge. Semua Hak Dilindungi.
        </div>
    </div>

    <!-- Right Side: Graphic Split Screen Gradient display (50% width) -->
    <div class="hidden lg:flex w-1/2 gradient-bg items-center justify-center p-12 text-white relative">
        <div class="absolute inset-0 bg-black/5 z-0"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.8px,transparent_0.8px)] [background-size:20px_20px] opacity-10 z-0"></div>

        <div class="relative z-10 flex flex-col items-center justify-center text-center space-y-6 max-w-sm">
            
            <!-- Floating Logo directly without any container box -->
            <div class="hover:scale-[1.03] transition-transform duration-300">
                <img src="{{ asset('images/logo.png') }}" class="w-60 h-auto object-contain" alt="Day Challenge Logo">
            </div>

            <!-- Descriptive labels -->
            <div class="space-y-3">
                <h2 class="text-2xl font-extrabold tracking-tight">Security Verification</h2>
                <p class="text-xs text-white/80 font-medium leading-relaxed">
                    Kami melindungi data dan akun Anda dengan verifikasi kode OTP real-time demi keamanan maksimal.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password toggler script
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            
            // Re-create icons to reflect update
            lucide.createIcons();
        }

        lucide.createIcons();
    </script>
</body>
</html>
