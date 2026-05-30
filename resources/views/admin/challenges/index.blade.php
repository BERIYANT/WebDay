@extends('layouts.app')

@section('title', 'Kelola Tantangan')
@section('header_title', 'Kelola Tantangan')

@section('content')
<div class="space-y-6">
    <!-- Header Block -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <div>
            <h2 class="text-lg font-extrabold text-slate-800 dark:text-white leading-none">Daftar Daily Challenge</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 font-semibold">Tambahkan tantangan pengembangan diri baru atau modifikasi kategori dan detail yang ada.</p>
        </div>
        <a href="{{ route('admin.challenges.create') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-5 rounded-2xl text-sm transition-colors flex items-center gap-1.5 shadow-md shadow-rose-600/10 hover:scale-102 transition-transform">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Challenge</span>
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <form action="{{ route('admin.challenges.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
            <!-- Search -->
            <div class="space-y-1 col-span-1 sm:col-span-2 md:col-span-1">
                <label for="search" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Cari Tantangan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama / kategori..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="space-y-1">
                <label for="category" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Filter Kategori</label>
                <select name="category" id="category" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Difficulty Filter -->
            <div class="space-y-1">
                <label for="difficulty" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tingkat Kesulitan</label>
                <select name="difficulty" id="difficulty" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Kesulitan</option>
                    <option value="Easy" {{ request('difficulty') === 'Easy' ? 'selected' : '' }}>Mudah (Easy)</option>
                    <option value="Medium" {{ request('difficulty') === 'Medium' ? 'selected' : '' }}>Sedang (Medium)</option>
                    <option value="Hard" {{ request('difficulty') === 'Hard' ? 'selected' : '' }}>Sulit (Hard)</option>
                </select>
            </div>

            <!-- Premium Lock Filter -->
            <div class="space-y-1">
                <label for="premium" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Akses Premium</label>
                <select name="premium" id="premium" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Akses</option>
                    <option value="no" {{ request('premium') === 'no' ? 'selected' : '' }}>Free (Gratis)</option>
                    <option value="yes" {{ request('premium') === 'yes' ? 'selected' : '' }}>Khusus Premium</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-rose-600/10">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Saring</span>
                </button>
                @if(request()->anyFilled(['search', 'category', 'difficulty', 'premium']))
                    <a href="{{ route('admin.challenges.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center" title="Reset Filter">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Challenges Table block -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 text-xs font-black uppercase tracking-wider border-b border-slate-100 dark:border-darkBorder">
                        <th class="px-6 py-4">Nama & Kategori</th>
                        <th class="px-6 py-4">Deskripsi Ringkas</th>
                        <th class="px-6 py-4 text-center">Tingkat Kesulitan</th>
                        <th class="px-6 py-4 text-center">Poin / Estimasi</th>
                        <th class="px-6 py-4 text-center">Tipe Akses</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @forelse($challenges as $challenge)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors">
                            <!-- Category and Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    <p class="text-sm font-extrabold text-slate-800 dark:text-white">{{ $challenge->name }}</p>
                                    <span class="inline-block bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] px-2 py-0.5 rounded font-black uppercase">
                                        {{ $challenge->category }}
                                    </span>
                                    @if($challenge->youtube_link)
                                        <span class="inline-block bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase ml-1">
                                            Video Proof
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 font-semibold max-w-xs truncate">
                                {{ $challenge->description }}
                            </td>

                            <!-- Difficulty -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($challenge->difficulty === 'Easy')
                                    <span class="bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Mudah</span>
                                @elseif($challenge->difficulty === 'Medium')
                                    <span class="bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Sedang</span>
                                @else
                                    <span class="bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Sulit</span>
                                @endif
                            </td>

                            <!-- Points & Est -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-sm font-black text-slate-800 dark:text-white">+{{ $challenge->points_reward }} Poin</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold mt-0.5">⏱ {{ $challenge->time_estimate }} Menit</span>
                                </div>
                            </td>

                            <!-- Premium Lock status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($challenge->is_premium)
                                    <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/50 dark:text-orange-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider flex items-center gap-1 mx-auto w-fit">
                                        <i data-lucide="crown" class="w-3.5 h-3.5"></i> Premium
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-600 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider w-fit mx-auto block">
                                        Gratis
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Challenge -->
                                    <a href="{{ route('admin.challenges.edit', $challenge->id) }}" class="p-2 bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 rounded-xl hover:scale-105 transition-transform" title="Ubah Challenge">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Delete Challenge -->
                                    <form action="{{ route('admin.challenges.destroy', $challenge->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tantangan \'{{ $challenge->name }}\' secara permanen? Data riwayat progress tantangan pengguna juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 dark:bg-rose-950/40 rounded-xl hover:scale-105 transition-transform" title="Hapus Permanen">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                                </div>
                                <span>Tidak ditemukan tantangan yang cocok dengan kriteria pencarian Anda.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($challenges->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-darkBorder">
                {{ $challenges->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
