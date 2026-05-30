@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('header_title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <div>
            <h2 class="text-lg font-extrabold text-slate-800 dark:text-white leading-none">Daftar Pengguna Website</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 font-semibold">Cari, edit profil, kelola poin, streak, atau nonaktifkan akun pengguna.</p>
        </div>
        <span class="bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-300 text-xs px-3 py-1.5 rounded-full font-black uppercase tracking-wider">
            Total: {{ $users->total() }} Pengguna
        </span>
    </div>

    <!-- Filter & Search Panel -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
            <!-- Search field -->
            <div class="space-y-1">
                <label for="search" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Cari Pengguna</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>

            <!-- Filter by Role -->
            <div class="space-y-1">
                <label for="role" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Filter Hak Akses</label>
                <select name="role" id="role" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Peran</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User biasa</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <!-- Filter by Premium Status -->
            <div class="space-y-1">
                <label for="status" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Filter Keanggotaan</label>
                <select name="status" id="status" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">Semua Anggota</option>
                    <option value="premium" {{ request('status') == 'premium' ? 'selected' : '' }}>Premium Aktif</option>
                    <option value="regular" {{ request('status') == 'regular' ? 'selected' : '' }}>User Gratisan</option>
                </select>
            </div>

            <!-- Filter Action buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-rose-600/10">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Saring</span>
                </button>
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center" title="Reset Filter">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Block -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-400 dark:text-slate-500 text-xs font-black uppercase tracking-wider border-b border-slate-100 dark:border-darkBorder">
                        <th class="px-6 py-4">Profil & Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Poin / Streak</th>
                        <th class="px-6 py-4 text-center">Hak Akses</th>
                        <th class="px-6 py-4 text-center">Status Premium</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors">
                            <!-- Avatar and Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        @if($user->profile_image)
                                            <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" alt="Avatar">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-sm uppercase">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-800 dark:text-white capitalize flex items-center gap-1.5">
                                            <span>{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-500 text-[9px] px-1.5 py-0.5 rounded font-black uppercase">Anda</span>
                                            @endif
                                        </p>
                                        <span class="bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 text-[9px] px-1.5 py-0.5 rounded font-black uppercase mt-0.5 inline-block">{{ $user->getLeaderboardBadge() }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-500 dark:text-slate-400">
                                {{ $user->email }}
                            </td>

                            <!-- Points and Streak -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-sm font-black text-slate-800 dark:text-white">{{ number_format($user->points) }} Poin</span>
                                    <span class="text-[10px] text-orange-500 font-extrabold flex items-center gap-0.5 mt-0.5">
                                        <i data-lucide="flame" class="w-3 h-3"></i> {{ $user->streak }} Hari Streak
                                    </span>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->isAdmin())
                                    <span class="bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                        Admin
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                        User
                                    </span>
                                @endif
                            </td>

                            <!-- Premium Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex flex-col items-center gap-1">
                                    @if($user->isPremium())
                                        <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/50 dark:text-orange-300 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                            Aktif
                                        </span>
                                        @if($user->premium_until)
                                            <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold">s/d {{ $user->premium_until->format('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span class="bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-600 text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">
                                            Gratis
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Toggle Premium -->
                                    <form action="{{ route('admin.users.toggle-premium', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-xl {{ $user->is_premium ? 'bg-orange-50 text-orange-600 dark:bg-orange-950/40' : 'bg-slate-50 text-slate-600 dark:bg-slate-800' }} hover:scale-105 transition-transform" title="{{ $user->is_premium ? 'Matikan Premium' : 'Aktifkan Premium' }}">
                                            <i data-lucide="crown" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    <!-- Edit Profile Details -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 rounded-xl hover:scale-105 transition-transform inline-block" title="Edit Profil">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Delete Account -->
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun @{{ $user->name }} secara permanen? Seluruh data tantangan, jurnal, dan postingan miliknya juga akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 dark:bg-rose-950/40 rounded-xl hover:scale-105 transition-transform" title="Hapus Permanen">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                                </div>
                                <span>Tidak ditemukan pengguna yang cocok dengan kriteria pencarian Anda.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-darkBorder">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
