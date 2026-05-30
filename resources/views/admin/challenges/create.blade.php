@extends('layouts.app')

@section('title', 'Tambah Challenge Baru')
@section('header_title', 'Kelola Tantangan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Navigation Back Link -->
    <a href="{{ route('admin.challenges.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Kembali ke Daftar</span>
    </a>

    <!-- Form Container -->
    <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-darkBorder bg-slate-50/50 dark:bg-slate-800/20 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 dark:bg-rose-950/40 flex items-center justify-center">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800 dark:text-white">Tambah Daily Challenge Baru</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Definisikan tantangan baru untuk menguji konsistensi pengembangan diri pengguna.</p>
            </div>
        </div>

        <form action="{{ route('admin.challenges.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Category input -->
            <div class="space-y-1.5">
                <label for="category" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kategori Tantangan</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <select id="category-selector" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500" onchange="toggleCategoryInput(this)">
                        <option value="Health & Fitness">Health & Fitness (Olahraga & Kesehatan)</option>
                        <option value="Journaling">Journaling (Refleksi Jurnal)</option>
                        <option value="Productivity">Productivity (Fokus & Produktivitas)</option>
                        <option value="Self Improvement">Self Improvement (Pengembangan Diri)</option>
                        <option value="custom">-- Tulis Kategori Kustom --</option>
                    </select>
                    <!-- Custom category text input, hidden by default -->
                    <input type="text" name="category" id="category-custom" value="Health & Fitness" required placeholder="Tulis kategori baru..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
                @error('category')
                    <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name field -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Tantangan</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Jalan Kaki 30 Menit" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                @error('name')
                    <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description field -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Deskripsi Lengkap & Instruksi</label>
                <textarea name="description" id="description" rows="4" required placeholder="Jelaskan langkah-langkah tantangan serta apa yang harus dilakukan pengguna..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Difficulty, Points, Est columns -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Difficulty -->
                <div class="space-y-1.5 col-span-1">
                    <label for="difficulty" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tingkat Kesulitan</label>
                    <select name="difficulty" id="difficulty" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                        <option value="Easy" {{ old('difficulty') === 'Easy' ? 'selected' : '' }}>Mudah (Easy)</option>
                        <option value="Medium" {{ old('difficulty') === 'Medium' ? 'selected' : '' }}>Sedang (Medium)</option>
                        <option value="Hard" {{ old('difficulty') === 'Hard' ? 'selected' : '' }}>Sulit (Hard)</option>
                    </select>
                    @error('difficulty')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Points -->
                <div class="space-y-1.5 col-span-1">
                    <label for="points_reward" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Poin Hadiah</label>
                    <input type="number" name="points_reward" id="points_reward" value="{{ old('points_reward', 15) }}" min="1" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    @error('points_reward')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Est Duration -->
                <div class="space-y-1.5 col-span-1">
                    <label for="time_estimate" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Estimasi Waktu (Menit)</label>
                    <input type="number" name="time_estimate" id="time_estimate" value="{{ old('time_estimate', 15) }}" min="1" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    @error('time_estimate')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- YouTube link validation & Premium status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Premium locked -->
                <div class="space-y-1.5 col-span-1">
                    <label for="is_premium" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Keanggotaan Akses</label>
                    <select name="is_premium" id="is_premium" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                        <option value="0" {{ old('is_premium') == '0' ? 'selected' : '' }}>Free (Semua pengguna dapat mengakses)</option>
                        <option value="1" {{ old('is_premium') == '1' ? 'selected' : '' }}>Premium Only (Kunci di balik status premium)</option>
                    </select>
                    @error('is_premium')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- YouTube link verification -->
                <div class="space-y-1.5 col-span-1">
                    <label for="youtube_link" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Link Video YouTube (Verifikasi Opsional)</label>
                    <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link') }}" placeholder="https://youtube.com/watch?v=..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                    @error('youtube_link')
                        <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit action block -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-darkBorder">
                <a href="{{ route('admin.challenges.index') }}" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold py-2.5 px-6 rounded-2xl text-sm transition-colors">
                    Batalkan
                </a>
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-6 rounded-2xl text-sm transition-colors shadow-md shadow-rose-600/10 flex items-center gap-1.5">
                    <i data-lucide="save" class="w-4.5 h-4.5"></i>
                    <span>Tambah Challenge</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleCategoryInput(select) {
        const customInput = document.getElementById('category-custom');
        if (select.value === 'custom') {
            customInput.value = '';
            customInput.classList.remove('hidden');
            customInput.focus();
        } else {
            customInput.value = select.value;
            customInput.classList.add('hidden');
        }
    }

    // Initialize custom category visibility on load
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('category-selector');
        const customInput = document.getElementById('category-custom');
        if (selector && customInput) {
            if (selector.value === 'custom') {
                customInput.classList.remove('hidden');
            } else {
                customInput.classList.add('hidden');
                customInput.value = selector.value;
            }
        }
    });
</script>
@endsection
