@extends('layouts.app')

@section('title', 'Premium Access Hub')
@section('header_title', 'Premium Access')

@section('content')
<div class="space-y-6">

    <!-- Premium perks introduction banner -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-[32px] p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.8px,transparent_0.8px)] [background-size:20px_20px] opacity-5"></div>
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-1.5 bg-orange-500/20 text-orange-400 border border-orange-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i data-lucide="crown" class="w-4 h-4"></i>
                    <span>Premium Exclusive Perks</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-none">Buka Seluruh Potensi Terbaik Anda</h2>
                <p class="text-xs text-slate-300 font-semibold leading-relaxed max-w-md">
                    Nikmati kebebasan berprogres tanpa batas. Akun Premium Web Day membuka semua fitur premium, materi video eksklusif, analisis data emosional berbasis AI, custom dashboard, lencana spesial, dan papan peringkat global!
                </p>
            </div>
            
            <div class="bg-white/5 border border-white/10 p-5 rounded-2xl backdrop-blur-md grid grid-cols-2 gap-4 text-xs">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="sparkles" class="w-4 h-4 text-orange-400"></i>
                    <span class="font-bold text-slate-200">AI Insight Detail</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="video" class="w-4 h-4 text-orange-400"></i>
                    <span class="font-bold text-slate-200">Materi Video Eksklusif</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="palette" class="w-4 h-4 text-orange-400"></i>
                    <span class="font-bold text-slate-200">Custom Dark Theme</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i data-lucide="award" class="w-4 h-4 text-orange-400"></i>
                    <span class="font-bold text-slate-200">Badge Profil Warrior+</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Plans & Point Swap -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Point swap column -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="gem" class="w-5 h-5 text-orange-500"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Tukar Poin Harian</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Points-to-Premium</p>
                    </div>
                </div>
                
                <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed">
                    Klaim reward gratisan! Kumpulkan poin dari workout harian, deep work, dan journaling. Tukarkan 500 poin reward Anda langsung dengan akses Premium selama 1 Bulan penuh secara cuma-cuma.
                </p>

                <!-- points summary indicator -->
                <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/40 text-center space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Poin Anda Saat Ini</span>
                    <h4 class="text-2xl font-black text-primary-600 dark:text-primary-400">{{ Auth::user()->points }} / 500 Poin</h4>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 mt-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: {{ min(100, (Auth::user()->points / 500) * 100) }}%"></div>
                    </div>
                </div>
            </div>

            <form action="{{ route('premium.redeem') }}" method="POST" class="pt-4">
                @csrf
                <button type="submit" {{ Auth::user()->points < 500 ? 'disabled' : '' }} class="w-full font-black text-xs py-3.5 rounded-xl text-center shadow-md transition-all uppercase tracking-wider
                    {{ Auth::user()->points >= 500
                        ? 'bg-orange-500 hover:bg-orange-600 text-white shadow-orange-500/20' 
                        : 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed border border-slate-200/50 dark:border-darkBorder' }}">
                    Tukarkan 500 Poin
                </button>
            </form>
        </div>

        <!-- Premium cash plans columns -->
        <div class="lg:col-span-2 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Berlangganan Instan</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Cash Subscriptions</p>
                </div>
            </div>

            <!-- Pricing cards grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- 1 Bulan -->
                <div class="border border-slate-200 dark:border-darkBorder/80 p-5 rounded-2xl space-y-4 hover:border-primary-500 dark:hover:border-primary-500 transition-all flex flex-col justify-between bg-slate-50/20 dark:bg-slate-800/10">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block">Warrior Lite</span>
                        <h4 class="font-black text-slate-800 dark:text-white text-base">1 Bulan</h4>
                        <p class="text-xl font-black text-slate-900 dark:text-white">Rp 20.000</p>
                    </div>
                    <button onclick="openCheckout('1m', 20000)" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md shadow-primary-500/10 transition-transform">
                        Pilih Plan
                    </button>
                </div>

                <!-- 6 Bulan -->
                <div class="border-2 border-primary-500 dark:border-primary-500 p-5 rounded-2xl space-y-4 hover:scale-[1.02] transition-all flex flex-col justify-between bg-primary-50/10 dark:bg-primary-950/5 relative">
                    <span class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-primary-600 to-orange-500 text-white font-black text-[8px] px-2 py-0.5 rounded-full uppercase tracking-wider">Paling Populer</span>
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block">Warrior Pro</span>
                        <h4 class="font-black text-slate-800 dark:text-white text-base">6 Bulan</h4>
                        <p class="text-xl font-black text-slate-900 dark:text-white">Rp 75.000</p>
                        <span class="text-[9px] text-emerald-500 font-bold block">*Hemat 35%</span>
                    </div>
                    <button onclick="openCheckout('6m', 75000)" class="w-full bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white font-black text-xs py-2.5 rounded-xl shadow-md transition-transform">
                        Pilih Plan
                    </button>
                </div>

                <!-- 1 Tahun -->
                <div class="border border-slate-200 dark:border-darkBorder/80 p-5 rounded-2xl space-y-4 hover:border-primary-500 dark:hover:border-primary-500 transition-all flex flex-col justify-between bg-slate-50/20 dark:bg-slate-800/10">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block">Warrior Legend</span>
                        <h4 class="font-black text-slate-800 dark:text-white text-base">1 Tahun</h4>
                        <p class="text-xl font-black text-slate-900 dark:text-white">Rp 120.000</p>
                        <span class="text-[9px] text-emerald-500 font-bold block">*Hemat 50%</span>
                    </div>
                    <button onclick="openCheckout('1y', 120000)" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md shadow-primary-500/10 transition-transform">
                        Pilih Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reward Claims Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Unlock Dark Theme -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="palette" class="w-5 h-5 text-primary-500"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Klaim Tema Custom</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Custom Dark Mode Theme</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed">
                    Aktifkan visual dashboard gelap (Dark Mode). Klaim gratis dengan 100 Poin reward atau gratis tanpa potong poin untuk akun Premium!
                </p>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-darkBorder/40">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Klaim: 100 Pts / Premium</span>
                
                @if($hasDarkThemeReward || Auth::user()->theme_dark_unlocked)
                    <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-950/20 dark:text-emerald-300 font-black text-xs px-4 py-2 rounded-xl flex items-center gap-1">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span>Sudah Unlocked</span>
                    </span>
                @else
                    <form action="{{ route('premium.claim-theme') }}" method="POST">
                        @csrf
                        <button type="submit" {{ Auth::user()->points < 100 && !Auth::user()->isPremium() ? 'disabled' : '' }} class="font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all
                            {{ Auth::user()->points >= 100 || Auth::user()->isPremium()
                                ? 'bg-primary-600 hover:bg-primary-700 text-white shadow-primary-500/10' 
                                : 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed border border-slate-200/50' }}">
                            Klaim Tema Dark
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Unlock Special Badge -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="award" class="w-5 h-5 text-orange-500"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Klaim Lencana Lanjutan</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Special Profile Badge</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed">
                    Klaim lencana profil khusus ('Warrior Premium' & 'Special Challenger') untuk dipamerkan di leaderboard. Klaim gratis dengan 150 Poin atau gratis instan bagi Warrior Premium!
                </p>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-darkBorder/40">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Klaim: 150 Pts / Premium</span>
                
                @if($hasSpecialBadgeReward || Auth::user()->badge_unlocked)
                    <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-950/20 dark:text-emerald-300 font-black text-xs px-4 py-2 rounded-xl flex items-center gap-1">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span>Sudah Unlocked</span>
                    </span>
                @else
                    <form action="{{ route('premium.claim-badge') }}" method="POST">
                        @csrf
                        <button type="submit" {{ Auth::user()->points < 150 && !Auth::user()->isPremium() ? 'disabled' : '' }} class="font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all
                            {{ Auth::user()->points >= 150 || Auth::user()->isPremium()
                                ? 'bg-orange-500 hover:bg-orange-600 text-white shadow-orange-500/10' 
                                : 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed border border-slate-200/50' }}">
                            Klaim Badge Spesial
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Premium exclusive AI Insight summaries (Locked if non-premium) -->
    @if(Auth::user()->isPremium() && count($aiInsights) > 0)
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-darkBorder pb-4">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Analisis Kebiasaan Lanjutan (AI Insight)</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Advanced Analytics by Web Day AI</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kebugaran -->
                <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-darkBorder rounded-2xl space-y-2">
                    <h4 class="font-extrabold text-slate-800 dark:text-white text-xs flex items-center gap-2">
                        <i data-lucide="heart" class="w-4 h-4 text-rose-500"></i>
                        <span>Kesehatan & Kebugaran</span>
                    </h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold leading-relaxed leading-normal">{{ $aiInsights['health'] }}</p>
                </div>

                <!-- Kesehatan Mental -->
                <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-darkBorder rounded-2xl space-y-2">
                    <h4 class="font-extrabold text-slate-800 dark:text-white text-xs flex items-center gap-2">
                        <i data-lucide="smile" class="w-4 h-4 text-emerald-500"></i>
                        <span>Kesehatan Emosional</span>
                    </h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold leading-relaxed leading-normal">{{ $aiInsights['mental'] }}</p>
                </div>

                <!-- Produktivitas -->
                <div class="p-5 bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-darkBorder rounded-2xl space-y-2">
                    <h4 class="font-extrabold text-slate-800 dark:text-white text-xs flex items-center gap-2">
                        <i data-lucide="shield-alert" class="w-4 h-4 text-amber-500"></i>
                        <span>Efisiensi Deep Work</span>
                    </h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold leading-relaxed leading-normal">{{ $aiInsights['productivity'] }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Transaction History -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Riwayat Pembayaran Subscriptions</h3>
        
        <div class="space-y-3">
            @forelse($transactions as $t)
                <div class="p-4 bg-slate-50 dark:bg-slate-800/20 border border-slate-100 dark:border-darkBorder/40 rounded-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs font-semibold gap-4">
                    <div class="space-y-1">
                        <h4 class="font-black text-slate-800 dark:text-white flex items-center gap-2">
                            <span>Plan {{ $t->plan == '1m' ? '1 Bulan' : ($t->plan == '6m' ? '6 Bulan' : '1 Tahun') }}</span>
                            @if($t->status === 'completed')
                                <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 text-[8px] px-2 py-0.5 rounded font-black uppercase">Berhasil</span>
                            @else
                                <span class="bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 text-[8px] px-2 py-0.5 rounded font-black uppercase">Menunggu Verifikasi</span>
                            @endif
                        </h4>
                        <span class="text-[10px] text-slate-400 font-bold block">{{ $t->created_at->format('d M Y - H:i') }} • Pembayaran {{ strtoupper($t->payment_method) }}</span>
                        @if($t->proof_of_payment)
                            <a href="{{ asset('uploads/proofs/' . $t->proof_of_payment) }}" target="_blank" class="text-[10px] text-primary-500 hover:text-primary-600 font-bold underline flex items-center gap-1 mt-1">
                                <i data-lucide="image" class="w-3 h-3"></i>
                                <span>Lihat Bukti Transfer</span>
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 self-end sm:self-auto">
                        <div class="text-right">
                            <p class="font-black text-slate-800 dark:text-white">Rp {{ number_format($t->price, 0, ',', '.') }}</p>
                        </div>
                        @if($t->status === 'pending')
                            <form action="{{ route('premium.approve', $t->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold text-[10px] py-1.5 px-3 rounded-xl shadow-md transition-all flex items-center gap-1 uppercase tracking-wider">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                    <span>Simulasi Approve</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-slate-400 font-bold text-xs">Belum ada riwayat transaksi pembayaran.</div>
            @endforelse
        </div>
    </div>

</div>

@push('modals')
<!-- Interactive Simulated Checkout Overlay Dialog Modal -->
<div id="checkout-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-6 transition-all duration-300">
    <div class="bg-white dark:bg-darkCard max-w-md w-full p-6 rounded-[36px] border border-slate-200/50 dark:border-darkBorder shadow-2xl space-y-6 relative transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
        
        <button onclick="closeCheckout()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 dark:hover:text-white bg-slate-100 dark:bg-slate-800 p-1.5 rounded-full transition-all">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
 
        <div class="text-center space-y-1">
            <h3 class="text-lg font-black text-slate-800 dark:text-white tracking-tight">Checkout Pembayaran Premium</h3>
            <p class="text-[9px] text-slate-400 font-bold uppercase">Manual Payment Gateway</p>
        </div>

        <form action="{{ route('premium.buy') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="plan" id="checkout-plan-input">
            
            <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/60 flex items-center justify-between text-xs font-bold">
                <span class="text-slate-500">Plan Berlangganan:</span>
                <span class="text-slate-950 dark:text-white uppercase font-black" id="checkout-plan-display">1 Bulan</span>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/60 flex items-center justify-between text-xs font-bold">
                <span class="text-slate-500">Total Harga:</span>
                <span class="text-primary-600 dark:text-primary-400 font-black text-sm" id="checkout-price-display">Rp 20.000</span>
            </div>

            <!-- E-wallet Selector -->
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Metode Pembayaran</label>
                
                <div class="grid grid-cols-3 gap-2.5 text-[10px] font-bold text-slate-600">
                    <label class="border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center" id="wallet-label-qris">
                        <input type="radio" name="payment_method" value="qris" checked onclick="toggleWalletView('qris')" class="hidden">
                        <i data-lucide="qr-code" class="w-4.5 h-4.5 text-slate-500"></i>
                        <span>QRIS</span>
                    </label>

                    <label class="border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center" id="wallet-label-shopee">
                        <input type="radio" name="payment_method" value="shopee" onclick="toggleWalletView('shopee')" class="hidden">
                        <i data-lucide="shopping-bag" class="w-4.5 h-4.5 text-slate-500"></i>
                        <span>ShopeePay</span>
                    </label>

                    <label class="border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center" id="wallet-label-dana">
                        <input type="radio" name="payment_method" value="dana" onclick="toggleWalletView('dana')" class="hidden">
                        <i data-lucide="wallet" class="w-4.5 h-4.5 text-slate-500"></i>
                        <span>DANA</span>
                    </label>
                </div>
            </div>

            <!-- Visual simulated barcode/E-wallet panels -->
            <div class="bg-slate-50 dark:bg-slate-800/40 p-5 rounded-3xl border border-slate-100 dark:border-darkBorder/60 flex flex-col items-center justify-center space-y-4">
                
                <!-- QRIS Panel -->
                <div id="qris-barcode-panel" class="p-4 bg-white dark:bg-slate-900 rounded-2xl w-full border border-slate-100 dark:border-darkBorder/40 text-center space-y-3">
                    <div class="w-12 h-12 bg-primary-50 dark:bg-primary-950/20 text-primary-500 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="qr-code" class="w-6 h-6"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Gerbang Pembayaran Pakasir</h4>
                        <p class="text-sm font-black text-slate-900 dark:text-white">Pembayaran QRIS Otomatis</p>
                        <p class="text-[10px] text-slate-400 font-semibold max-w-[250px] mx-auto leading-relaxed">Anda akan dialihkan ke halaman pembayaran aman Pakasir untuk menyelesaikan pembayaran via QRIS secara otomatis.</p>
                    </div>
                </div>

                <!-- Shopee Pay Panel -->
                <div id="shopee-panel" class="hidden text-center space-y-3 p-4 bg-white dark:bg-slate-900 rounded-2xl w-full border border-slate-100 dark:border-darkBorder/40">
                    <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/20 text-orange-500 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="smartphone" class="w-6 h-6"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Nomor ShopeePay</h4>
                        <p class="text-base font-black text-slate-900 dark:text-white select-all">0821 4073 1025</p>
                        <p class="text-[11px] font-extrabold text-slate-700 dark:text-slate-300">A/N: Finanda Restu Anargya Arkan</p>
                    </div>
                </div>

                <!-- DANA Panel -->
                <div id="dana-panel" class="hidden text-center space-y-3 p-4 bg-white dark:bg-slate-900 rounded-2xl w-full border border-slate-100 dark:border-darkBorder/40">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/20 text-blue-500 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="wallet" class="w-6 h-6"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Nomor DANA</h4>
                        <p class="text-base font-black text-slate-900 dark:text-white select-all">0821 4073 1025</p>
                        <p class="text-[11px] font-extrabold text-slate-700 dark:text-slate-300">A/N: Finanda Restu Anargya Arkan</p>
                    </div>
                </div>

                <!-- Manual Upload Bukti Pembayaran -->
                <div id="upload-proof-container" class="space-y-2 mt-4 w-full">
                    <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Unggah Bukti Transfer</label>
                    <div class="border-2 border-dashed border-slate-200 dark:border-darkBorder rounded-2xl p-4 text-center cursor-pointer hover:border-primary-500 transition-colors relative flex flex-col items-center justify-center gap-2 bg-white dark:bg-slate-900/50">
                        <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-400"></i>
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 leading-normal">Pilih Foto Bukti Pembayaran (.jpg, .png, max 2MB)</span>
                        <input type="file" name="proof_of_payment" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewUpload(event)">
                        
                        <div id="upload-preview" class="hidden mt-2 max-h-32 rounded-xl overflow-hidden shadow-md">
                            <img id="preview-img" src="" class="max-h-32 object-contain mx-auto">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Pay -->
            <button type="submit" id="checkout-submit-btn" class="w-full bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white font-black text-xs py-3.5 rounded-xl shadow-lg transition-all uppercase tracking-wider">
                Kirim Bukti Pembayaran
            </button>
        </form>

    </div>
</div>
@endpush
@endsection

@section('scripts')
<script>
    // Toggle checkout modal
    const checkoutModal = document.getElementById('checkout-modal');
    const checkoutPlanInput = document.getElementById('checkout-plan-input');
    const checkoutPlanDisplay = document.getElementById('checkout-plan-display');
    const checkoutPriceDisplay = document.getElementById('checkout-price-display');

    function openCheckout(plan, price) {
        if (!checkoutModal) return;

        checkoutPlanInput.value = plan;
        
        let planLabel = "1 Bulan";
        if (plan === '6m') planLabel = "6 Bulan";
        if (plan === '1y') planLabel = "1 Tahun";

        checkoutPlanDisplay.textContent = planLabel;
        checkoutPriceDisplay.textContent = "Rp " + price.toLocaleString('id-ID');

        // Reset radio buttons view and preview image
        toggleWalletView('qris');
        const qrisInput = document.querySelector('input[value="qris"]');
        if (qrisInput) qrisInput.checked = true;
        
        document.getElementById('upload-preview').classList.add('hidden');
        document.getElementById('preview-img').src = "";

        checkoutModal.classList.remove('hidden');
        checkoutModal.classList.add('flex');
        setTimeout(() => {
            checkoutModal.querySelector('div').classList.remove('scale-95');
            checkoutModal.querySelector('div').classList.add('scale-100');
        }, 50);
    }

    function closeCheckout() {
        if (!checkoutModal) return;
        checkoutModal.querySelector('div').classList.remove('scale-100');
        checkoutModal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            checkoutModal.classList.remove('flex');
            checkoutModal.classList.add('hidden');
        }, 150);
    }

    // Toggle Payment wallet panels
    const qrisPanel = document.getElementById('qris-barcode-panel');
    const shopeePanel = document.getElementById('shopee-panel');
    const danaPanel = document.getElementById('dana-panel');
    const uploadContainer = document.getElementById('upload-proof-container');
    const uploadInput = uploadContainer.querySelector('input[type="file"]');
    const submitBtn = document.getElementById('checkout-submit-btn');

    function toggleWalletView(wallet) {
        // Toggle selected border highlights on e-wallet buttons
        document.getElementById('wallet-label-qris').className = "border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center";
        document.getElementById('wallet-label-shopee').className = "border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center";
        document.getElementById('wallet-label-dana').className = "border-2 border-slate-200 dark:border-darkBorder p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center";

        const currentLabel = document.getElementById('wallet-label-' + wallet);
        if (currentLabel) {
            currentLabel.className = "border-2 border-primary-500 dark:border-primary-500 p-2.5 rounded-2xl flex flex-col items-center gap-1.5 cursor-pointer bg-primary-50/15 dark:bg-primary-950/10 text-primary-600 dark:text-primary-400 transition-colors text-center";
        }

        // Hide all payment details panels
        qrisPanel.classList.add('hidden');
        shopeePanel.classList.add('hidden');
        danaPanel.classList.add('hidden');

        // Show selected panel and toggle upload requirements
        if (wallet === 'qris') {
            qrisPanel.classList.remove('hidden');
            uploadContainer.classList.add('hidden');
            uploadInput.removeAttribute('required');
            submitBtn.textContent = "Bayar Sekarang (Pakasir)";
        } else {
            uploadContainer.classList.remove('hidden');
            uploadInput.setAttribute('required', 'required');
            submitBtn.textContent = "Kirim Bukti Pembayaran";

            if (wallet === 'shopee') {
                shopeePanel.classList.remove('hidden');
            } else if (wallet === 'dana') {
                danaPanel.classList.remove('hidden');
            }
        }
    }

    // Image Upload Preview handler
    function previewUpload(event) {
        const input = event.target;
        const preview = document.getElementById('upload-preview');
        const img = document.getElementById('preview-img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            img.src = "";
        }
    }

    // Initialize Lucide Icons for pushed modals
    lucide.createIcons();
</script>
@endsection
