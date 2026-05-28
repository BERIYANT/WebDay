@extends('layouts.app')

@section('title', 'Journaling & Mood Tracker')
@section('header_title', 'Journaling')

@section('styles')
<style>
    .mood-btn {
        transition: transform 0.2s, background-color 0.2s;
    }
    .mood-btn:hover {
        transform: scale(1.05);
    }
    .mood-selected {
        background-color: rgba(37, 99, 235, 0.15) !important;
        border-color: #2563eb !important;
        color: #2563eb !important;
    }
    .dark .mood-selected {
        background-color: rgba(59, 130, 246, 0.2) !important;
        border-color: #3b82f6 !important;
        color: #60a5fa !important;
    }
    .youtube-container {
        position: relative;
        padding-bottom: 56.25%;
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

    <!-- Overview details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Journal input workspace -->
        <div class="lg:col-span-2 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Tulis Jurnal Hari Ini</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Journal Workspace</p>
                </div>
            </div>

            <!-- Writing form -->
            <form action="{{ route('journal.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Mood selection buttons -->
                <div class="space-y-3">
                    <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Bagaimana perasaanmu saat ini?</label>
                    <div class="grid grid-cols-5 gap-2">
                        <!-- Happy -->
                        <button type="button" onclick="selectMood('happy')" id="mood-happy" class="mood-btn py-3 px-2 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40 flex flex-col items-center gap-1.5 outline-none">
                            <span class="text-xl">😊</span>
                            <span class="text-[9px] font-bold">Senang</span>
                        </button>

                        <!-- Energetic -->
                        <button type="button" onclick="selectMood('energetic')" id="mood-energetic" class="mood-btn py-3 px-2 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40 flex flex-col items-center gap-1.5 outline-none">
                            <span class="text-xl">⚡</span>
                            <span class="text-[9px] font-bold">Semangat</span>
                        </button>

                        <!-- Neutral -->
                        <button type="button" onclick="selectMood('neutral')" id="mood-neutral" class="mood-btn py-3 px-2 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40 flex flex-col items-center gap-1.5 outline-none">
                            <span class="text-xl">😐</span>
                            <span class="text-[9px] font-bold">Biasa</span>
                        </button>

                        <!-- Sad -->
                        <button type="button" onclick="selectMood('sad')" id="mood-sad" class="mood-btn py-3 px-2 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40 flex flex-col items-center gap-1.5 outline-none">
                            <span class="text-xl">😢</span>
                            <span class="text-[9px] font-bold">Sedih</span>
                        </button>

                        <!-- Stressed -->
                        <button type="button" onclick="selectMood('stressed')" id="mood-stressed" class="mood-btn py-3 px-2 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200/50 dark:border-darkBorder/40 flex flex-col items-center gap-1.5 outline-none">
                            <span class="text-xl">🤯</span>
                            <span class="text-[9px] font-bold">Stres</span>
                        </button>
                    </div>
                    <input type="hidden" name="mood" id="selected-mood-input" required value="neutral">
                </div>

                <!-- Textarea -->
                <div class="space-y-1.5">
                    <label for="content" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Refleksi Pikiran (Minimal 10 karakter)</label>
                    <textarea name="content" id="content" rows="6" required placeholder="Tuliskan apa saja kejadian berharga hari ini, kesulitan yang kamu hadapi, atau hal apa yang paling kamu syukuri..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl p-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors leading-relaxed"></textarea>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">*Setiap penulisan jurnal memberikan +15 Poin</span>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition-all">
                        Simpan Jurnal & Poin
                    </button>
                </div>
            </form>
        </div>

        <!-- Consistency and Mood statistics side panels -->
        <div class="space-y-6">
            
            <!-- Circular consistency meter -->
            <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex items-center gap-6">
                <!-- Circular stroke percentage SVG -->
                <div class="relative w-20 h-20 flex-shrink-0">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="40" cy="40" r="34" fill="none" stroke="#e2e8f0" stroke-width="6" class="dark:stroke-slate-700"/>
                        <circle cx="40" cy="40" r="34" fill="none" stroke="#2563eb" stroke-width="6" stroke-dasharray="213.6" stroke-dashoffset="{{ 213.6 - (213.6 * $consistencyRate) / 100 }}" stroke-linecap="round" class="transition-all duration-700"/>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center font-black text-sm text-slate-800 dark:text-white">{{ $consistencyRate }}%</span>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 dark:text-white text-sm">Konsistensi Menulis</h4>
                    <p class="text-[10px] text-slate-400 font-semibold mt-1 leading-normal">Persentase hari menulis jurnal harian Anda dalam 14 hari terakhir.</p>
                </div>
            </div>

            <!-- Calendar logs card -->
            <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 dark:text-white text-xs">Kalender Jurnal Bulan Ini</h4>
                </div>
                
                @php
                    $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                    $startDayOfWeek = \Carbon\Carbon::now()->startOfMonth()->dayOfWeek;
                    // adjust Sunday index from 0 to 7 if necessary
                    if ($startDayOfWeek == 0) $startDayOfWeek = 7;
                @endphp
                <div class="grid grid-cols-7 gap-1.5 text-center text-[10px] font-bold">
                    <!-- Day Labels -->
                    <span class="text-slate-400">Sn</span>
                    <span class="text-slate-400">Sl</span>
                    <span class="text-slate-400">Rb</span>
                    <span class="text-slate-400">Km</span>
                    <span class="text-slate-400">Jm</span>
                    <span class="text-slate-400">Sb</span>
                    <span class="text-slate-400">Mg</span>

                    <!-- Padding cells for start offset -->
                    @for($i = 1; $i < $startDayOfWeek; $i++)
                        <span></span>
                    @endfor

                    <!-- Actual Days -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $isLogged = in_array($day, $calendarEntries);
                        @endphp
                        <span class="h-6 w-6 flex items-center justify-center rounded-full mx-auto
                            {{ $isLogged 
                                ? 'bg-primary-600 text-white shadow-sm font-black' 
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            {{ $day }}
                        </span>
                    @endfor
                </div>
            </div>

            <!-- Mood trend lists -->
            <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 dark:text-white text-xs">Pola & Statistik Mood</h4>
                </div>
                <div class="space-y-3 text-[10px]">
                    @foreach($moodStats as $moodName => $details)
                        @php
                            $emojis = ['happy'=>'😊 Senang','energetic'=>'⚡ Semangat','neutral'=>'😐 Biasa','sad'=>'😢 Sedih','stressed'=>'🤯 Stres'];
                            $colorClasses = ['happy'=>'bg-emerald-500','energetic'=>'bg-amber-500','neutral'=>'bg-blue-500','sad'=>'bg-slate-400','stressed'=>'bg-rose-500'];
                        @endphp
                        <div class="space-y-1">
                            <div class="flex justify-between font-bold text-slate-600 dark:text-slate-400">
                                <span>{{ $emojis[$moodName] }}</span>
                                <span>{{ $details['percentage'] }}% ({{ $details['count'] }} Hari)</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5">
                                <div class="{{ $colorClasses[$moodName] }} rounded-full h-1.5" style="width: {{ $details['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Gratitude Journal Video materials - Premium Protected inline tracked player -->
    @if($gratitudeChallenge)
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
            <div class="flex items-start justify-between border-b border-slate-100 dark:border-darkBorder pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="heart" class="w-5 h-5 text-rose-500"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Video Inspirasi Gratitude Journal</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Gratitude Study Tutorial</p>
                    </div>
                </div>
                
                @if($gratitudeUserChallenge && $gratitudeUserChallenge->status == 'completed')
                    <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-950/20 dark:text-emerald-300 font-black text-xs px-3.5 py-1.5 rounded-xl border border-emerald-100 dark:border-emerald-900/50">
                        Poin Diklaim (+{{ $gratitudeChallenge->points_reward }} Pts)
                    </span>
                @else
                    <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/20 dark:text-orange-300 font-black text-xs px-3.5 py-1.5 rounded-xl border border-orange-100 dark:border-orange-900/50">
                        Hadiah: +{{ $gratitudeChallenge->points_reward }} Poin
                    </span>
                @endif
            </div>

            @if(!Auth::user()->isPremium())
                <!-- Locked view -->
                <div class="bg-slate-50 dark:bg-slate-800/40 p-8 rounded-2xl text-center space-y-4 border-2 border-dashed border-slate-200 dark:border-darkBorder flex flex-col items-center justify-center">
                    <div class="w-14 h-14 bg-orange-50 dark:bg-orange-950/20 text-orange-500 rounded-full flex items-center justify-center">
                        <i data-lucide="lock" class="w-7 h-7"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white">Materi Video Wajib Premium</h4>
                        <p class="text-xs text-slate-400 font-semibold max-w-[250px] leading-relaxed mx-auto">Video pembelajaran dan metode beryukur eksklusif ini hanya bisa diakses oleh akun Premium.</p>
                    </div>
                    <a href="{{ route('premium.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition-colors">Upgrade Sekarang</a>
                </div>
            @else
                <!-- Active tracked video player -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                    <div class="lg:col-span-2">
                        <div class="youtube-container shadow-md">
                            <div id="player-gratitude" class="yt-player" data-video-id="{{ $gratitudeChallenge->youtube_link }}" data-challenge-id="{{ $gratitudeChallenge->id }}" data-status="{{ $gratitudeUserChallenge ? $gratitudeUserChallenge->status : 'not_started' }}"></div>
                        </div>
                    </div>
                    <div class="space-y-3 bg-slate-50 dark:bg-slate-800/40 p-5 rounded-2xl border border-slate-100 dark:border-darkBorder/60">
                        <h4 class="font-bold text-xs text-slate-800 dark:text-white">Petunjuk Menonton:</h4>
                        <ol class="list-decimal pl-4 space-y-2 text-[10px] text-slate-400 font-semibold">
                            <li>Tekan tombol play untuk memutar materi inspirasi beryukur (Gratitude Journal).</li>
                            <li>Tonton minimal 50% dari total video untuk mengklaim poin bonus harian.</li>
                            <li>Sistem anti-cheat melacak durasi tontonan Anda dan mengklaim poin secara otomatis.</li>
                        </ol>
                        
                        <div class="space-y-1 pt-2">
                            <div class="flex justify-between text-[10px] font-bold text-slate-400">
                                <span>Progress Video</span>
                                <span id="progress-text-gratitude">{{ $gratitudeUserChallenge ? $gratitudeUserChallenge->progress : 0 }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                <div id="progress-bar-gratitude" class="bg-emerald-500 rounded-full h-2 transition-all" style="width: {{ $gratitudeUserChallenge ? $gratitudeUserChallenge->progress : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Journal history entry items -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Riwayat Menulis Jurnal</h3>
        
        <div class="space-y-4">
            @forelse($journals as $j)
                @php
                    $emojis = ['happy'=>'😊 Senang','energetic'=>'⚡ Semangat','neutral'=>'😐 Biasa','sad'=>'😢 Sedih','stressed'=>'🤯 Stres'];
                    $borderColors = ['happy'=>'border-emerald-200 dark:border-emerald-950','energetic'=>'border-amber-200 dark:border-amber-950','neutral'=>'border-blue-200 dark:border-blue-950','sad'=>'border-slate-200 dark:border-slate-850','stressed'=>'border-rose-200 dark:border-rose-950'];
                    $bgColors = ['happy'=>'bg-emerald-50/20 dark:bg-emerald-950/10','energetic'=>'bg-amber-50/20 dark:bg-amber-950/10','neutral'=>'bg-blue-50/20 dark:bg-blue-950/10','sad'=>'bg-slate-50/20 dark:bg-slate-900/10','stressed'=>'bg-rose-50/20 dark:bg-rose-950/10'];
                @endphp
                <div class="p-5 rounded-2xl border {{ $borderColors[$j->mood] }} {{ $bgColors[$j->mood] }} space-y-2">
                    <div class="flex items-center justify-between text-[10px] font-bold">
                        <span class="text-slate-400">{{ $j->created_at->translatedFormat('l, d F Y - H:i') }}</span>
                        <span class="px-2 py-0.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200/40 dark:border-slate-700/40 shadow-sm">{{ $emojis[$j->mood] }}</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-semibold leading-relaxed whitespace-pre-line">{{ $j->content }}</p>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 font-bold text-xs">Belum ada riwayat jurnal. Tulis jurnal pertamamu di atas!</div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Mood selection helper
    function selectMood(mood) {
        document.querySelectorAll('.mood-btn').forEach(btn => {
            btn.classList.remove('mood-selected');
        });
        const selectedBtn = document.getElementById(`mood-${mood}`);
        if (selectedBtn) {
            selectedBtn.classList.add('mood-selected');
        }
        document.getElementById('selected-mood-input').value = mood;
    }

    // Set initial default mood
    selectMood('happy');
</script>

<!-- Gratitude Video Watch IFrame Tracker -->
@if(Auth::user()->isPremium() && $gratitudeChallenge)
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let gratitudePlayer;
    let gratitudeTimer;
    const gChallengeId = {{ $gratitudeChallenge->id }};
    const gStatus = "{{ $gratitudeUserChallenge ? $gratitudeUserChallenge->status : 'not_started' }}";

    function onYouTubeIframeAPIReady() {
        const container = document.getElementById('player-gratitude');
        if (!container) return;

        const videoUrl = container.getAttribute('data-video-id');
        const videoId = extractVideoId(videoUrl);
        if (!videoId) return;

        gratitudePlayer = new YT.Player('player-gratitude', {
            videoId: videoId,
            playerVars: {
                'playsinline': 1,
                'controls': 1,
                'modestbranding': 1,
                'rel': 0
            },
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function extractVideoId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length == 11) ? match[2] : null;
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING && gStatus !== 'completed') {
            if (!gratitudeTimer) {
                gratitudeTimer = setInterval(checkGratitudeProgress, 3000);
            }
        } else {
            if (gratitudeTimer) {
                clearInterval(gratitudeTimer);
                gratitudeTimer = null;
            }
        }
    }

    function checkGratitudeProgress() {
        if (!gratitudePlayer) return;

        const currentTime = gratitudePlayer.getCurrentTime();
        const duration = gratitudePlayer.getDuration();
        if (duration <= 0) return;

        const progressPercent = Math.round((currentTime / duration) * 100);

        // Update progress bar
        const progressBar = document.getElementById('progress-bar-gratitude');
        const progressText = document.getElementById('progress-text-gratitude');
        if (progressBar) progressBar.style.width = `${progressPercent}%`;
        if (progressText) progressText.textContent = `${progressPercent}%`;

        // Send updates
        fetch('{{ route("challenges.track-video") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                challenge_id: gChallengeId,
                progress: progressPercent,
                watched_seconds: Math.round(currentTime)
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.status === 'completed') {
                clearInterval(gratitudeTimer);
                gratitudeTimer = null;
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(err => console.error("Gratitude video tracking error:", err));
    }
</script>
@endif
@endsection
