@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran')
@section('header_title', 'Kelola Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <div>
            <h2 class="text-lg font-extrabold text-slate-800 dark:text-white leading-none">Verifikasi Pembayaran Premium</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 font-semibold">Validasi bukti transfer e-wallet (DANA / ShopeePay) untuk mengaktifkan akses premium pengguna secara instan.</p>
        </div>
        <span class="bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-300 text-xs px-3 py-1.5 rounded-full font-black uppercase tracking-wider">
            Total: {{ $transactions->total() }} Transaksi
        </span>
    </div>

    <!-- Filters Panel -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
            <!-- Filter by Status -->
            <div class="space-y-1">
                <label for="status" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Transaksi</label>
                <select name="status" id="status" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Pending)</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Berhasil (Completed)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
            </div>

            <!-- Filter by Plan -->
            <div class="space-y-1">
                <label for="plan" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Paket Langganan</label>
                <select name="plan" id="plan" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Paket</option>
                    <option value="1m" {{ request('plan') === '1m' ? 'selected' : '' }}>1 Bulan (1m)</option>
                    <option value="6m" {{ request('plan') === '6m' ? 'selected' : '' }}>6 Bulan (6m)</option>
                    <option value="1y" {{ request('plan') === '1y' ? 'selected' : '' }}>1 Tahun (1y)</option>
                </select>
            </div>

            <!-- Filter by Payment Method -->
            <div class="space-y-1">
                <label for="method" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Metode Bayar</label>
                <select name="method" id="method" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Metode</option>
                    <option value="dana" {{ request('method') === 'dana' ? 'selected' : '' }}>DANA</option>
                    <option value="shopee" {{ request('method') === 'shopee' ? 'selected' : '' }}>ShopeePay</option>
                    <option value="qris" {{ request('method') === 'qris' ? 'selected' : '' }}>QRIS (Pakasir Webhook)</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-rose-600/10">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Saring</span>
                </button>
                @if(request()->anyFilled(['status', 'plan', 'method']))
                    <a href="{{ route('admin.transactions.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center" title="Reset Filter">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 text-xs font-black uppercase tracking-wider border-b border-slate-100 dark:border-darkBorder">
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Paket / Biaya</th>
                        <th class="px-6 py-4 text-center">Metode / Bukti</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors">
                            <!-- Transaction ID -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-slate-800 dark:text-white">
                                #TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <!-- User details -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase">
                                        {{ substr($trx->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-800 dark:text-white capitalize leading-tight">{{ $trx->user->name }}</p>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold">{{ $trx->user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Plan and Price -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex flex-col">
                                    <span class="text-sm font-black text-slate-800 dark:text-white">Plan: {{ strtoupper($trx->plan) }}</span>
                                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">Rp {{ number_format($trx->price, 0, ',', '.') }}</span>
                                </div>
                            </td>

                            <!-- Payment Method / Proof slip -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center gap-2.5 justify-center">
                                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] px-2 py-0.5 rounded font-black uppercase tracking-wider">
                                        {{ $trx->payment_method }}
                                    </span>
                                    
                                    @if($trx->proof_of_payment)
                                        <button onclick="openProofModal('{{ asset('uploads/proofs/' . $trx->proof_of_payment) }}', '#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}')" class="bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 text-[10px] px-2.5 py-1 rounded-xl font-bold flex items-center gap-0.5 hover:scale-105 transition-all">
                                            <i data-lucide="image" class="w-3.5 h-3.5"></i> Bukti Slip
                                        </button>
                                    @else
                                        <span class="text-[10px] text-slate-400 font-semibold">Otomatis QRIS</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($trx->status === 'pending')
                                    <span class="bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider animate-pulse">
                                        Pending
                                    </span>
                                @elseif($trx->status === 'completed')
                                    <span class="bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                        Berhasil
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-600 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Action Persetujuan -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                @if($trx->status === 'pending')
                                    <div class="inline-flex items-center gap-2 justify-end">
                                        <!-- Approve -->
                                        <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-3 py-1.5 rounded-xl transition-all shadow-md shadow-emerald-500/10 hover:scale-102 flex items-center gap-0.5">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Setujui
                                            </button>
                                        </form>

                                        <!-- Reject -->
                                        <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak transaksi ini?');">
                                            @csrf
                                            <button type="submit" class="bg-rose-50 text-rose-600 dark:bg-rose-950/40 hover:bg-rose-100 hover:scale-102 px-3 py-1.5 rounded-xl transition-all font-bold flex items-center gap-0.5">
                                                <i data-lucide="x" class="w-3.5 h-3.5"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold italic">Telah Diproses • {{ $trx->updated_at->format('d M Y') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                                </div>
                                <span>Tidak ditemukan riwayat transaksi yang cocok dengan filter pencarian Anda.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-darkBorder">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Premium Pop-up Image Modal for Proof of Transfer -->
<div id="proof-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder w-full max-w-lg overflow-hidden shadow-2xl relative">
        <div class="p-6 border-b border-slate-100 dark:border-darkBorder flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-800 dark:text-white flex items-center gap-2">
                <i data-lucide="image" class="w-5 h-5 text-blue-500"></i>
                <span>Bukti Slip Transfer <span id="modal-trx-id" class="text-rose-500"></span></span>
            </h3>
            <button onclick="closeProofModal()" class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 flex justify-center bg-slate-50 dark:bg-slate-800/10 min-h-[300px] items-center">
            <img id="modal-proof-img" src="" class="max-w-full max-h-[450px] object-contain rounded-2xl shadow-md border border-slate-200 dark:border-slate-800" alt="Bukti Transfer">
        </div>
        <div class="p-4 border-t border-slate-100 dark:border-darkBorder flex justify-end">
            <button onclick="closeProofModal()" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold py-2 px-6 rounded-xl text-sm transition-colors">
                Tutup Pratinjau
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openProofModal(imgSrc, trxId) {
        const modal = document.getElementById('proof-modal');
        const img = document.getElementById('modal-proof-img');
        const text = document.getElementById('modal-trx-id');
        
        if (modal && img && text) {
            img.src = imgSrc;
            text.textContent = trxId;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeProofModal() {
        const modal = document.getElementById('proof-modal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }

    // Close modal when clicking on overlay background
    document.getElementById('proof-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProofModal();
        }
    });
</script>
@endsection
