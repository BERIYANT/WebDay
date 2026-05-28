@extends('layouts.app')

@section('title', 'Komunitas Terkunci')
@section('header_title', 'Komunitas')

@section('content')
<div class="max-w-xl mx-auto py-12">
    
    <!-- Lock Screen Box -->
    <div class="bg-white dark:bg-darkCard p-8 md:p-12 rounded-[36px] border border-slate-200/60 dark:border-darkBorder shadow-xl text-center space-y-6 relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-orange-500/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary-500/5 rounded-full blur-2xl"></div>

        <!-- Lock icon animation -->
        <div class="relative mx-auto w-20 h-20 bg-orange-50 dark:bg-orange-950/20 text-orange-500 rounded-full flex items-center justify-center shadow-inner hover:scale-105 transition-transform duration-300">
            <i data-lucide="lock" class="w-9 h-9 animate-bounce"></i>
        </div>

        <div class="space-y-2">
            <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-white tracking-tight">Grup Komunitas Eksklusif Premium</h2>
            <p class="text-xs text-orange-600 dark:text-orange-400 font-bold uppercase tracking-wider">Premium Access Required</p>
        </div>

        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed max-w-sm mx-auto">
            Maaf, halaman Komunitas Web Day Challenge saat ini hanya dapat diakses oleh akun Premium. Bergabunglah bersama ratusan warrior hebat lainnya untuk saling bertukar motivasi harian!
        </p>

        <!-- Premium Perks Grid -->
        <div class="bg-slate-50 dark:bg-slate-800/40 p-5 rounded-2xl border border-slate-100 dark:border-darkBorder/50 grid grid-cols-2 gap-4 text-left">
            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600 dark:text-slate-300">
                <i data-lucide="check" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                <span>Berbagi Progress</span>
            </div>
            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600 dark:text-slate-300">
                <i data-lucide="check" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                <span>Tanya Jawab Mentor</span>
            </div>
            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600 dark:text-slate-300">
                <i data-lucide="check" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                <span>Like & Komentar</span>
            </div>
            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600 dark:text-slate-300">
                <i data-lucide="check" class="w-4 h-4 text-emerald-500 flex-shrink-0"></i>
                <span>Inspirasi Harian AI</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
            <a href="{{ route('premium.index') }}" class="w-full sm:w-auto flex-1 bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white font-bold text-xs py-3.5 rounded-xl shadow-lg shadow-primary-500/20 hover:scale-[1.01] transition-transform text-center">
                Buka Premium Sekarang
            </a>
            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto border border-slate-200 dark:border-darkBorder text-slate-500 dark:text-slate-400 font-bold text-xs py-3.5 px-6 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center">
                Kembali
            </a>
        </div>

    </div>

</div>
@endsection
