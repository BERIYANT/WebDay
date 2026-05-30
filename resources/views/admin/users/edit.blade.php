@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('header_title', 'Kelola Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back navigation -->
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>

    <!-- Edit Profile Card -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-darkBorder bg-slate-50/50 dark:bg-slate-800/20 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-lg uppercase shadow-inner">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800 dark:text-white">Edit Profil Pengguna</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Memperbarui data akun untuk @<span class="capitalize font-bold">{{ $user->name }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name field -->
                <div class="space-y-1.5 col-span-1">
                    <label for="name" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Pengguna</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500 capitalize">
                    @error('name')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email field -->
                <div class="space-y-1.5 col-span-1">
                    <label for="email" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    @error('email')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Points field -->
                <div class="space-y-1.5 col-span-1">
                    <label for="points" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Poin Gamifikasi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="gem" class="w-4 h-4 text-primary-500"></i>
                        </span>
                        <input type="number" name="points" id="points" value="{{ old('points', $user->points) }}" min="0" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    </div>
                    @error('points')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Streak field -->
                <div class="space-y-1.5 col-span-1">
                    <label for="streak" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Streak Hari Berturut-turut</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="flame" class="w-4 h-4 text-orange-500"></i>
                        </span>
                        <input type="number" name="streak" id="streak" value="{{ old('streak', $user->streak) }}" min="0" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    </div>
                    @error('streak')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div class="space-y-1.5 col-span-1">
                    <label for="role" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Hak Akses Sistem</label>
                    <select name="role" id="role" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password modification (optional) -->
                <div class="space-y-1.5 col-span-1">
                    <label for="password" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kata Sandi Baru (Opsional)</label>
                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin diubah" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    @error('password')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit action block -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-darkBorder">
                <a href="{{ route('admin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold py-2.5 px-6 rounded-2xl text-sm transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-6 rounded-2xl text-sm transition-colors shadow-md shadow-rose-600/10 flex items-center gap-1.5">
                    <i data-lucide="save" class="w-4.5 h-4.5"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
