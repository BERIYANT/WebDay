@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header_title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header / Banner -->
    <div class="bg-gradient-to-r from-rose-600 via-purple-600 to-indigo-600 p-6 md:p-8 rounded-3xl text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 space-y-2">
            <h2 class="text-2xl md:text-3xl font-black tracking-tight flex items-center gap-2">
                Selamat Datang di Portal Admin! <span class="wave-emoji">👋</span>
            </h2>
            <p class="text-white/80 text-sm font-semibold max-w-xl">
                Gunakan panel administrasi ini untuk memoderasi feed komunitas, mengelola tantangan harian, menyetujui transaksi premium, dan meninjau keaktifan pengguna secara real-time.
            </p>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Users -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 flex items-center justify-between shadow-sm hover:scale-[1.02] transition-transform">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Pengguna</span>
                <p class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-rose-500 hover:text-rose-600 font-extrabold flex items-center gap-1 mt-2">
                    Kelola Pengguna <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/40 text-blue-500 dark:text-blue-400 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card 2: Premium Members -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 flex items-center justify-between shadow-sm hover:scale-[1.02] transition-transform">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Member Premium</span>
                <p class="text-3xl font-black text-orange-500">{{ number_format($stats['premium_users']) }}</p>
                <a href="{{ route('admin.users.index', ['status' => 'premium']) }}" class="text-xs text-orange-500 hover:text-orange-600 font-extrabold flex items-center gap-1 mt-2">
                    Lihat Premium <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/40 text-orange-500 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="crown" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card 3: Daily Challenges -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 flex items-center justify-between shadow-sm hover:scale-[1.02] transition-transform">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tantangan Harian</span>
                <p class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($stats['total_challenges']) }}</p>
                <a href="{{ route('admin.challenges.index') }}" class="text-xs text-rose-500 hover:text-rose-600 font-extrabold flex items-center gap-1 mt-2">
                    Kelola Tantangan <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-950/40 text-purple-500 dark:text-purple-400 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card 4: Pending Transactions -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 flex items-center justify-between shadow-sm hover:scale-[1.02] transition-transform">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Transaksi Pending</span>
                <p class="text-3xl font-black {{ $stats['pending_transactions'] > 0 ? 'text-rose-500 animate-pulse' : 'text-slate-800 dark:text-white' }}">
                    {{ number_format($stats['pending_transactions']) }}
                </p>
                <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="text-xs text-rose-500 hover:text-rose-600 font-extrabold flex items-center gap-1 mt-2">
                    Verifikasi Pembayaran <i data-lucide="chevron-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="w-12 h-12 {{ $stats['pending_transactions'] > 0 ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-500' : 'bg-slate-50 dark:bg-slate-800/40 text-slate-500' }} rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="credit-card" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Quick Revenue Panel -->
    <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Omzet Penjualan (Manual Premium)</h3>
                <p class="text-2xl font-black text-emerald-500 mt-0.5">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="text-xs font-semibold text-slate-400 bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40">
            Pendapatan bersih yang disetujui dari pendaftaran premium
        </div>
    </div>

    <!-- Dynamic Actions Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Panel: Antrean Transaksi -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-darkBorder mb-4">
                <h3 class="text-base font-extrabold flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-rose-500"></i>
                    <span>Antrean Transaksi Tertunda</span>
                </h3>
                <span class="bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-300 text-xs px-2.5 py-1 rounded-full font-bold">
                    {{ $recentTransactions->count() }} Tertunda
                </span>
            </div>
            
            @if($recentTransactions->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3">
                        <i data-lucide="check-circle" class="w-8 h-8 text-emerald-500"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Semua bersih!</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Tidak ada transaksi tertunda saat ini.</p>
                </div>
            @else
                <div class="space-y-4 flex-1 overflow-y-auto max-h-[350px] pr-2">
                    @foreach($recentTransactions as $trx)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50/50 dark:bg-slate-800/20 border border-slate-100 dark:border-darkBorder/40 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs capitalize">
                                    {{ substr($trx->user->name, 0, 2) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate capitalize">{{ $trx->user->name }}</p>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold">{{ $trx->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-xs font-black text-slate-800 dark:text-slate-200">Plan {{ strtoupper($trx->plan) }}</p>
                                    <span class="text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded uppercase font-bold">{{ $trx->payment_method }}</span>
                                </div>
                                <a href="{{ route('admin.transactions.index') }}" class="p-1.5 bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400 rounded-xl hover:scale-105 transition-transform" title="Buka Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Panel: Top Streak Users -->
        <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 shadow-sm flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-darkBorder mb-4">
                <h3 class="text-base font-extrabold flex items-center gap-2">
                    <i data-lucide="flame" class="w-5 h-5 text-orange-500"></i>
                    <span>Pengguna Streak Teraktif</span>
                </h3>
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Top 5</span>
            </div>

            <div class="space-y-4 flex-1">
                @foreach($topStreaks as $index => $u)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50/50 dark:bg-slate-800/20 border border-slate-100 dark:border-darkBorder/40 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-extrabold text-slate-400 dark:text-slate-500 w-5 text-center">#{{ $index + 1 }}</span>
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs capitalize">
                                {{ substr($u->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate capitalize">{{ $u->name }}</p>
                                <span class="bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-300 text-[9px] px-2 py-0.5 rounded font-extrabold uppercase">{{ $u->getLeaderboardBadge() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 bg-orange-50 dark:bg-orange-950/30 px-3 py-1 rounded-full border border-orange-100 dark:border-orange-950/50">
                            <i data-lucide="flame" class="w-3.5 h-3.5 text-orange-500"></i>
                            <span class="text-xs font-black text-orange-600 dark:text-orange-400">{{ $u->streak }} Hari</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
