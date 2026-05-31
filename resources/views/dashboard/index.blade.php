@extends('layouts.app')

@section('title', 'Beranda Dashboard')
@section('header_title', 'Beranda')

@section('content')
<div class="space-y-6">

    <!-- Greeting & Banner Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-500 to-orange-500 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] opacity-10"></div>
        <div class="relative z-10 space-y-4">
            <div class="flex items-center gap-3">
                <span class="text-3xl wave-emoji">👋</span>
                <h2 class="text-2xl md:text-3xl font-black tracking-tight capitalize">Halo, Selamat Datang, {{ Auth::user()->name }}!</h2>
            </div>
            <p class="text-white/80 font-medium text-sm md:text-base max-w-xl">
                Siap bertumbuh lebih baik hari ini? Selesaikan tantangan harianmu, raih poin reward, dan klaim akses premium gratis!
            </p>
            
            <!-- Progress Bar of Today's Challenge -->
            <div class="pt-2 max-w-md space-y-2">
                <div class="flex justify-between text-xs font-bold text-white/90">
                    <span>Progress Challenge Hari Ini</span>
                    <span>{{ $todayProgressPercentage }}% Selesai</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-3">
                    <div class="bg-white rounded-full h-3 transition-all duration-500" style="width: {{ $todayProgressPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats grid cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- 1. Total Poin -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform duration-300">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i data-lucide="gem" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Total Poin</p>
                <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $totalPoints }}</h4>
            </div>
        </div>

        <!-- 2. Challenge Selesai -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform duration-300">
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Tantangan</p>
                <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $completedChallengesCount }}</h4>
            </div>
        </div>

        <!-- 3. Partner Aktif -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform duration-300">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i data-lucide="users-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Partner Aktif</p>
                <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $activePartnersCount }}</h4>
            </div>
        </div>

        <!-- 4. Streak Harian -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex items-center gap-4 hover:scale-[1.02] transition-transform duration-300">
            <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0 animate-pulse">
                <i data-lucide="flame" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Daily Streak</p>
                <h4 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $streak }} Hari</h4>
            </div>
        </div>
    </div>

    <!-- AI Motivator & Reminders -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- AI Advice Box -->
        <div class="lg:col-span-2 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary-500/5 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Rekomendasi AI Personal</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Dynamic AI Motivation</p>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-darkBorder/50">
                <p class="text-sm text-slate-600 dark:text-slate-300 font-semibold leading-relaxed">
                    "{{ $aiMotivation }}"
                </p>
            </div>
        </div>

        <!-- AI Reminders list -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="bell-ring" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Notifikasi AI</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">AI Reminder</p>
                    </div>
                </div>
                
                <button id="enable-device-notifications" class="hidden text-[10px] bg-primary-50 dark:bg-primary-950/30 text-primary-600 dark:text-primary-400 font-black px-2.5 py-1.5 rounded-xl border border-primary-100 dark:border-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-all flex items-center gap-1">
                    <i data-lucide="bell" class="w-3.5 h-3.5"></i>
                    <span>Notifikasi Device</span>
                </button>
            </div>
            <div class="space-y-2.5">
                @forelse($aiReminders as $reminder)
                    <div class="flex items-start gap-2.5 p-2.5 bg-slate-50 dark:bg-slate-800/40 rounded-xl border border-slate-100 dark:border-darkBorder/40">
                        <i data-lucide="info" class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0"></i>
                        <span class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-normal">{{ $reminder }}</span>
                    </div>
                @empty
                    <div class="text-center text-xs text-slate-400 font-bold py-6">Semua aman untuk hari ini!</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Tasks and Partner Chat Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Today's active tasks list -->
        <div class="lg:col-span-2 bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-square" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Tantangan Hari Ini</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Challenge Schedule</p>
                    </div>
                </div>
                <a href="{{ route('challenges.index') }}" class="text-xs font-bold text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua</a>
            </div>

            <div class="space-y-4">
                @foreach($todayUserChallenges as $item)
                    @php 
                        $ch = $item['challenge'];
                        $status = $item['status'];
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-darkBorder p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 text-[10px] px-2 py-0.5 rounded font-black uppercase">
                                    {{ $ch->category }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400">
                                    {{ $ch->time_estimate }} Menit • {{ $ch->difficulty }}
                                </span>
                            </div>
                            <h4 class="font-extrabold text-slate-800 dark:text-white text-sm capitalize">{{ $ch->name }}</h4>
                            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed max-w-lg">{{ $ch->description }}</p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @if($status == 'not_started')
                                <form action="{{ route('challenges.start', $ch->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all">
                                        Mulai
                                    </button>
                                </form>
                            @elseif($status == 'started')
                                @if($ch->youtube_link)
                                    <!-- Video required: must go to challenge index details to play -->
                                    <a href="{{ route('challenges.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all flex items-center gap-1.5">
                                        <i data-lucide="play-circle" class="w-3.5 h-3.5"></i>
                                        <span>Tonton Video</span>
                                    </a>
                                @else
                                    <form action="{{ route('challenges.complete', $ch->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="bypass_video" value="1">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all">
                                            Selesaikan
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 font-black text-xs px-3.5 py-2 rounded-xl flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                    <span>Selesai (+{{ $ch->points_reward }} Pts)</span>
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Accountability Progress Partner mini chat widget -->
        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex flex-col h-[400px]">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-darkBorder pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/30 text-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="users-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 dark:text-white text-sm">Progress Partner</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Accountability Partner</p>
                    </div>
                </div>
                
                @if($partner)
                    <div class="flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-950/50 px-2 py-0.5 rounded-full">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 capitalize">Online</span>
                    </div>
                @endif
            </div>

            @if($partner)
                <!-- Chat Screen & Dynamic messages panel -->
                <div class="flex-1 flex flex-col min-h-0 space-y-4">
                    
                    <!-- Partner details box -->
                    <div class="bg-slate-50 dark:bg-slate-800/40 p-3 rounded-2xl border border-slate-100 dark:border-darkBorder/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @if($partner->profile_image && file_exists(public_path('uploads/profiles/' . $partner->profile_image)))
                                <img src="{{ asset('uploads/profiles/' . $partner->profile_image) }}" class="w-8 h-8 rounded-full object-cover" alt="Partner">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase">
                                    {{ substr($partner->name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 capitalize leading-none">{{ $partner->name }}</h4>
                                <span class="text-[9px] text-slate-400 font-bold">{{ $partner->points }} Poin • {{ $partner->streak }} Streak</span>
                            </div>
                        </div>
                        <a href="{{ route('partner.index') }}" class="text-[10px] font-black text-primary-600 dark:text-primary-400 hover:underline">Pantau Partner</a>
                    </div>

                    <!-- Conversation body (AJAX loaded / scrolled) -->
                    <div id="chat-messages" class="flex-1 overflow-y-auto space-y-2 p-2 bg-slate-50/50 dark:bg-slate-800/10 rounded-2xl min-h-0 text-[11px]">
                        @foreach($partnerMessages as $msg)
                            <div class="flex flex-col {{ $msg->sender_id == Auth::user()->id ? 'items-end' : 'items-start' }}">
                                <div class="max-w-[80%] rounded-2xl px-3.5 py-2.5 font-semibold leading-relaxed shadow-sm
                                    {{ $msg->sender_id == Auth::user()->id 
                                        ? 'bg-primary-600 text-white rounded-tr-none' 
                                        : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-100 dark:border-darkBorder rounded-tl-none' }}">
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Chat Sender Input Form -->
                    <div class="pt-2 border-t border-slate-100 dark:border-darkBorder">
                        <form id="chat-form" class="flex items-center gap-2">
                            @csrf
                            <input type="text" id="chat-input" required placeholder="Kirim pesan motivasi..." class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-2.5 px-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors">
                            <button type="submit" class="p-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl shadow-md shadow-primary-500/10 transition-colors">
                                <i data-lucide="send" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @else
                <div class="flex-grow flex flex-col items-center justify-center text-center p-6 space-y-4">
                    <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800/40 rounded-full flex items-center justify-center">
                        <i data-lucide="user-x" class="w-7 h-7 text-slate-400"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white">Belum Ada Partner</h4>
                        <p class="text-xs text-slate-400 font-semibold max-w-[200px] leading-relaxed">Cari partner belajarmu sekarang untuk melipatgandakan produktivitas!</p>
                    </div>
                    <a href="{{ route('partner.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-md transition-all">
                        Cari Partner
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const currentUserId = {{ Auth::user()->id }};
        const partnerId = {{ $partner ? $partner->id : 'null' }};

        // Scroll chat to the absolute bottom initially
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // AJAX Chat message submission
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = chatInput.value.trim();
                if (!msgText || !partnerId) return;

                // Optimistically append user message to feed
                appendMessage(currentUserId, msgText);
                chatInput.value = '';

                fetch('{{ route("partner.send-message") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        message: msgText,
                        receiver_id: partnerId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Polling triggers updates instantly, but scroll just in case
                        if (chatMessages) {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    }
                })
                .catch(err => console.error("Chat error:", err));
            });
        }

        // AJAX Chat message polling every 4 seconds to make the UI extremely responsive and realistic
        if (chatMessages) {
            setInterval(function() {
                if (!partnerId) return;
                fetch('{{ route("partner.messages") }}?partner_id=' + partnerId)
                .then(res => res.json())
                .then(data => {
                    if (data.messages) {
                        // Clear chat element and rebuild
                        chatMessages.innerHTML = '';
                        data.messages.forEach(msg => {
                            appendMessage(msg.sender_id, msg.message, false);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                });
            }, 4000);
        }

        function appendMessage(senderId, text, scroll = true) {
            if (!chatMessages) return;
            const container = document.createElement('div');
            container.className = `flex flex-col ${senderId === currentUserId ? 'items-end' : 'items-start'}`;

            const bubble = document.createElement('div');
            bubble.className = `max-w-[80%] rounded-2xl px-3.5 py-2.5 font-semibold leading-relaxed shadow-sm ${
                senderId === currentUserId 
                    ? 'bg-primary-600 text-white rounded-tr-none' 
                    : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-100 dark:border-darkBorder rounded-tl-none'
            }`;
            bubble.textContent = text;

            container.appendChild(bubble);
            chatMessages.appendChild(container);

            if (scroll) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
        // Web Notifications API Integration for AI Reminders (Request Permission Only)
        const notificationBtn = document.getElementById('enable-device-notifications');

        function checkNotificationPermission() {
            if (!("Notification" in window)) return;
            if (Notification.permission === "default") {
                if (notificationBtn) notificationBtn.classList.remove('hidden');
            }
        }

        if (notificationBtn) {
            notificationBtn.addEventListener('click', function() {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        notificationBtn.classList.add('hidden');
                        // Global background script in app.blade.php will auto-start active polling
                    }
                });
            });
        }

        checkNotificationPermission();
    });
</script>
@endsection
