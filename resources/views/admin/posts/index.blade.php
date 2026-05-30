@extends('layouts.app')

@section('title', 'Moderasi Komunitas')
@section('header_title', 'Kelola Komunitas')

@section('content')
<div class="space-y-6">
    <!-- Header Block -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <div>
            <h2 class="text-lg font-extrabold text-slate-800 dark:text-white leading-none">Moderasi Feed Komunitas</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 font-semibold">Tinjau aktivitas postingan feed dan tanggapan komentar dari para pengguna untuk menjaga suasana positif.</p>
        </div>
        <span class="bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-300 text-xs px-3 py-1.5 rounded-full font-black uppercase tracking-wider">
            Total: {{ $posts->total() }} Postingan
        </span>
    </div>

    <!-- Search/Moderation Filters -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 space-y-1">
                <label for="search" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Cari Kata Kunci Postingan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari konten postingan atau nama penulis..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl pl-10 pr-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-6 rounded-2xl text-sm transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-rose-600/10">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Tinjau</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.posts.index') }}" class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-2.5 px-4 rounded-2xl text-sm transition-colors flex items-center justify-center" title="Reset Filter">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Posts Listing block -->
    <div class="space-y-6">
        @forelse($posts as $post)
            <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder shadow-sm p-6 space-y-4">
                <!-- User Profile & Action Block -->
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-sm uppercase">
                            {{ substr($post->user->name, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-slate-800 dark:text-white capitalize flex items-center gap-1.5">
                                <span>{{ $post->user->name }}</span>
                                <span class="bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 text-[9px] px-1.5 py-0.5 rounded font-black uppercase">{{ $post->user->getLeaderboardBadge() }}</span>
                            </p>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Delete Post Button -->
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan feed dari @{{ $post->user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-950/40 dark:hover:bg-rose-950/60 p-2 rounded-xl flex items-center gap-1 text-xs font-bold transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span>Hapus Postingan</span>
                        </button>
                    </form>
                </div>

                <!-- Content -->
                <p class="text-sm text-slate-700 dark:text-slate-200 font-medium leading-relaxed bg-slate-50 dark:bg-slate-800/30 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/40">
                    {{ $post->content }}
                </p>

                <!-- Likes & Comments count indicators -->
                <div class="flex items-center gap-4 text-xs font-bold text-slate-400">
                    <span class="flex items-center gap-1"><i data-lucide="heart" class="w-4 h-4 text-rose-500"></i> {{ $post->likes_count }} Suka</span>
                    <span class="flex items-center gap-1"><i data-lucide="message-square" class="w-4 h-4 text-primary-500"></i> {{ $post->comments->count() }} Komentar</span>
                </div>

                <!-- Nested Comments Box -->
                @if($post->comments->isNotEmpty())
                    <div class="border-t border-slate-100 dark:border-darkBorder pt-4 space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 block">Daftar Komentar</span>
                        <div class="space-y-3 pl-4 border-l-2 border-slate-100 dark:border-darkBorder">
                            @foreach($post->comments as $comment)
                                <div class="bg-slate-50/50 dark:bg-slate-800/10 p-3 rounded-2xl border border-slate-100 dark:border-darkBorder/40 flex items-start justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black text-slate-800 dark:text-white capitalize">{{ $comment->user->name }}</span>
                                            <span class="text-[9px] text-slate-400 font-semibold">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-slate-600 dark:text-slate-300 font-medium">{{ $comment->content }}</p>
                                    </div>

                                    <!-- Delete Comment Button -->
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar dari @{{ $comment->user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-1 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded transition-colors" title="Hapus Komentar">
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-darkCard rounded-3xl border border-slate-200 dark:border-darkBorder p-10 text-center text-slate-400 dark:text-slate-500 font-semibold">
                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
                <span>Tidak ditemukan postingan feed yang aktif saat ini.</span>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="bg-white dark:bg-darkCard p-4 rounded-3xl border border-slate-200 dark:border-darkBorder">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
