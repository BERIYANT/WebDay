@extends('layouts.app')

@section('title', 'Progress Partner')
@section('header_title', 'Progress Partner')

@section('content')
<div class="space-y-6">

    <!-- Top Summary Banner -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-[32px] p-6 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_0.8px,transparent_0.8px)] [background-size:20px_20px] opacity-5"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-1.5 bg-primary-500/20 text-primary-400 border border-primary-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i data-lucide="users-2" class="w-4 h-4"></i>
                    <span>Accountability Partners</span>
                </div>
                <h2 class="text-xl md:text-2xl font-black tracking-tight leading-none">Saling Pantau & Bertumbuh Bersama</h2>
                <p class="text-xs text-slate-300 font-semibold max-w-xl">
                    Melangkah lebih cepat sendirian, tapi melangkah lebih jauh bersama partner. Follow rekan belajarmu, pantau progress harian mereka, dan diskusikan target di ruang obrolan.
                </p>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-2xl backdrop-blur-md">
                <div class="text-center border-r border-white/10 pr-4">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Partner</span>
                    <span class="text-lg font-black text-white">{{ $mutualPartners->count() }}</span>
                </div>
                <div class="text-center pl-1 pr-1 border-r border-white/10 pr-4">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Following</span>
                    <span class="text-lg font-black text-white">{{ $following->count() }}</span>
                </div>
                <div class="text-center pl-1">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Followers</span>
                    <span class="text-lg font-black text-white">{{ $followers->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace Grid layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Side: Social Lists & Navigation -->
        <div class="space-y-6">
            
            <!-- Mutual Partners list -->
            <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-darkBorder pb-3">
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                        <i data-lucide="handshake" class="w-4.5 h-4.5 text-primary-500"></i>
                        <span>Partner Saya (Saling Follow)</span>
                    </h3>
                    <span class="bg-primary-100 text-primary-700 dark:bg-primary-950/40 dark:text-primary-300 font-black text-[9px] px-2 py-0.5 rounded-full">{{ $mutualPartners->count() }}</span>
                </div>
                
                <div class="space-y-3 max-h-[280px] overflow-y-auto pr-1">
                    @forelse($mutualPartners as $p)
                        @php $isActive = $partner && $partner->id == $p->id; @endphp
                        <a href="?active_partner_id={{ $p->id }}" class="block p-3 rounded-2xl border transition-all flex items-center justify-between gap-3
                            {{ $isActive 
                                ? 'bg-primary-50/20 dark:bg-primary-950/10 border-primary-500/50 dark:border-primary-500/40 shadow-sm' 
                                : 'bg-slate-50/40 dark:bg-slate-800/10 border-slate-100 dark:border-darkBorder/40 hover:border-slate-200 dark:hover:border-slate-700' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="relative flex-shrink-0">
                                    @if($p->profile_image && file_exists(public_path('uploads/profiles/' . $p->profile_image)))
                                        <img src="{{ asset('uploads/profiles/' . $p->profile_image) }}" class="w-9 h-9 rounded-full object-cover" alt="Avatar">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase">
                                            {{ substr($p->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-darkCard rounded-full"></div>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white capitalize truncate leading-none mb-1">{{ $p->name }}</h4>
                                    <div class="flex items-center gap-1.5">
                                        <span class="bg-blue-50 text-blue-600 dark:bg-blue-950/20 dark:text-blue-400 font-bold text-[8px] px-1 py-0.2 rounded">{{ $p->getLeaderboardBadge() }}</span>
                                        <span class="text-[8px] text-slate-400 font-bold">{{ $p->streak }} Streak</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="block text-[8px] text-slate-400 font-bold uppercase mb-0.5">Progress Hari Ini</span>
                                <span class="text-xs font-black text-primary-600 dark:text-primary-400">{{ $p->getTodayProgressPercentage() }}%</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8 bg-slate-50 dark:bg-slate-800/10 rounded-2xl border border-dashed border-slate-200/50 dark:border-darkBorder/40">
                            <i data-lucide="users-2" class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2"></i>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold max-w-[160px] mx-auto leading-relaxed">Belum ada partner mutual. Follow balik pengikut Anda atau cari partner di bawah!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Followers & Following lists -->
            <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
                
                <!-- Tab headers -->
                <div class="flex border-b border-slate-100 dark:border-darkBorder pb-2 text-center text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <button onclick="switchTab('followers-tab', 'following-tab')" id="btn-followers-tab" class="flex-1 pb-2 border-b-2 border-primary-500 text-slate-800 dark:text-white">Pengikut ({{ $followers->count() }})</button>
                    <button onclick="switchTab('following-tab', 'followers-tab')" id="btn-following-tab" class="flex-1 pb-2 border-b-2 border-transparent">Mengikuti ({{ $following->count() }})</button>
                </div>

                <!-- Followers Content list -->
                <div id="followers-tab" class="space-y-3 max-h-[200px] overflow-y-auto pr-1">
                    @forelse($followers as $f)
                        <div class="p-3 bg-slate-50/40 dark:bg-slate-800/10 border border-slate-100 dark:border-darkBorder/40 rounded-2xl flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                @if($f->profile_image && file_exists(public_path('uploads/profiles/' . $f->profile_image)))
                                    <img src="{{ asset('uploads/profiles/' . $f->profile_image) }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="Avatar">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center text-[10px] uppercase flex-shrink-0">
                                        {{ substr($f->name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white capitalize truncate leading-none mb-0.5">{{ $f->name }}</h4>
                                    <span class="text-[9px] text-slate-400 font-bold block">{{ $f->points }} Pts • {{ $f->streak }} Streak</span>
                                </div>
                            </div>
                            <form action="{{ route('partner.toggle-follow', $f->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-[9px] px-3 py-1.5 rounded-lg shadow-sm transition-all flex items-center gap-1">
                                    <i data-lucide="user-plus" class="w-3 h-3"></i>
                                    <span>Follow Balik</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-[10px] text-slate-400 py-6 font-semibold">Belum ada pengikut baru.</p>
                    @endforelse
                </div>

                <!-- Following Content list -->
                <div id="following-tab" class="space-y-3 max-h-[200px] overflow-y-auto pr-1 hidden">
                    @forelse($following as $f)
                        <div class="p-3 bg-slate-50/40 dark:bg-slate-800/10 border border-slate-100 dark:border-darkBorder/40 rounded-2xl flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                @if($f->profile_image && file_exists(public_path('uploads/profiles/' . $f->profile_image)))
                                    <img src="{{ asset('uploads/profiles/' . $f->profile_image) }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="Avatar">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold flex items-center justify-center text-[10px] uppercase flex-shrink-0">
                                        {{ substr($f->name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-white capitalize truncate leading-none mb-0.5">{{ $f->name }}</h4>
                                    <span class="text-[9px] text-slate-400 font-bold block">{{ $f->points }} Pts • {{ $f->streak }} Streak</span>
                                </div>
                            </div>
                            <form action="{{ route('partner.toggle-follow', $f->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50 hover:bg-rose-100 font-bold text-[9px] px-3 py-1.5 rounded-lg shadow-sm transition-all flex items-center gap-1">
                                    <i data-lucide="user-minus" class="w-3 h-3"></i>
                                    <span>Batal Follow</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-[10px] text-slate-400 py-6 font-semibold">Anda belum mengikuti siapapun.</p>
                    @endforelse
                </div>

            </div>

        </div>

        <!-- Right Side: Performance Compare & Live Chat Board -->
        <div class="lg:col-span-2 space-y-6">
            
            @if($partner)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Performance Comparison column -->
                    <div class="space-y-6">
                        
                        <!-- Shared Milestone Progress Card -->
                        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-5">
                            <div class="flex items-center justify-between border-b border-slate-100 dark:border-darkBorder pb-3">
                                <h3 class="font-extrabold text-slate-800 dark:text-white text-xs">Milestone Bersama</h3>
                                <span class="bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-300 text-[8px] px-2 py-0.5 rounded font-black uppercase">Goal: 1500 Poin</span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between text-[10px] font-bold text-slate-400">
                                    <span>Akumulasi Poin Bersama</span>
                                    <span>{{ $comparison['user_points'] + $comparison['partner_points'] }} / 1500 Pts ({{ $comparison['joint_progress'] }}%)</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-primary-500 to-orange-500 rounded-full h-2 transition-all duration-500" style="width: {{ $comparison['joint_progress'] }}%"></div>
                                </div>
                                <p class="text-[9px] text-slate-400 font-semibold leading-relaxed">
                                    *Dapatkan total gabungan 1500 poin bersama partner Anda untuk membuka lencana khusus kemitraan!
                                </p>
                            </div>
                        </div>

                        <!-- Head-to-Head Performance Card -->
                        <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-6">
                            <h3 class="font-extrabold text-slate-800 dark:text-white text-xs">Komparasi Performa</h3>
                            
                            <div class="grid grid-cols-2 gap-4 relative">
                                <div class="absolute inset-y-0 left-1/2 w-0.5 bg-slate-100 dark:bg-darkBorder"></div>

                                <!-- User stats column -->
                                <div class="space-y-3 text-center">
                                    <div class="mx-auto w-10 h-10">
                                        @if(Auth::user()->profile_image && file_exists(public_path('uploads/profiles/' . Auth::user()->profile_image)))
                                            <img src="{{ asset('uploads/profiles/' . Auth::user()->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 dark:border-slate-800 shadow" alt="Avatar">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase border border-slate-100 shadow">
                                                {{ substr(Auth::user()->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-extrabold text-xs text-slate-800 dark:text-white capitalize">Anda</h4>
                                    
                                    <div class="space-y-1.5">
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Points</span>
                                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $comparison['user_points'] }}</span>
                                        </div>
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Streaks</span>
                                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $comparison['user_streak'] }} Hari</span>
                                        </div>
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Progress Hari Ini</span>
                                            <span class="text-xs font-black text-primary-600 dark:text-primary-400">{{ Auth::user()->getTodayProgressPercentage() }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Partner stats column -->
                                <div class="space-y-3 text-center">
                                    <div class="relative mx-auto w-10 h-10">
                                        @if($partner->profile_image && file_exists(public_path('uploads/profiles/' . $partner->profile_image)))
                                            <img src="{{ asset('uploads/profiles/' . $partner->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 dark:border-slate-800 shadow" alt="Partner">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs uppercase border border-slate-100 shadow">
                                                {{ substr($partner->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-darkCard rounded-full"></div>
                                    </div>
                                    <h4 class="font-extrabold text-xs text-slate-800 dark:text-white capitalize">{{ $partner->name }}</h4>
                                    
                                    <div class="space-y-1.5">
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Points</span>
                                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $comparison['partner_points'] }}</span>
                                        </div>
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Streaks</span>
                                            <span class="text-xs font-black text-slate-800 dark:text-white">{{ $comparison['partner_streak'] }} Hari</span>
                                        </div>
                                        <div class="bg-slate-50 dark:bg-slate-800/40 p-2 rounded-xl">
                                            <span class="block text-[8px] text-slate-400 font-bold uppercase">Progress Hari Ini</span>
                                            <span class="text-xs font-black text-primary-600 dark:text-primary-400">{{ $partner->getTodayProgressPercentage() }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cheer Up Quick Actions -->
                        <div class="bg-white dark:bg-darkCard p-5 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-3">
                            <h3 class="font-extrabold text-slate-800 dark:text-white text-xs">Kirim Semangat Instan</h3>
                            <div class="grid grid-cols-2 gap-2 text-[9px] font-bold">
                                <button onclick="sendCheer('🔥 Selesaikan workoutmu hari ini! Semangatt!')" class="py-2.5 px-3 bg-orange-50 dark:bg-orange-950/20 text-orange-600 dark:text-orange-400 rounded-xl hover:scale-[1.02] active:scale-95 transition-all text-center">
                                    🔥 Bakar Workout!
                                </button>
                                <button onclick="sendCheer('👏 Salut banget sama konsistensi streak kamu! Keren!')" class="py-2.5 px-3 bg-blue-50 dark:bg-blue-950/20 text-primary-600 dark:text-primary-400 rounded-xl hover:scale-[1.02] active:scale-95 transition-all text-center">
                                    👏 Salut Streak!
                                </button>
                                <button onclick="sendCheer('💪 Jangan lupa menulis jurnal beryukur hari ini ya!')" class="py-2.5 px-3 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 rounded-xl hover:scale-[1.02] active:scale-95 transition-all text-center">
                                    💪 Ingatkan Jurnal
                                </button>
                                <button onclick="sendCheer('🏆 Sedikit lagi kita unlock target bersama nih! Go!')" class="py-2.5 px-3 bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 rounded-xl hover:scale-[1.02] active:scale-95 transition-all text-center">
                                    🏆 Target Bersama
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Chat Board Section Column -->
                    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm flex flex-col h-[530px]">
                        <div class="border-b border-slate-100 dark:border-darkBorder pb-4 mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="font-extrabold text-slate-800 dark:text-white text-sm capitalize">Chat dengan {{ $partner->name }}</h3>
                                <p class="text-[9px] text-slate-400 font-bold uppercase">Accountability Room</p>
                            </div>
                            <div class="flex items-center gap-1 bg-emerald-50 dark:bg-emerald-950/30 px-2.5 py-0.5 rounded-full flex-shrink-0">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                <span class="text-[8px] font-bold text-emerald-600 dark:text-emerald-400 uppercase">Online</span>
                            </div>
                        </div>

                        <!-- Messages box -->
                        <div id="full-chat-messages" class="flex-grow overflow-y-auto space-y-3 p-3 bg-slate-50/50 dark:bg-slate-800/10 rounded-2xl min-h-0 text-[11px]">
                            <!-- Polled via Javascript -->
                        </div>

                        <!-- Chat inputs -->
                        <div class="pt-3 border-t border-slate-100 dark:border-darkBorder mt-4">
                            <form id="full-chat-form" class="flex items-center gap-2">
                                @csrf
                                <input type="text" id="full-chat-input" required placeholder="Tulis pesan penyemangat..." class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-3 px-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors">
                                <button type="submit" class="p-3 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl shadow-md transition-colors">
                                    <i data-lucide="send" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @else
                <!-- Premium Blank Slate (No Partner Selected) -->
                <div class="bg-white dark:bg-darkCard p-12 rounded-[36px] border border-slate-200/60 dark:border-darkBorder shadow-sm text-center flex flex-col items-center justify-center min-h-[530px] space-y-4">
                    <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center border border-slate-100 dark:border-darkBorder/60 text-slate-400">
                        <i data-lucide="user-x" class="w-8 h-8"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base font-black text-slate-800 dark:text-white">Tidak Ada Partner Aktif Terpilih</h3>
                        <p class="text-xs text-slate-400 font-semibold max-w-[280px] leading-relaxed mx-auto">
                            Saling follow dengan pengguna lain di sebelah kiri atau cari partner baru di bawah untuk membuka ruang komparasi target & chat interaktif!
                        </p>
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- Available Roster List (To search or follow new partners) -->
    <div class="bg-white dark:bg-darkCard p-6 rounded-3xl border border-slate-200/60 dark:border-darkBorder shadow-sm space-y-4">
        <div class="border-b border-slate-100 dark:border-darkBorder pb-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-0.5">
                <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Rekomendasi Partner Baru</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed">
                    Cari rekan belajar baru untuk memicu jiwa kompetitif positif Anda! Ikuti mereka untuk pantau progres.
                </p>
            </div>
            <!-- Beautiful Search Input Box -->
            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="absolute left-4 top-3 w-4 h-4 text-slate-400"></i>
                <input type="text" id="partner-search-input" placeholder="Cari nama atau email..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-darkBorder focus:border-primary-500 rounded-2xl py-2.5 pl-11 pr-4 text-xs font-semibold outline-none text-slate-800 dark:text-white transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 transition-opacity duration-200" id="suggestions-grid">
            @include('partner.partials.suggestions')
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Followers vs Following Tab Switcher
    function switchTab(showId, hideId) {
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        document.getElementById('btn-' + showId).className = "flex-1 pb-2 border-b-2 border-primary-500 text-slate-800 dark:text-white";
        document.getElementById('btn-' + hideId).className = "flex-1 pb-2 border-b-2 border-transparent";
    }

    // Modern real-time AJAX partner searching
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('partner-search-input');
        const gridContainer = document.getElementById('suggestions-grid');

        if (searchInput && gridContainer) {
            let debounceTimer;
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = searchInput.value.trim();
                
                debounceTimer = setTimeout(() => {
                    gridContainer.style.opacity = '0.5';

                    fetch(`{{ route('partner.index') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        gridContainer.innerHTML = data.html;
                        gridContainer.style.opacity = '1';
                        if (window.lucide) {
                            lucide.createIcons();
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        gridContainer.style.opacity = '1';
                    });
                }, 300);
            });
        }
    });
</script>

@if($partner)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('full-chat-messages');
        const chatForm = document.getElementById('full-chat-form');
        const chatInput = document.getElementById('full-chat-input');
        const currentUserId = {{ Auth::user()->id }};
        const partnerId = {{ $partner->id }};

        // Scroll chat initially
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Fetch messages polling function
        function loadMessages() {
            if (!chatMessages) return;
            fetch('{{ route("partner.messages") }}?partner_id=' + partnerId)
            .then(res => res.json())
            .then(data => {
                if (data.messages) {
                    chatMessages.innerHTML = '';
                    data.messages.forEach(msg => {
                        appendMessage(msg.sender_id, msg.message, false);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });
        }

        // Initial load
        loadMessages();
        // Set Interval
        setInterval(loadMessages, 4000);

        // Chat Form submit
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = chatInput.value.trim();
                if (!msgText) return;

                appendMessage(currentUserId, msgText);
                chatInput.value = '';

                submitMessage(msgText);
            });
        }

        // Cheer up button handler
        window.sendCheer = function(text) {
            appendMessage(currentUserId, text);
            submitMessage(text);
        };

        function submitMessage(text) {
            fetch('{{ route("partner.send-message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    message: text,
                    receiver_id: partnerId 
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadMessages();
                }
            })
            .catch(err => console.error("Send message error:", err));
        }

        function appendMessage(senderId, text, scroll = true) {
            if (!chatMessages) return;
            const container = document.createElement('div');
            container.className = `flex flex-col ${senderId === currentUserId ? 'items-end' : 'items-start'}`;

            const bubble = document.createElement('div');
            bubble.className = `max-w-[80%] rounded-2xl px-4 py-3 font-semibold leading-relaxed shadow-sm ${
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
    });
</script>
@endif
@endsection
