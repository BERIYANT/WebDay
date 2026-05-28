@extends('layouts.app')

@section('title', 'Komunitas Premium')
@section('header_title', 'Komunitas')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Timeline feed column -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Post publisher form -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('uploads/profiles/' . Auth::user()->profile_image) }}" class="w-10 h-10 rounded-full object-cover" alt="Avatar">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-sm uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-darkCard rounded-full"></div>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-sm capitalize">Bagikan progress kamu, {{ Auth::user()->name }}!</h3>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Posting updates & earn points (+10 Pts)</p>
                </div>
            </div>

            <form action="{{ route('community.store-post') }}" method="POST" class="space-y-3">
                @csrf
                <textarea name="content" required rows="3" placeholder="Tulis inspirasimu hari ini atau bagikan progress challenge harianmu..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl p-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors leading-relaxed"></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all">
                        Kirim Postingan
                    </button>
                </div>
            </form>
        </div>

        <!-- Posts listing feed -->
        <div class="space-y-6">
            @foreach($posts as $post)
                @php
                    $isLiked = $post->isLikedByUser(Auth::user()->id);
                @endphp
                <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
                    
                    <!-- Post Header details -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase shadow-sm">
                                {{ substr($post->user->name, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-800 dark:text-white capitalize flex items-center gap-1.5">
                                    <span>{{ $post->user->name }}</span>
                                    <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-300 text-[9px] px-1.5 py-0.2 rounded font-black uppercase">
                                        {{ $post->user->getLeaderboardBadge() }}
                                    </span>
                                </h4>
                                <span class="text-[9px] text-slate-400 font-bold">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Post Body text -->
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-semibold leading-relaxed whitespace-pre-line">{{ $post->content }}</p>

                    <!-- Like and comment counters bar -->
                    <div class="flex items-center gap-6 py-1 border-y border-slate-100 dark:border-darkBorder/40 text-[11px] font-bold text-slate-500">
                        <!-- Like Button (AJAX) -->
                        <button onclick="likePost(this, {{ $post->id }})" class="flex items-center gap-1.5 hover:text-rose-500 transition-colors {{ $isLiked ? 'text-rose-600' : '' }}">
                            <i data-lucide="heart" class="w-4 h-4 {{ $isLiked ? 'fill-rose-600' : '' }}"></i>
                            <span id="likes-count-{{ $post->id }}">{{ $post->likes_count }} Suka</span>
                        </button>
                        
                        <!-- Comment reveal button -->
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                            <span>{{ count($post->comments) }} Komentar</span>
                        </div>
                    </div>

                    <!-- Discussion Comment list -->
                    <div class="space-y-3 pt-2">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start gap-3 bg-slate-50/50 dark:bg-slate-800/20 p-3 rounded-2xl border border-slate-100/60 dark:border-darkBorder/40 text-xs">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white font-bold flex items-center justify-center text-[10px] uppercase flex-shrink-0 shadow-inner">
                                    {{ substr($comment->user->name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-extrabold text-[11px] text-slate-800 dark:text-white capitalize flex items-center gap-1.5">
                                        <span>{{ $comment->user->name }}</span>
                                        <span class="text-[8px] text-slate-400 font-bold">• {{ $comment->created_at->diffForHumans() }}</span>
                                    </h5>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1 leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Comment publisher input -->
                        <form action="{{ route('community.store-comment', $post->id) }}" method="POST" class="flex items-center gap-2 pt-2">
                            @csrf
                            <input type="text" name="content" required placeholder="Tulis komentar..." class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-2 px-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors">
                            <button type="submit" class="p-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md transition-colors">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

    </div>

    <!-- Side information column (Daily inspiration banner) -->
    <div class="space-y-6">
        
        <!-- Daily inspiration quote box -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4 relative overflow-hidden">
            <div class="absolute -right-16 -bottom-16 w-36 h-36 bg-orange-500/5 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-darkBorder pb-3">
                <i data-lucide="sparkles" class="w-5 h-5 text-orange-500"></i>
                <h4 class="font-extrabold text-slate-800 dark:text-white text-xs">Inspirasi Harian</h4>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold leading-relaxed italic">
                "{{ $dailyInspiration }}"
            </p>
        </div>

        <!-- active premium users catalog -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 dark:border-darkBorder pb-3">
                <i data-lucide="users" class="w-5 h-5 text-primary-500"></i>
                <h4 class="font-extrabold text-slate-800 dark:text-white text-xs">Warrior Aktif</h4>
            </div>
            <div class="space-y-3">
                @foreach(['salma', 'rafiqoh', 'nurul', 'aji', 'nathania'] as $wName)
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-[10px] uppercase shadow-sm">
                                {{ substr($wName, 0, 2) }}
                            </span>
                            <span class="text-slate-800 dark:text-slate-200 capitalize">{{ $wName }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-[9px] text-slate-400 font-bold uppercase">Online</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    // AJAX Liking post system
    function likePost(button, postId) {
        fetch(`/community/post/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const countSpan = document.getElementById(`likes-count-${postId}`);
                if (countSpan) {
                    countSpan.textContent = `${data.likes_count} Suka`;
                }

                const heartIcon = button.querySelector('i');
                if (data.liked) {
                    button.classList.add('text-rose-600');
                    if (heartIcon) heartIcon.classList.add('fill-rose-600');
                } else {
                    button.classList.remove('text-rose-600');
                    if (heartIcon) heartIcon.classList.remove('fill-rose-600');
                }
            }
        })
        .catch(err => console.error("Like error:", err));
    }
</script>
@endsection
