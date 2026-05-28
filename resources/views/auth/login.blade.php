<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Day Challenge</title>
    
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

    <!-- Left Side: Login Form workspace (50% width on large screens) -->
    <div class="w-full lg:w-1/2 flex flex-col justify-between p-6 sm:p-12 bg-slate-50/50">
        
        <!-- Header Brand Logo -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="h-6 w-auto" alt="Logo">
            <span class="font-extrabold text-sm text-slate-800">Day Challenge</span>
        </div>

        <!-- Center Card container -->
        <div class="my-auto py-8 flex justify-center">
            <div class="w-full max-w-[390px] bg-white p-8 rounded-3xl border border-slate-200/50 shadow-md space-y-6">
                
                <div class="space-y-1.5">
                    <h1 class="text-[22px] font-black text-slate-900 tracking-tight leading-none">Selamat Datang Kembali</h1>
                    <p class="text-[11px] text-slate-400 font-semibold leading-relaxed">Masuk ke akun kamu untuk melanjutkan challenge</p>
                </div>

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
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Email field -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-[11px] font-bold text-slate-700 block">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-3 pl-11 pr-4 text-xs font-semibold outline-none text-slate-800 transition-colors">
                        </div>
                    </div>

                    <!-- Password field -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-[11px] font-bold text-slate-700 block">Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-4 top-3.5 w-4 h-4 text-slate-400"></i>
                            <input type="password" name="password" id="password" required placeholder="Masukkan password" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-3 pl-11 pr-11 text-xs font-semibold outline-none text-slate-800 transition-colors">
                            
                            <!-- Visibility toggle button -->
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember check and forgot links -->
                    <div class="flex items-center justify-between text-[11px] font-bold py-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-slate-300 rounded focus:ring-primary-500 bg-white">
                            <span class="text-slate-500">Ingat saya</span>
                        </label>
                        <a href="#" class="text-primary-600 hover:underline">Lupa password?</a>
                    </div>

                    <!-- Submit trigger button -->
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl shadow shadow-primary-500/10 hover:scale-[1.01] transition-transform text-xs flex items-center justify-center gap-1.5">
                        <span>Masuk</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </button>
                </form>

                <!-- Separator line -->
                <div class="relative flex py-1 items-center">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink mx-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">atau lanjutkan dengan</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>

                <!-- Google SSO Button -->
                <a href="{{ route('auth.google') }}" class="w-full border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2.5 text-xs">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24">
                        <path fill="#ea4335" d="M12 5.04c1.67 0 3.12.57 4.3 1.7l3.2-3.2C17.56 1.7 14.97 1 12 1 7.37 1 3.4 3.67 1.48 7.57l3.78 2.93C6.2 7.23 8.87 5.04 12 5.04z"/>
                        <path fill="#4285f4" d="M23.49 12.27c0-.82-.07-1.61-.21-2.38H12v4.51h6.46c-.28 1.47-1.11 2.71-2.36 3.55l3.66 2.84c2.14-1.97 3.37-4.87 3.37-8.52z"/>
                        <path fill="#fbbc05" d="M5.26 14.66c-.24-.72-.38-1.5-.38-2.3s.14-1.58.38-2.3L1.48 7.13C.53 9.07 0 11.23 0 13.5s.53 4.43 1.48 6.37l3.78-2.93z"/>
                        <path fill="#34a853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.66-2.84c-1.1.74-2.51 1.18-4.3 1.18-3.13 0-5.8-2.19-6.74-5.46L1.48 15.9C3.4 19.8 7.37 23 12 23z"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <!-- Register route link -->
                <p class="text-center text-[11px] font-semibold text-slate-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-primary-600 hover:underline font-bold">Daftar sekarang</a>
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
                <h2 class="text-2xl font-extrabold tracking-tight">Grow Every Day</h2>
                <p class="text-xs text-white/80 font-medium leading-relaxed">
                    Mulai perjalanan pengembangan dirimu dengan challenge interaktif dan komunitas suportif.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password toggler script
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
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
