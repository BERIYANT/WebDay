@extends('layouts.app')

@section('title', 'Kelola Saran Masuk')
@section('header_title', 'Kelola Saran Masuk')

@section('content')
<div class="space-y-6">
    <!-- Header Summary Block -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <div>
            <h2 class="text-lg font-extrabold text-slate-800 dark:text-white leading-none">Saran & Masukan Pengguna</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 font-semibold">Tinjau seluruh kritik, saran perbaikan, dan laporan kendala dari pengguna aplikasi WebDay secara real-time.</p>
        </div>
        <span class="bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-300 text-xs px-3 py-1.5 rounded-full font-black uppercase tracking-wider">
            Total: {{ $feedbacks->total() }} Saran Masuk
        </span>
    </div>

    <!-- Filter & Search Panel -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <form action="{{ route('admin.feedbacks.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search field -->
            <div class="space-y-1 md:col-span-3">
                <label for="search" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Cari Saran / Pengirim</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama pengirim, email, atau isi masukan..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>

            <!-- Filter Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-rose-600/10">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Saring</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.feedbacks.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center" title="Reset Pencarian">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Feedbacks Table/Card Block -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 text-xs font-black uppercase tracking-wider border-b border-slate-100 dark:border-darkBorder">
                        <th class="px-6 py-4 w-1/4">Pengirim</th>
                        <th class="px-6 py-4 w-1/2">Detail Pesan</th>
                        <th class="px-6 py-4 text-center w-1/6">Waktu Pengiriman</th>
                        <th class="px-6 py-4 text-right w-1/12">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @forelse($feedbacks as $feedback)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors">
                            <!-- Sender profile info -->
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <div class="flex items-start gap-3">
                                    <div class="relative flex-shrink-0">
                                        @if($feedback->user && $feedback->user->profile_image)
                                            <img src="{{ asset('uploads/profiles/' . $feedback->user->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" alt="Avatar">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-rose-500 text-white font-bold flex items-center justify-center text-sm uppercase shadow-sm">
                                                {{ substr($feedback->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 space-y-1">
                                        <p class="text-sm font-extrabold text-slate-800 dark:text-white capitalize truncate flex items-center gap-1.5">
                                            <span>{{ $feedback->name }}</span>
                                        </p>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold block truncate">{{ $feedback->email }}</span>
                                        
                                        @if($feedback->user)
                                            <span class="inline-flex bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-wider">
                                                Member
                                            </span>
                                        @else
                                            <span class="inline-flex bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-wider">
                                                Tamu
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Detailed Message Content -->
                            <td class="px-6 py-4 align-top space-y-2">
                                <!-- Subject -->
                                <div class="flex items-center gap-2">
                                    <span class="bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400 text-[9px] px-2 py-0.5 rounded font-black uppercase">Subjek</span>
                                    <h4 class="text-sm font-extrabold text-slate-800 dark:text-slate-200">{{ $feedback->subject }}</h4>
                                </div>

                                <!-- Pesan text -->
                                <div class="text-xs font-semibold text-slate-600 dark:text-slate-400 whitespace-pre-wrap leading-relaxed bg-slate-50/50 dark:bg-slate-800/10 p-3.5 rounded-2xl border border-slate-100 dark:border-darkBorder/40">
                                    {{ $feedback->content }}
                                </div>

                                <!-- Phone / Chat contact details -->
                                <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400 dark:text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ $feedback->phone }}</span>
                                    </span>
                                    <span>•</span>
                                    @php
                                        // Clean phone number for WhatsApp redirect
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $feedback->phone);
                                        // Standardize country prefix for ID
                                        if (str_starts_with($cleanPhone, '08')) {
                                            $cleanPhone = '628' . substr($cleanPhone, 2);
                                        }
                                    @endphp
                                    <a href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text=Halo%20{{ rawurlencode($feedback->name) }}%2C%20kami%20telah%20menerima%20pesan%20Anda%20mengenai%20%22{{ rawurlencode($feedback->subject) }}%22%20di%20WebDay." 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 font-extrabold transition-colors">
                                        <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                        <span>Balas via WhatsApp</span>
                                    </a>
                                </div>
                            </td>

                            <!-- Submitted Time -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-slate-500 dark:text-slate-400 font-bold align-top">
                                <div class="inline-flex flex-col items-center">
                                    <span>{{ $feedback->created_at->format('d M Y H:i') }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold mt-0.5">({{ $feedback->created_at->diffForHumans() }})</span>
                                </div>
                            </td>

                            <!-- Actions (Delete) -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold align-top">
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus saran dari \'{{ $feedback->name }}\' secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 dark:bg-rose-950/40 rounded-xl hover:scale-105 transition-transform" title="Hapus Permanen">
                                        <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                    <i data-lucide="message-square" class="w-8 h-8"></i>
                                </div>
                                <p class="text-sm font-bold">Tidak Ada Saran</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Belum ada saran yang dikirimkan oleh pengguna aplikasi WebDay saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($feedbacks->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-darkBorder">
                {{ $feedbacks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
