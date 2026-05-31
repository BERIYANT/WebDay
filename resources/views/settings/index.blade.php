@extends('layouts.app')

@section('title', 'Pengaturan Profil')
@section('header_title', 'Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- Settings configuration card -->
    <div class="bg-white dark:bg-darkCard p-6 md:p-8 rounded-[36px] border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
        
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-darkBorder pb-4">
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                <i data-lucide="settings" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Pengaturan Profil & Kustomisasi</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Profile Preferences</p>
            </div>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avatar Upload Panel -->
            <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-slate-50 dark:bg-slate-800/30 rounded-2xl border border-slate-100 dark:border-darkBorder/60">
                <div class="relative">
                    @if($user->profile_image && file_exists(public_path('uploads/profiles/' . $user->profile_image)))
                        <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" class="w-20 h-20 rounded-full object-cover border-2 border-white dark:border-darkCard shadow" alt="Avatar">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-2xl uppercase border-2 border-white dark:border-darkCard shadow">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 space-y-2 text-center sm:text-left">
                    <h4 class="font-bold text-xs text-slate-700 dark:text-slate-200">Foto Profil Kustom</h4>
                    <p class="text-[10px] text-slate-400 font-semibold leading-relaxed">Pilih file foto profil (PNG/JPEG, max 2MB). Foto akan disimpan di cloud database lokal Anda.</p>
                    <input type="file" name="profile_image" id="profile_image" class="block w-full text-xs font-semibold text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 file:cursor-pointer dark:file:bg-slate-700 dark:file:text-slate-300">
                </div>
            </div>

            <!-- Username Field -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Nama Pengguna</label>
                <div class="relative">
                    <i data-lucide="user" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-3.5 pl-12 pr-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors">
                </div>
                <p class="text-[9px] text-slate-400 font-medium">Username ini akan dicerminkan di papan peringkat global, komentar forum, dan ruang obrolan partner.</p>
            </div>

            <!-- Badge selector dropdown -->
            <div class="space-y-1.5">
                <label for="selected_badge" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Lencana Profil (Badge)</label>
                <select name="selected_badge" id="selected_badge" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-3 px-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors cursor-pointer">
                    <!-- Standard ranks based on current point requirements -->
                    <option value="Beginner" {{ $user->selected_badge == 'Beginner' ? 'selected' : '' }}>Beginner (Rencana Dasar)</option>
                    <option value="Challenger" {{ $user->selected_badge == 'Challenger' ? 'selected' : '' }}>Challenger (Aktif)</option>
                    <option value="Warrior" {{ $user->selected_badge == 'Warrior' ? 'selected' : '' }}>Warrior (Tangguh)</option>
                    
                    <!-- Premium unlocked badges -->
                    @if($user->badge_unlocked || $user->isPremium())
                        <option value="Warrior Premium" {{ $user->selected_badge == 'Warrior Premium' ? 'selected' : '' }}>⭐ Warrior Premium (Unlocked Reward)</option>
                        <option value="Special Challenger" {{ $user->selected_badge == 'Special Challenger' ? 'selected' : '' }}>🏆 Special Challenger (Unlocked Reward)</option>
                    @else
                        <option disabled class="text-slate-400 dark:text-slate-500">🔒 Warrior Premium (Terkunci - Klaim di tab Premium)</option>
                        <option disabled class="text-slate-400 dark:text-slate-500">🔒 Special Challenger (Terkunci - Klaim di tab Premium)</option>
                    @endif
                </select>
            </div>

            <!-- Custom dark theme restriction selector -->
            <div class="space-y-1.5">
                <label for="selected_theme" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Tema Dashboard</label>
                <select name="selected_theme" id="selected_theme" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-3 px-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors cursor-pointer">
                    <option value="light" {{ $user->selected_theme == 'light' ? 'selected' : '' }}>☀️ Light Mode (Putih, Biru, Orange)</option>
                    
                    @if($user->theme_dark_unlocked || $user->isPremium())
                        <option value="dark" {{ $user->selected_theme == 'dark' ? 'selected' : '' }}>🌙 Dark Mode (Futuristik & Premium)</option>
                    @else
                        <option disabled class="text-slate-400 dark:text-slate-500">🔒 Dark Mode (Terkunci - Klaim di tab Premium dengan 100 Poin)</option>
                    @endif
                </select>
                @if(!$user->theme_dark_unlocked && !$user->isPremium())
                    <p class="text-[9px] text-orange-600 dark:text-orange-400 font-bold flex items-center gap-1">
                        <i data-lucide="lock" class="w-3 h-3"></i>
                        <span>Tema Dark Mode terkunci! Kumpulkan 100 Poin lalu klaim reward Tema Custom di tab Premium terlebih dahulu.</span>
                    </p>
                @endif
            </div>

            <!-- Buttons -->
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-2xl shadow-lg transition-transform text-xs uppercase tracking-wider">
                Simpan Preferensi
            </button>
        </form>

    </div>

</div>
@endsection
