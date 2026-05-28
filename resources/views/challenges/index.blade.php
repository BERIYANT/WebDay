@extends('layouts.app')

@section('title', 'Daftar Daily Challenge')
@section('header_title', 'Daily Challenge')

@section('styles')
<style>
    .youtube-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 ratio */
        height: 0;
        overflow: hidden;
        border-radius: 20px;
    }
    .youtube-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Header Description Card -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-3">
        <h2 class="text-xl font-extrabold text-slate-800 dark:text-white">Ekosistem Kebiasaan Harian</h2>
        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed max-w-2xl">
            Pilihlah tantangan pengembangan diri di bawah ini. Selesaikan latihan harian untuk meningkatkan streak, naik level, dan kumpulkan poin reward yang dapat ditukarkan langsung dengan akses Premium eksklusif!
        </p>
    </div>

    <!-- Category Selector Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-none">
        @foreach(['Semua', 'Health & Fitness', 'Journaling', 'Productivity', 'Self Improvement'] as $cat)
            <button onclick="filterCategory('{{ $cat }}')" id="tab-{{ str_replace('& ', '', $cat) }}" class="category-tab px-4 py-2 text-xs font-bold rounded-2xl border transition-all whitespace-nowrap
                {{ $cat == 'Semua' 
                    ? 'bg-primary-600 text-white border-primary-600 dark:bg-primary-600 dark:border-primary-600' 
                    : 'bg-white dark:bg-darkCard text-slate-500 dark:text-slate-400 border-slate-200/60 dark:border-darkBorder hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <!-- Challenges Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="challenges-grid">
        @foreach($challenges as $categoryName => $catChallenges)
            @foreach($catChallenges as $ch)
                @php
                    $progressRecord = $userChallenges[$ch->id] ?? null;
                    $status = $progressRecord ? $progressRecord->status : 'not_started';
                    $progress = $progressRecord ? $progressRecord->progress : 0;
                @endphp
                <div class="challenge-card bg-white dark:bg-darkCard rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm p-6 space-y-4 transition-all duration-300 relative overflow-hidden" data-category="{{ $ch->category }}">
                    
                    <!-- Top Ribbon details -->
                    <div class="flex items-start justify-between">
                        <div class="space-y-1.5">
                            <span class="bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 text-[10px] px-2.5 py-0.5 rounded-full font-black uppercase">
                                {{ $ch->category }}
                            </span>
                            @if($ch->is_premium)
                                <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/50 dark:text-orange-300 text-[10px] px-2.5 py-0.5 rounded-full font-black uppercase inline-flex items-center gap-1">
                                    <i data-lucide="crown" class="w-3 h-3 text-orange-500"></i>
                                    <span>Premium</span>
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1.5 text-[10px] text-slate-400 dark:text-slate-500 font-bold">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span>{{ $ch->time_estimate }} Menit</span>
                            <span class="mx-1">•</span>
                            <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                            <span>{{ $ch->difficulty }}</span>
                        </div>
                    </div>

                    <!-- Challenge Title & Description -->
                    <div class="space-y-1.5">
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base leading-tight">{{ $ch->name }}</h3>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed">{{ $ch->description }}</p>
                    </div>

                    <!-- Video Expand Panel (If Started and has Video Link) -->
                    @if($ch->youtube_link)
                        <div class="pt-2">
                            <details class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/60 group" {{ $status == 'started' ? 'open' : '' }}>
                                <summary class="flex items-center justify-between text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer list-none">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="play-circle" class="w-4 h-4 text-orange-500"></i>
                                        <span>Video Tutorial & Anti-Cheat Tracker</span>
                                    </div>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                                </summary>
                                
                                <div class="mt-4 space-y-4">
                                    @if($ch->is_premium && !Auth::user()->isPremium())
                                        <!-- Locked premium wall -->
                                        <div class="bg-slate-100 dark:bg-slate-900/60 p-6 rounded-2xl text-center space-y-3 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 dark:border-darkBorder">
                                            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/20 text-orange-500 rounded-full flex items-center justify-center">
                                                <i data-lucide="lock" class="w-6 h-6"></i>
                                            </div>
                                            <h4 class="text-xs font-black text-slate-800 dark:text-white">Video Premium Terkunci</h4>
                                            <p class="text-[10px] text-slate-400 font-semibold max-w-[200px] leading-relaxed">Upgrade akun Anda ke Premium untuk dapat membuka dan menonton materi eksklusif ini.</p>
                                            <a href="{{ route('premium.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-[10px] px-4 py-2 rounded-xl shadow-md transition-colors">Upgrade Sekarang</a>
                                        </div>
                                    @else
                                        <!-- Tracked IFrame player block -->
                                        <div class="youtube-container relative shadow-md">
                                            <div id="player-{{ $ch->id }}" class="yt-player" data-video-id="{{ $ch->youtube_link }}" data-challenge-id="{{ $ch->id }}" data-status="{{ $status }}"></div>
                                        </div>
                                        
                                        <!-- Watch Progress Bar -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-[10px] font-bold text-slate-400 dark:text-slate-500">
                                                <span>Progress Menonton</span>
                                                <span id="progress-text-{{ $ch->id }}">{{ $progress }}%</span>
                                            </div>
                                            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                                <div id="progress-bar-{{ $ch->id }}" class="bg-emerald-500 rounded-full h-2 transition-all" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <p class="text-[9px] text-slate-400 font-medium leading-relaxed italic mt-1">
                                                *Anti-Cheat: Tonton minimal 50% dari total durasi video untuk menyelesaikan challenge ini dan mengklaim poin reward secara otomatis.
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Dynamic Youtube link update input -->
                                    <form action="{{ route('challenges.youtube', $ch->id) }}" method="POST" class="pt-2 border-t border-slate-100 dark:border-darkBorder/40">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="youtube_link" required placeholder="Ganti link Youtube dinamis..." value="{{ $ch->youtube_link }}" class="flex-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-darkBorder rounded-xl py-2 px-3 text-[10px] font-semibold outline-none text-slate-800 dark:text-white transition-colors">
                                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white text-[10px] font-bold py-2.5 px-3 rounded-xl transition-colors">Simpan Link</button>
                                        </div>
                                    </form>
                                </div>
                            </details>
                        </div>
                    @endif

                    <!-- Bottom CTA Buttons -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-darkBorder">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500">Reward: +{{ $ch->points_reward }} Poin</span>
                        
                        <div class="flex items-center gap-2">
                            @if($status == 'not_started')
                                <form action="{{ route('challenges.start', $ch->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-1">
                                        <i data-lucide="play" class="w-3.5 h-3.5"></i>
                                        <span>Mulai</span>
                                    </button>
                                </form>
                            @elseif($status == 'started')
                                @if($ch->youtube_link)
                                    <!-- Video lock: can not solve manually -->
                                    <button disabled class="bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed font-bold text-xs px-4 py-2.5 rounded-xl border border-slate-200/50 dark:border-darkBorder flex items-center gap-1">
                                        <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                        <span>Tonton Video</span>
                                    </button>
                                @else
                                    <form action="{{ route('challenges.complete', $ch->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="bypass_video" value="1">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-1">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            <span>Selesaikan</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="bg-emerald-50 text-emerald-700 dark:bg-emerald-950/20 dark:text-emerald-300 font-black text-xs px-4 py-2.5 rounded-xl flex items-center gap-1 border border-emerald-100 dark:border-emerald-900/50">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                    <span>Tantangan Selesai</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<!-- Load YouTube Iframe Player API -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    // Tab filtering logic
    function filterCategory(cat) {
        // Toggle tabs active style
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.className = "category-tab px-4 py-2 text-xs font-bold rounded-2xl border transition-all whitespace-nowrap bg-white dark:bg-darkCard text-slate-500 dark:text-slate-400 border-slate-200/60 dark:border-darkBorder hover:bg-slate-50 dark:hover:bg-slate-800";
        });
        const currentTabId = "tab-" + cat.replace('& ', '');
        const currentTab = document.getElementById(currentTabId);
        if (currentTab) {
            currentTab.className = "category-tab px-4 py-2 text-xs font-bold rounded-2xl border transition-all whitespace-nowrap bg-primary-600 text-white border-primary-600 dark:bg-primary-600 dark:border-primary-600";
        }

        // Toggle cards visibility
        document.querySelectorAll('.challenge-card').forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (cat === 'Semua' || cardCat === cat) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // YouTube Iframe Player Tracker Implementation
    const players = {};
    const trackingTimers = {};

    function onYouTubeIframeAPIReady() {
        document.querySelectorAll('.yt-player').forEach(container => {
            const elId = container.id;
            const videoUrl = container.getAttribute('data-video-id');
            const challengeId = container.getAttribute('data-challenge-id');
            const status = container.getAttribute('data-status');

            // Extract video ID from youtube link
            const videoId = extractVideoId(videoUrl);
            if (!videoId) return;

            // Instantiate player
            players[challengeId] = new YT.Player(elId, {
                videoId: videoId,
                playerVars: {
                    'playsinline': 1,
                    'controls': 1,
                    'modestbranding': 1,
                    'rel': 0
                },
                events: {
                    'onStateChange': (e) => onPlayerStateChange(e, challengeId, status)
                }
            });
        });
    }

    function extractVideoId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length == 11) ? match[2] : null;
    }

    function onPlayerStateChange(event, challengeId, status) {
        // YT.PlayerState.PLAYING is 1
        if (event.data === YT.PlayerState.PLAYING && status === 'started') {
            // Start checking progress timer
            if (!trackingTimers[challengeId]) {
                trackingTimers[challengeId] = setInterval(() => checkProgress(challengeId), 3000);
            }
        } else {
            // Pause timer if paused or stopped
            if (trackingTimers[challengeId]) {
                clearInterval(trackingTimers[challengeId]);
                delete trackingTimers[challengeId];
            }
        }
    }

    function checkProgress(challengeId) {
        const player = players[challengeId];
        if (!player) return;

        const currentTime = player.getCurrentTime();
        const duration = player.getDuration();
        if (duration <= 0) return;

        const progressPercent = Math.round((currentTime / duration) * 100);

        // Update progress bar on UI
        const progressBar = document.getElementById(`progress-bar-${challengeId}`);
        const progressText = document.getElementById(`progress-text-${challengeId}`);
        if (progressBar) progressBar.style.width = `${progressPercent}%`;
        if (progressText) progressText.textContent = `${progressPercent}%`;

        // Send tracking updates to database via AJAX
        fetch('{{ route("challenges.track-video") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                challenge_id: challengeId,
                progress: progressPercent,
                watched_seconds: Math.round(currentTime)
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.status === 'completed') {
                // Clear active timer
                clearInterval(trackingTimers[challengeId]);
                delete trackingTimers[challengeId];

                // Play success animation (e.g. reload or trigger banner)
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(err => console.error("Video tracking error:", err));
    }
</script>
@endsection
