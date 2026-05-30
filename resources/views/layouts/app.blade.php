<!DOCTYPE html>
<html lang="id" class="{{ Auth::user()->selected_theme == 'dark' && (Auth::user()->theme_dark_unlocked || Auth::user()->isPremium()) ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Day Challenge') - Self Development Gamification</title>
    
    <!-- Compelling SEO Meta Tags -->
    <meta name="description" content="Web Day Challenge membantu pengguna membangun kebiasaan positif melalui challenge harian interaktif, AI reminder, leaderboard, dan komunitas suportif.">
    <meta name="keywords" content="webday, habit challenge, daily challenge, kebiasaan positif, produktivitas, pengembangan diri">
    <meta name="author" content="WebDay Challenge Team">
    
    <!-- Open Graph (OG) Meta Tags for Social Media and Search Engine Previews -->
    <meta property="og:title" content="Web Day Challenge - Self Development Gamification">
    <meta property="og:description" content="Mulai bangun kebiasaan positif harian Anda bersama WebDay Challenge secara interaktif dan menyenangkan.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Web Day Challenge - Self Development Gamification">
    <meta name="twitter:description" content="Mulai bangun kebiasaan positif harian Anda bersama WebDay Challenge secara interaktif dan menyenangkan.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Favicon and Logo Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS with custom theme config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                            500: '#f97316', // modern orange
                            600: '#ea580c',
                            700: '#c2410c',
                        },
                        darkBg: '#090d16',
                        darkCard: '#151c2c',
                        darkBorder: '#222d44',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar-active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(249, 115, 22, 0.05) 100%);
            border-left: 4px solid #2563eb;
            color: #2563eb;
        }
        .dark .sidebar-active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.2) 0%, rgba(249, 115, 22, 0.1) 100%);
            border-left: 4px solid #3b82f6;
            color: #60a5fa;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }
        /* Animation keyframes */
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(15deg); }
        }
        .wave-emoji {
            display: inline-block;
            animation: wave 1.5s infinite ease-in-out;
            transform-origin: 70% 70%;
        }
        @media (min-width: 768px) {
            .sidebar-collapsed {
                width: 0px !important;
                min-w-0px !important;
                min-width: 0px !important;
                opacity: 0 !important;
                border-right-width: 0px !important;
                overflow: hidden !important;
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        }
        
        #sidebar {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        #desktop-sidebar-toggle-floating {
            transition: left 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease, border-color 0.2s ease !important;
        }
        #floating-toggle-icon {
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .rotate-180 {
            transform: rotate(180deg) !important;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 dark:bg-darkBg text-slate-800 dark:text-slate-100 min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <header class="md:hidden bg-white dark:bg-darkCard border-b border-slate-200 dark:border-darkBorder px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto" alt="Logo">
            <span class="font-extrabold text-lg bg-gradient-to-r from-primary-600 to-orange-500 bg-clip-text text-transparent">Web Day</span>
        </a>
        <button id="mobile-menu-toggle" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </header>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out md:static w-64 md:min-w-0 bg-white dark:bg-darkCard border-r border-slate-200 dark:border-darkBorder flex flex-col h-screen z-40">
        
        <!-- Logo Header -->
        <div class="p-6 border-b border-slate-100 dark:border-darkBorder flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto hover:scale-105 transition-transform" alt="Logo">
                <div class="flex flex-col">
                    <span class="font-black text-xl leading-none bg-gradient-to-r from-primary-600 to-orange-500 bg-clip-text text-transparent">Web Day</span>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Challenge Platform</span>
                </div>
            </a>
            <button id="mobile-menu-close" class="md:hidden text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 p-1.5 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('dashboard') ? 'sidebar-active' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Beranda</span>
            </a>
            
            <a href="{{ route('challenges.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('challenges.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="award" class="w-5 h-5"></i>
                <span>Daily Challenge</span>
            </a>
            
            <a href="{{ route('journal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('journal.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <span>Journaling</span>
            </a>
            
            <a href="{{ route('partner.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('partner.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="users-2" class="w-5 h-5"></i>
                <span>Progress Partner</span>
            </a>

            <a href="{{ route('community.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('community.index') ? 'sidebar-active' : '' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="messages-square" class="w-5 h-5"></i>
                    <span>Komunitas</span>
                </div>
                @if(!Auth::user()->isPremium())
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-slate-400"></i>
                @endif
            </a>
            
            <a href="{{ route('leaderboard.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('leaderboard.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
                <span>Leaderboard</span>
            </a>
            
            <a href="{{ route('premium.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('premium.index') ? 'sidebar-active' : '' }}">
                <div class="flex items-center gap-3">
                    <i data-lucide="crown" class="w-5 h-5 text-orange-500"></i>
                    <span class="text-orange-500 font-bold">Premium Access</span>
                </div>
                @if(Auth::user()->isPremium())
                    <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/50 dark:text-orange-300 text-[10px] px-2 py-0.5 rounded font-black uppercase">Aktif</span>
                @endif
            </a>

            <hr class="border-slate-100 dark:border-darkBorder my-4">

            <a href="{{ route('about.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('about.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
                <span>Tentang Kami</span>
            </a>

            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white transition-all {{ Route::is('settings.index') ? 'sidebar-active' : '' }}">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span>Pengaturan</span>
            </a>

            @if(Auth::user()->isAdmin())
                <hr class="border-slate-100 dark:border-darkBorder my-4">
                <span class="px-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 block mb-2">Administrasi</span>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20 hover:text-rose-700 dark:hover:text-white transition-all {{ Request::is('admin*') ? 'sidebar-active' : '' }}">
                    <i data-lucide="shield-check" class="w-5 h-5 text-rose-500"></i>
                    <span>Admin Panel</span>
                </a>
            @endif
        </nav>

        <!-- User Profile Footer inside Sidebar -->
        <div class="p-4 border-t border-slate-100 dark:border-darkBorder bg-slate-50/20 dark:bg-slate-800/5">
            <!-- Profile Info Card -->
            <div class="bg-slate-50/80 dark:bg-slate-800/30 border border-slate-200/50 dark:border-darkBorder/40 p-3 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="relative flex-shrink-0">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('uploads/profiles/' . Auth::user()->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" alt="Avatar">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-sm uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-darkCard rounded-full"></div>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate capitalize leading-tight">{{ Auth::user()->name }}</p>
                    <span class="inline-block bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 text-[10px] px-2 py-0.5 rounded font-black uppercase tracking-wider mt-1">
                        {{ Auth::user()->getLeaderboardBadge() }}
                    </span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/20 dark:hover:bg-rose-950/40 transition-colors">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile menu -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden md:hidden"></div>

    <!-- Main Workspace Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <!-- Top Toolbar Header -->
        <header class="bg-white dark:bg-darkCard border-b border-slate-200 dark:border-darkBorder px-8 py-4 hidden md:flex items-center justify-between sticky top-0 z-20 shadow-sm backdrop-blur-md bg-white/95 dark:bg-darkCard/95">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight leading-none">@yield('header_title', 'Dashboard')</h1>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-medium mt-1">Platform Pengembangan Diri Berbasis AI & Gamifikasi</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Live Clock indicator -->
                <div class="flex items-center gap-2 bg-slate-100/60 dark:bg-slate-800/40 px-3 py-1.5 rounded-full border border-slate-200/50 dark:border-darkBorder/40">
                    <i data-lucide="clock" class="w-4.5 h-4.5 text-slate-500 dark:text-slate-400"></i>
                    <span id="live-clock" class="text-xs font-extrabold text-slate-600 dark:text-slate-300">00:00:00</span>
                </div>

                <!-- Streak indicator -->
                <div class="flex items-center gap-2 bg-orange-50 dark:bg-orange-950/30 px-3 py-1.5 rounded-full border border-orange-100 dark:border-orange-950/50">
                    <i data-lucide="flame" class="w-5 h-5 text-orange-500 animate-bounce"></i>
                    <span class="text-sm font-bold text-orange-600 dark:text-orange-400">{{ Auth::user()->streak }} Hari Streak</span>
                </div>

                <!-- Points indicator -->
                <div class="flex items-center gap-2 bg-blue-50 dark:bg-blue-950/30 px-3 py-1.5 rounded-full border border-blue-100 dark:border-blue-950/50">
                    <i data-lucide="gem" class="w-5 h-5 text-primary-500"></i>
                    <span class="text-sm font-bold text-primary-600 dark:text-primary-400">{{ Auth::user()->points }} Poin</span>
                </div>

                <!-- Profile Image instead of Notifications Bell -->
                <a href="{{ route('settings.index') }}" class="relative cursor-pointer group flex-shrink-0">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('uploads/profiles/' . Auth::user()->profile_image) }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 dark:border-slate-700 group-hover:scale-105 transition-transform" alt="Avatar">
                    @else
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-[10px] uppercase group-hover:scale-105 transition-transform">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-darkCard rounded-full"></div>
                </a>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <div class="flex-1 p-6 md:p-8 space-y-6">
            
            <!-- Toast Feedback system -->
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900 text-emerald-800 dark:text-emerald-300 p-4 rounded-2xl flex items-start gap-3 shadow-sm transition-all" id="toast-success">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm font-semibold">{{ session('success') }}</div>
                    <button onclick="document.getElementById('toast-success').style.display='none'" class="text-emerald-500 hover:bg-emerald-100 dark:hover:bg-emerald-950/50 p-0.5 rounded transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900 text-rose-800 dark:text-rose-300 p-4 rounded-2xl flex items-start gap-3 shadow-sm transition-all" id="toast-error">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1 text-sm font-semibold">{{ session('error') }}</div>
                    <button onclick="document.getElementById('toast-error').style.display='none'" class="text-rose-500 hover:bg-rose-100 dark:hover:bg-rose-950/50 p-0.5 rounded transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Floating Desktop Sidebar Toggle Button -->
    <button id="desktop-sidebar-toggle-floating" class="hidden md:flex fixed top-[45vh] left-64 w-7 h-11 bg-rose-600 hover:bg-rose-700 text-white rounded-r-2xl items-center justify-center shadow-md cursor-pointer z-50 transition-all duration-300 border border-l-0 border-rose-500/20" title="Buka/Tutup Sidebar">
        <i data-lucide="chevron-left" class="w-4 h-4 transition-transform" id="floating-toggle-icon"></i>
    </button>

    <!-- Mobile navigation menu logic -->
    <script>
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (mobileToggle && sidebar && overlay) {
            mobileToggle.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            });
        }

        if (mobileClose && sidebar && overlay) {
            mobileClose.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }

        if (overlay && sidebar) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }

        // Live Clock & Date Functionality
        function updateLiveClock() {
            const clockElement = document.getElementById('live-clock');
            if (!clockElement) return;
            
            const now = new Date();
            
            // Format time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeStr = `${hours}:${minutes}:${seconds}`;
            
            // Format date in Indonesian
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const dayNum = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const dateStr = `${dayName}, ${dayNum} ${monthName} ${year}`;
            
            clockElement.textContent = `${dateStr} • ${timeStr}`;
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        // Floating Desktop Sidebar Toggle Functionality
        const floatingToggleBtn = document.getElementById('desktop-sidebar-toggle-floating');
        
        if (floatingToggleBtn && sidebar) {
            floatingToggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-collapsed');
                
                // Toggle floating button position
                floatingToggleBtn.classList.toggle('left-64');
                floatingToggleBtn.classList.toggle('left-0');
                
                // Toggle icon rotation (query dynamically because Lucide replaces the element)
                const currentIcon = document.getElementById('floating-toggle-icon');
                if (currentIcon) {
                    currentIcon.classList.toggle('rotate-180');
                }
            });
        }

        // Global Background AI Reminders Check (Runs on every page!)
        document.addEventListener('DOMContentLoaded', function() {
            if (!("Notification" in window)) return;

            function checkBackgroundReminders() {
                if (Notification.permission !== "granted") return;

                fetch('{{ route("dashboard.ai-reminders") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.reminders && data.reminders.length > 0) {
                        let notified = [];
                        try {
                            notified = JSON.parse(localStorage.getItem('notified_reminders_list') || '[]');
                        } catch (e) { notified = []; }

                        let newlyNotified = false;

                        data.reminders.forEach((reminder, index) => {
                            if (!notified.includes(reminder)) {
                                newlyNotified = true;
                                notified.push(reminder);

                                setTimeout(() => {
                                    new Notification("Day Challenge - AI Reminder", {
                                        body: reminder,
                                        icon: "{{ asset('images/logo.png') }}"
                                    });
                                }, index * 2500);
                            }
                        });

                        if (newlyNotified) {
                            if (notified.length > 20) {
                                notified = notified.slice(notified.length - 20);
                            }
                            localStorage.setItem('notified_reminders_list', JSON.stringify(notified));
                        }
                    }
                })
                .catch(err => console.error("AI reminders check error:", err));
            }

            if (Notification.permission === "granted") {
                setTimeout(checkBackgroundReminders, 3000);
            }

            // Check every 60 seconds
            setInterval(checkBackgroundReminders, 60000);
        });

        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
    @stack('modals')
    @yield('scripts')
</body>
</html>
