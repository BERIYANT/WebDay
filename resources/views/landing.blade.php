<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Day Challenge - Transform Your Habits Into Challenges</title>
    
    <!-- Compelling SEO Meta Tags -->
    <meta name="description" content="Web Day Challenge membantu pengguna membangun kebiasaan positif melalui challenge harian interaktif, AI reminder, leaderboard, dan komunitas suportif.">
    <meta name="keywords" content="webday, habit challenge, daily challenge, kebiasaan positif, produktivitas, pengembangan diri">
    <meta name="author" content="WebDay Challenge Team">
    
    <!-- Open Graph (OG) Meta Tags for Social Media and Search Engine Previews -->
    <meta property="og:title" content="Web Day Challenge - Transform Your Habits Into Challenges">
    <meta property="og:description" content="Mulai bangun kebiasaan positif harian Anda bersama WebDay Challenge secara interaktif dan menyenangkan.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Web Day Challenge - Transform Your Habits Into Challenges">
    <meta name="twitter:description" content="Mulai bangun kebiasaan positif harian Anda bersama WebDay Challenge secara interaktif dan menyenangkan.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Favicon and Logo Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
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
                            100: '#ede9fe',
                            500: '#8b5cf6', // premium purple/violet
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
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
        .hero-gradient {
            background: radial-gradient(circle at 10% 20%, rgba(139, 92, 246, 0.08) 0%, rgba(249, 115, 22, 0.04) 90.1%);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.9; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 4s infinite ease-in-out;
        }

        /* FAQ Accordion Transitions */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
            opacity: 0;
        }
        .faq-active .faq-answer {
            max-height: 250px;
            opacity: 1;
            padding-top: 12px;
        }
        .faq-chevron {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .faq-active .faq-chevron {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-white text-slate-800 selection:bg-primary-100 selection:text-primary-700 min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 py-4 md:px-12 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto" alt="Logo">
            <div class="flex flex-col">
                <span class="font-black text-xl leading-none bg-gradient-to-r from-primary-600 to-orange-500 bg-clip-text text-transparent">Web Day</span>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Challenge Platform</span>
            </div>
        </a>

        <!-- Desktop Menu links -->
        <div class="hidden lg:flex items-center gap-1 font-semibold text-slate-600 text-sm">
            <a href="#home" class="px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-primary-50 transition-all">Home</a>
            <a href="#about" class="px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-primary-50 transition-all">Tentang Kami</a>
            <a href="{{ route('login') }}" title="Login untuk akses Challenge" class="group px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-primary-50 transition-all flex items-center gap-1.5">
                Challenge
                <span class="w-3.5 h-3.5 bg-slate-200 group-hover:bg-primary-100 rounded-full flex items-center justify-center transition-colors">
                    <i data-lucide="lock" class="w-2 h-2 text-slate-400 group-hover:text-primary-500"></i>
                </span>
            </a>
            <a href="{{ route('login') }}" title="Login untuk akses Community" class="group px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-primary-50 transition-all flex items-center gap-1.5">
                Community
                <span class="w-3.5 h-3.5 bg-slate-200 group-hover:bg-primary-100 rounded-full flex items-center justify-center transition-colors">
                    <i data-lucide="lock" class="w-2 h-2 text-slate-400 group-hover:text-primary-500"></i>
                </span>
            </a>
            <a href="{{ route('login') }}" title="Login untuk akses Leaderboard" class="group px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-primary-50 transition-all flex items-center gap-1.5">
                Leaderboard
                <span class="w-3.5 h-3.5 bg-slate-200 group-hover:bg-primary-100 rounded-full flex items-center justify-center transition-colors">
                    <i data-lucide="lock" class="w-2 h-2 text-slate-400 group-hover:text-primary-500"></i>
                </span>
            </a>
            <a href="{{ route('login') }}" title="Login untuk akses Premium" class="group px-3 py-2 rounded-lg hover:text-orange-600 hover:bg-orange-50 transition-all flex items-center gap-1.5">
                <i data-lucide="crown" class="w-3.5 h-3.5 text-orange-400 group-hover:text-orange-500 transition-colors"></i>
                Premium
                <span class="w-3.5 h-3.5 bg-slate-200 group-hover:bg-orange-100 rounded-full flex items-center justify-center transition-colors">
                    <i data-lucide="lock" class="w-2 h-2 text-slate-400 group-hover:text-orange-500"></i>
                </span>
            </a>
        </div>

        <!-- Call to Action Buttons -->
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-semibold px-4 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="text-sm font-bold bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/20 hover:scale-[1.02] transition-all">Daftar Sekarang</a>
        </div>
    </nav>

    <!-- Main Content Grid -->
    <main class="flex-grow">
        
        <!-- Full-bleed Hero Section Wrapper (No margins, background goes all the way to the edges) -->
        <div class="w-full hero-gradient border-b border-slate-100">
            <section id="home" class="px-6 py-16 md:px-12 md:py-24 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-50 to-orange-50 border border-primary-100 px-3.5 py-1.5 rounded-full">
                        <i data-lucide="sparkles" class="w-4 h-4 text-primary-500 animate-spin"></i>
                        <span class="text-xs font-bold text-primary-700 uppercase tracking-wider">Self Development Gamification Platform</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight tracking-tight">
                        Transform Your Habits Into <span class="bg-gradient-to-r from-primary-600 to-orange-500 bg-clip-text text-transparent">Challenges</span>
                    </h1>
                    <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-lg">
                        Web Day Challenge membantu pengguna membangun kebiasaan positif melalui challenge interaktif, AI reminder, leaderboard, dan komunitas suportif.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto text-center font-bold bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white px-8 py-4 rounded-2xl shadow-xl shadow-primary-500/20 hover:scale-[1.03] transition-all flex items-center justify-center gap-2">
                            <span>Mulai Challenge</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="{{ route('register') }}" class="w-full sm:w-auto text-center font-bold border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 px-8 py-3.5 rounded-2xl text-slate-700 transition-all">
                            <span>Gabung Sekarang</span>
                        </a>
                    </div>
                </div>

                <!-- Premium Illustration (Updated purpleOrangeGrad matching the dashboard gradient!) -->
                <div class="relative flex items-center justify-center">
                    <div class="absolute w-72 h-72 md:w-96 md:h-96 bg-primary-300/10 rounded-full blur-3xl -top-10 -left-10 z-0"></div>
                    <div class="absolute w-72 h-72 md:w-96 md:h-96 bg-orange-300/10 rounded-full blur-3xl -bottom-10 -right-10 z-0"></div>
                    
                    <!-- Wrapper with drop-shadow and pulse animation to prevent browser SVG shadow clipping -->
                    <div class="w-full max-w-[450px] relative z-10 drop-shadow-2xl animate-pulse-slow p-4">
                        <svg viewBox="0 0 500 500" class="w-full h-auto">
                            <!-- Background Card Shell -->
                            <rect x="30" y="30" width="440" height="440" rx="36" fill="#ffffff" stroke="#f1f5f9" stroke-width="6"/>
                            <rect x="50" y="50" width="400" height="180" rx="24" fill="url(#purpleOrangeGrad)" opacity="0.95"/>
                            
                            <!-- Dashboard Details -->
                            <text x="80" y="100" fill="#ffffff" font-family="Plus Jakarta Sans" font-size="22" font-weight="900">Web Day Dashboard</text>
                            <text x="80" y="130" fill="#ffffff" font-family="Plus Jakarta Sans" font-size="13" font-weight="500" opacity="0.8">Level 4 Challenger • 15 Hari Streak</text>
                            
                            <!-- Progress Bar Circle -->
                            <circle cx="350" cy="130" r="45" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="8"/>
                            <circle cx="350" cy="130" r="45" fill="none" stroke="#ffffff" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="70" stroke-linecap="round"/>
                            <text x="350" y="135" text-anchor="middle" fill="#ffffff" font-family="Plus Jakarta Sans" font-weight="900" font-size="16">75%</text>
                            
                            <!-- Stats Badges -->
                            <rect x="75" y="160" width="100" height="32" rx="16" fill="rgba(255,255,255,0.15)" />
                            <text x="125" y="180" text-anchor="middle" fill="#ffffff" font-family="Plus Jakarta Sans" font-weight="800" font-size="11">Total Poin: 480</text>

                            <!-- Bottom Category Tasks -->
                            <rect x="60" y="260" width="380" height="50" rx="16" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1.5"/>
                            <circle cx="90" cy="285" r="12" fill="#7c3aed"/>
                            <path d="M85 285l3 3 7-7" stroke="#ffffff" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <text x="120" y="289" fill="#1e293b" font-family="Plus Jakarta Sans" font-weight="700" font-size="13">Home Full Body Workout</text>
                            <rect x="360" y="272" width="60" height="24" rx="12" fill="#ede9fe"/>
                            <text x="390" y="288" text-anchor="middle" fill="#7c3aed" font-family="Plus Jakarta Sans" font-weight="800" font-size="10">+30 Pts</text>

                            <rect x="60" y="325" width="380" height="50" rx="16" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1.5"/>
                            <circle cx="90" cy="350" r="12" fill="none" stroke="#cbd5e1" stroke-width="2"/>
                            <text x="120" y="354" fill="#1e293b" font-family="Plus Jakarta Sans" font-weight="700" font-size="13">Gratitude Journaling</text>
                            <rect x="360" y="337" width="60" height="24" rx="12" fill="#fff7ed"/>
                            <text x="390" y="353" text-anchor="middle" fill="#c2410c" font-family="Plus Jakarta Sans" font-weight="800" font-size="10">+20 Pts</text>

                            <rect x="60" y="390" width="380" height="50" rx="16" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1.5"/>
                            <circle cx="90" cy="415" r="12" fill="none" stroke="#cbd5e1" stroke-width="2"/>
                            <text x="120" y="419" fill="#1e293b" font-family="Plus Jakarta Sans" font-weight="700" font-size="13">Fokus Belajar 45 Menit</text>
                            <rect x="360" y="402" width="60" height="24" rx="12" fill="#ede9fe"/>
                            <text x="390" y="418" text-anchor="middle" fill="#7c3aed" font-family="Plus Jakarta Sans" font-weight="800" font-size="10">+40 Pts</text>

                            <!-- Definitions -->
                            <defs>
                                <linearGradient id="purpleOrangeGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#7c3aed" />
                                    <stop offset="100%" stop-color="#f97316" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </section>
        </div>

        <!-- Feature cards grid section -->
        <section id="features" class="py-20 bg-slate-50 px-6 md:px-12">
            <div class="max-w-7xl mx-auto space-y-12">
                <div class="text-center space-y-4">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Fitur Unggulan Platform</h2>
                    <p class="text-slate-500 font-medium max-w-xl mx-auto">Kami menyediakan ekosistem terlengkap untuk membantumu berkembang menjadi versi terbaik setiap harinya secara konsisten.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Card 1: AI Reminder -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="brain-circuit" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">AI Reminder</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            AI memberikan notifikasi motivasi personal dan pengingat harian agar Anda tetap disiplin menulis jurnal serta menjaga streak.
                        </p>
                    </div>

                    <!-- Card 2: Progress Partner -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="users-2" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Progress Partner</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Hubungkan akunmu dengan partner pertanggungjawaban. Saling pantau aktivitas, semangati satu sama lain, dan chat interaktif.
                        </p>
                    </div>

                    <!-- Card 3: Daily Challenge -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="calendar" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Daily Challenge</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Challenge seru di bidang olahraga, pengembangan diri, dan fokus produktif harian yang dirancang mendidik.
                        </p>
                    </div>

                    <!-- Card 4: Journaling -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="book-open" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Journaling</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Tulis pemikiranmu, ekspresikan rasa syukur, dan catat mood harianmu untuk menjaga kesehatan emosional dan mental.
                        </p>
                    </div>

                    <!-- Card 5: Leaderboard -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="trending-up" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Leaderboard</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Buktikan konsistensimu! Raih skor tertinggi dan bersainglah sehat dengan ribuan pengguna lain di papan peringkat global.
                        </p>
                    </div>

                    <!-- Card 6: Reward Point -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="gem" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Reward Point</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Tiap penyelesaian challenge menambahkan poin yang dapat ditukar langsung dengan akses premium bulanan atau badge profil.
                        </p>
                    </div>

                    <!-- Card 7: Premium Access -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="crown" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Premium Access</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Buka visualisasi statistik tingkat lanjut, video eksklusif, analisis mental AI detail, dan fitur lencana spesial.
                        </p>
                    </div>

                    <!-- Card 8: Community Support -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm card-hover transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                            <i data-lucide="messages-square" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900">Community Support</h3>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">
                            Bagikan kisah sukses, inspirasi pagi hari, diskusikan kemajuan, dan dapatkan umpan balik positif dari teman komunitas suportif.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Concept Explanations -->
        <section id="concept" class="py-20 max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="space-y-6">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Mekanisme & Metodologi Sukses Kami</h2>
                <p class="text-slate-500 font-medium leading-relaxed">
                    Web Day Challenge bukan sekadar checklist biasa. Kami menerapkan prinsip sains psikologi perilaku terbaru untuk memastikan Anda bertumbuh tanpa merasa jenuh.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary-50 text-primary-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="gamepad-2" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Gamifikasi Murni</h4>
                            <p class="text-xs text-slate-400 font-medium mt-1 leading-relaxed">Merubah kebiasaan menjemukan menjadi petualangan berlevel dengan reward gem/points yang memicu hormon dopamin positif.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Akuntabilitas Sosial & Partner</h4>
                            <p class="text-xs text-slate-400 font-medium mt-1 leading-relaxed">Memanfaatkan efek akuntabilitas (sosial) dengan menunjuk partner progress. Peluang pencapaian tujuan naik hingga 95%!</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary-50 text-primary-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="bot" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">AI Personal Reminder</h4>
                            <p class="text-xs text-slate-400 font-medium mt-1 leading-relaxed">Pengingat pintar berbasis AI yang memantau waktu tidur, latihan, dan jurnal lalu memotivasi Anda pada momen yang tepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Image Graphics placeholder -->
            <div class="bg-gradient-to-tr from-slate-100 to-slate-200/50 p-6 rounded-[36px] border border-slate-200/60 shadow-sm relative overflow-hidden flex justify-center items-center">
                <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1.5px,transparent_1.5px)] [background-size:24px_24px] opacity-40"></div>
                <div class="p-8 bg-white/90 backdrop-blur-md rounded-2xl border border-slate-100 shadow-md relative z-10 space-y-6 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <h4 class="font-bold text-slate-900">Bagaimana Cara Kerjanya?</h4>
                    </div>
                    <ul class="space-y-4 text-xs font-semibold text-slate-500">
                        <li class="flex items-center gap-2.5">
                            <span class="w-6 h-6 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-bold">1</span>
                            <span>Daftarkan akun dan isi minat belajarmu</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="w-6 h-6 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-bold">2</span>
                            <span>Mulai kebiasaan harian & tonton videonya</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="w-6 h-6 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-bold">3</span>
                            <span>Dapatkan poin dan tukarkan dengan Premium!</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- About Us / Tentang Kami Section -->
        <section id="about" class="py-20 bg-slate-50 border-t border-slate-200/60 px-6 md:px-12">
            <div class="max-w-7xl mx-auto space-y-12">
                
                <!-- Section Header -->
                <div class="text-center space-y-4">
                    <span class="bg-primary-100 text-primary-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-widest">
                        About Us / Tentang Kami
                    </span>
                    <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        Transform your habits into challenges
                    </h2>
                    <p class="text-slate-500 font-medium max-w-xl mx-auto text-sm md:text-base">
                        WebDay Challenge hadir untuk menuntun langkah pengembangan diri Anda dengan cara gamifikasi yang seru, konsisten, dan menyenangkan.
                    </p>
                </div>                <!-- Grid Layout (Perusahaan & FAQ) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                    
                    <!-- Left Column: Company Profile & Feedback Form (5 Cols - Stacks beautifully!) -->
                    <div class="lg:col-span-5 space-y-8">
                        
                        <!-- Perusahaan Card -->
                        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-primary-500/5 to-orange-500/5 rounded-bl-full group-hover:scale-110 transition-transform"></div>
                            
                            <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2 mb-3">
                                <i data-lucide="building-2" class="w-5 h-5 text-primary-500"></i>
                                <span>Perusahaan</span>
                            </h3>
                            
                            <p class="text-xs text-slate-400 font-medium mb-6 leading-relaxed">
                                Butuh informasi lebih lanjut mengenai program kemitraan atau memiliki pertanyaan bisnis? Tim Customer Care kami siap membantu Anda kapan saja.
                            </p>

                            <a href="https://api.whatsapp.com/send?phone=62895363339772&text=Halo%20WebDay%2C%20saya%20ingin%20tanya%20tentang%20layanan%20kemitraan." 
                               target="_blank" 
                               class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-5 rounded-2xl text-xs transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:scale-[1.01]">
                                <i data-lucide="phone-call" class="w-4 h-4"></i>
                                <span>Hubungi Kami (+62 895-3633-39772)</span>
                            </a>
                        </div>

                        <!-- Kirim Pesan Card (Sesuai Tema WebDay, Terintegrasi & Rapi!) -->
                        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 md:p-8 shadow-sm text-left">
                            
                            <!-- Card Header -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-6">
                                <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="message-square" class="w-5 h-5 text-primary-500"></i>
                                    <span>A. Kirim Saran & Masukan</span>
                                </h3>
                                <span class="text-[10px] bg-primary-50 text-primary-600 px-2 py-0.5 rounded font-black uppercase">Dukungan</span>
                            </div>

                            <!-- Form Body -->
                            <form action="{{ route('about.saran') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Nama & No Telepon Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nama Lengkap input -->
                                    <div class="space-y-1.5">
                                        <label for="name" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap *</label>
                                        <input 
                                            type="text" 
                                            name="name" 
                                            id="name" 
                                            value="{{ old('name', Auth::user() ? Auth::user()->name : '') }}" 
                                            placeholder="Nama lengkap Anda" 
                                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-rose-500 focus:ring-rose-500 @enderror"
                                            required
                                        >
                                        @error('name')
                                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- No Telepon input -->
                                    <div class="space-y-1.5">
                                        <label for="phone" class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Telepon *</label>
                                        <input 
                                            type="text" 
                                            name="phone" 
                                            id="phone" 
                                            value="{{ old('phone') }}" 
                                            placeholder="Contoh: 0895..." 
                                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('phone') border-rose-500 focus:ring-rose-500 @enderror"
                                            required
                                        >
                                        @error('phone')
                                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email & Subjek Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Email Input -->
                                    <div class="space-y-1.5">
                                        <label for="email" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email *</label>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            id="email" 
                                            value="{{ old('email', Auth::user() ? Auth::user()->email : '') }}" 
                                            placeholder="email@example.com" 
                                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                                            required
                                        >
                                        @error('email')
                                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Subjek Input -->
                                    <div class="space-y-1.5">
                                        <label for="subject" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Subjek *</label>
                                        <input 
                                            type="text" 
                                            name="subject" 
                                            id="subject" 
                                            value="{{ old('subject') }}" 
                                            placeholder="Subjek masukan Anda" 
                                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('subject') border-rose-500 focus:ring-rose-500 @enderror"
                                            required
                                        >
                                        @error('subject')
                                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pesan / Message Input -->
                                <div class="space-y-1.5">
                                    <label for="content" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesan *</label>
                                    <textarea 
                                        name="content" 
                                        id="content" 
                                        rows="3" 
                                        placeholder="Tulis pesan, saran perbaikan, atau laporan kendala Anda di sini..." 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none @error('content') border-rose-500 focus:ring-rose-500 @enderror"
                                        required
                                    >{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white font-bold py-3.5 px-6 rounded-2xl text-xs transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary-500/10 hover:scale-[1.01] active:scale-98 cursor-pointer mt-4">
                                    <span>Kirim Masukan Anda</span>
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: FAQ Accordion (7 Cols) -->
                    <div class="lg:col-span-7 h-full">
                        <div class="bg-white border border-slate-200/60 rounded-3xl p-6 shadow-sm h-full flex flex-col">
                            
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                                <div class="space-y-0.5">
                                    <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                                        <i data-lucide="help-circle" class="w-5 h-5 text-indigo-500"></i>
                                        <span>B. FAQ (Tanya Jawab)</span>
                                    </h3>
                                    <p class="text-[11px] text-slate-400 font-semibold">Tanya jawab lengkap tentang penggunaan aplikasi WebDay.</p>
                                </div>
                                <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded font-black uppercase">Bantuan</span>
                            </div>

                            <!-- FAQ Accordion List -->
                            <div class="space-y-4">
                                
                                <!-- FAQ 1 (Active by Default) -->
                                <div class="faq-item faq-active border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Bagaimana cara mengikuti challenge?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Anda dapat membuka fitur <strong class="text-indigo-600">Daily Challenge</strong> dan mengerjakan kegiatan positif harian Anda.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 2 -->
                                <div class="faq-item border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Bagaimana cara klaim reward?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Anda dapat mengklaim poin Anda di fitur <strong class="text-orange-500">premium access</strong>.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 3 -->
                                <div class="faq-item border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Apakah progress akan tersimpan meskipun sudah log out?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Tetap bisa yaa, data Anda akan tersimpan di sistem akan tetapi tenang saja data Anda akan aman.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 4 -->
                                <div class="faq-item border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Apakah akun jika sudah membayar premium langsung terbuka aksesnya?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Iyaa benar sekali akun Anda akan langsung otomatis beralih ke premium dan dapat mengakses berbagai fitur premium yang tersedia.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 5 -->
                                <div class="faq-item border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Bagaimana jika ingin melaporkan permasalahan akun dan saran fitur baru?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Anda dapat menghubungi nomor perusahaan atau dapat mengisi kotak saran yang tersedia.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 6 -->
                                <div class="faq-item border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/20 hover:bg-slate-50/50 transition-colors">
                                    <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                                        <span class="text-sm font-extrabold text-slate-800 flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            </span>
                                            <span>Apakah platform WebDay Challenge dapat diakses secara gratis?</span>
                                        </span>
                                        <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                                    </button>
                                    <div class="faq-answer px-5 pb-5">
                                        <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                            Iya benar sekali! Anda dapat mengakses berbagai tantangan harian (daily challenges) dasar secara gratis. Untuk membuka analisis progress kebiasaan berbasis AI dan kustomisasi tema premium, Anda dapat beralih ke Premium Access kapan saja.
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
            </div>
        </section>

    </main>

    <!-- Page Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 px-6 md:px-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto opacity-80" alt="Logo">
                <span class="font-extrabold text-white text-lg">Web Day Challenge</span>
            </div>
            <p class="text-xs font-semibold">&copy; 2026 Web Day Challenge. Dibuat dengan cinta untuk masa depan produktif Anda.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // FAQ Accordion Trigger
        document.addEventListener('DOMContentLoaded', function() {
            const faqTriggers = document.querySelectorAll('.faq-trigger');
            faqTriggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const parent = trigger.parentElement;
                    parent.classList.toggle('faq-active');

                    // Optional: Close other FAQs
                    const allItems = document.querySelectorAll('.faq-item');
                    allItems.forEach(item => {
                        if (item !== parent) {
                            item.classList.remove('faq-active');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
