<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Akun - Google Sign-In</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS with Roboto override -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Roboto"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f9;
        }
        .google-card {
            background-color: #ffffff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-radius: 28px;
            width: 448px;
        }
        .account-row {
            transition: background-color 0.15s ease;
        }
        .account-row:hover {
            background-color: #f7f9fc;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #dadce0;
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between items-center p-6 text-slate-800">

    <!-- Top spacer -->
    <div></div>

    <!-- Center Card -->
    <div class="google-card p-10 flex flex-col space-y-6">
        
        <!-- Google Logo Branding -->
        <div class="flex justify-center">
            <svg class="h-6.5 w-auto" viewBox="0 0 74 24" fill="none">
                <!-- Red G -->
                <path d="M9.3 11.5v2.8h5.3c-.2 1.3-1.4 3.8-5.3 3.8-3.4 0-6.1-2.8-6.1-6.2S5.9 5.7 9.3 5.7c1.9 0 3.2.8 3.9 1.5l2.2-2.2C13.9 3.5 11.8 2.6 9.3 2.6 4.2 2.6 0 6.7 0 11.9s4.2 9.3 9.3 9.3c5.3 0 8.9-3.7 8.9-9.1 0-.6-.1-1.1-.2-1.6H9.3z" fill="#EA4335"/>
                <!-- Yellow O -->
                <path d="M25.1 8.2c-3.5 0-6.3 2.7-6.3 6.3s2.8 6.3 6.3 6.3 6.3-2.7 6.3-6.3-2.8-6.3-6.3-6.3zm0 9.8c-2 0-3.6-1.6-3.6-3.5s1.6-3.5 3.6-3.5 3.6 1.6 3.6 3.5-1.6 3.5-3.6 3.5z" fill="#FBBC05"/>
                <!-- Green O -->
                <path d="M38.9 8.2c-3.5 0-6.3 2.7-6.3 6.3s2.8 6.3 6.3 6.3 6.3-2.7 6.3-6.3-2.8-6.3-6.3-6.3zm0 9.8c-2 0-3.6-1.6-3.6-3.5s1.6-3.5 3.6-3.5 3.6 1.6 3.6 3.5-1.6 3.5-3.6 3.5z" fill="#34A853"/>
                <!-- Blue G -->
                <path d="M52.3 8.2c-3.4 0-6.4 2.8-6.4 6.3s2.9 6.3 6.4 6.3c2 0 3.5-.8 4.3-1.6v1.2c0 2.4-1.3 3.7-3.4 3.7-1.7 0-2.8-1.2-3.2-2.3l-2.5 1c.7 1.8 2.6 3.9 5.7 3.9 3.3 0 5.6-2 5.6-6.6V8.5h-2.7v1.1c-.8-.9-2.2-1.4-3.8-1.4zm.3 9.8c-2 0-3.4-1.6-3.4-3.5s1.4-3.5 3.4-3.5 3.4 1.6 3.4 3.5-1.4 3.5-3.4 3.5z" fill="#4285F4"/>
                <!-- Red L -->
                <path d="M63.7 2.6H61v18.6h2.7V2.6z" fill="#EA4335"/>
                <!-- Yellow E -->
                <path d="M70.7 8.2c-3.2 0-5.8 2.6-5.8 6.3 0 3.9 2.8 6.3 6.1 6.3 2.7 0 4.2-1.6 4.9-2.7l-2.1-1.4c-.6.9-1.5 1.6-2.8 1.6-1.6 0-2.7-.9-3.2-2.2l8.2-3.4-1.1-4.5zM71 10.7c1.3 0 2.2.7 2.6 1.5L67.7 14c-.1-2.1 1.5-3.3 3.3-3.3z" fill="#FBBC05"/>
            </svg>
        </div>

        <!-- Mode Simulasi Warning Banner -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-[11px] text-amber-800 space-y-1.5 leading-relaxed">
            <div class="flex items-center gap-1.5 font-bold text-amber-900">
                <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                <span>Mode Simulasi Aktif</span>
            </div>
            <p>
                Halaman ini muncul karena <strong>GOOGLE_CLIENT_ID</strong> & <strong>GOOGLE_CLIENT_SECRET</strong> di file <code>.env</code> masih kosong. 
            </p>
            <p class="text-[10px] text-amber-700/90 font-semibold border-t border-amber-200/60 pt-1.5 mt-1.5">
                💡 Isi kredensial di file <code>.env</code> Anda untuk langsung redirect ke halaman login Google yang asli!
            </p>
        </div>

        <!-- Description headers -->
        <div class="text-center space-y-1">
            <h1 class="text-xl font-normal text-slate-800">Pilih akun</h1>
            <p class="text-xs text-slate-500 font-medium">untuk melanjutkan ke <span class="text-primary-600 font-bold">Day Challenge</span></p>
        </div>

        <!-- Error validation alerts -->
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-100 text-rose-800 p-3.5 rounded-2xl text-[11px] font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form id="google-select-form" action="{{ route('auth.google.select') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="user_id" id="selected-user-id">

            <!-- Seeded Accounts chooser block -->
            <div class="max-h-[220px] overflow-y-auto border border-slate-100 rounded-2xl divide-y divide-slate-100">
                @foreach($seededUsers as $sUser)
                    <button type="button" onclick="submitAccount({{ $sUser->id }})" class="w-full text-left p-3.5 flex items-center gap-3.5 account-row transition-all focus:outline-none">
                        <!-- Initial round letter avatar -->
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-indigo-500 text-white font-bold flex items-center justify-center text-sm uppercase shadow-sm flex-shrink-0">
                            {{ substr($sUser->name, 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 capitalize leading-none mb-1">{{ $sUser->name }}</h4>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $sUser->email }}</span>
                        </div>
                    </button>
                @endforeach

                <!-- Standard Use another account row -->
                <button type="button" onclick="toggleCustomForm()" class="w-full text-left p-3.5 flex items-center gap-3.5 account-row transition-all focus:outline-none">
                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Gunakan akun lain</span>
                </button>
            </div>

            <!-- Custom Form expander (Initially Hidden) -->
            <div id="custom-account-panel" class="{{ $errors->has('custom_email') ? '' : 'hidden' }} bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-3.5 transition-all">
                <h4 class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <i data-lucide="user" class="w-4 h-4 text-slate-500"></i>
                    <span>Masukkan Akun Baru</span>
                </h4>
                
                <div class="space-y-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="custom_name" placeholder="Masukkan nama" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-2 px-3 text-xs font-semibold outline-none text-slate-800 transition-colors">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Email Google</label>
                        <input type="email" name="custom_email" placeholder="nama@gmail.com" class="w-full bg-white border border-slate-200 focus:border-primary-500 rounded-xl py-2 px-3 text-xs font-semibold outline-none text-slate-800 transition-colors">
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-2.5 rounded-xl text-xs transition-colors">
                    Lanjutkan dengan Akun Kustom
                </button>
            </div>
        </form>

    </div>

    <!-- Google Bottom standard Indonesian footer links -->
    <div class="w-[448px] flex items-center justify-between text-[11px] font-semibold text-slate-500">
        <!-- Locale Selector selector -->
        <div class="flex items-center gap-1 cursor-pointer hover:text-slate-800">
            <span>Bahasa Indonesia</span>
            <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-slate-800">Bantuan</a>
            <a href="#" class="hover:text-slate-800">Privasi</a>
            <a href="#" class="hover:text-slate-800">Persyaratan</a>
        </div>
    </div>

    <script>
        const googleForm = document.getElementById('google-select-form');
        const selectedUserId = document.getElementById('selected-user-id');
        const customPanel = document.getElementById('custom-account-panel');

        function submitAccount(userId) {
            selectedUserId.value = userId;
            // Clear custom inputs to prevent submit issues
            googleForm.querySelector('input[name="custom_name"]').value = '';
            googleForm.querySelector('input[name="custom_email"]').value = '';
            googleForm.submit();
        }

        function toggleCustomForm() {
            if (customPanel.classList.contains('hidden')) {
                customPanel.classList.remove('hidden');
                // Scroll down
                setTimeout(() => {
                    customPanel.scrollIntoView({ behavior: 'smooth' });
                }, 50);
            } else {
                customPanel.classList.add('hidden');
            }
        }

        lucide.createIcons();
    </script>
</body>
</html>
