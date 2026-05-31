@extends('layouts.app')

@section('title', 'Leaderboard Global')
@section('header_title', 'Leaderboard')

@section('content')
<div class="space-y-6">

    <!-- Top 3 podium display -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
        @php
            $podiumStyles = [
                1 => ['bg' => 'from-yellow-100 to-amber-100', 'border' => 'border-amber-300', 'text' => 'text-amber-700', 'crown' => 'text-yellow-500', 'scale' => 'md:scale-105 md:-translate-y-2'],
                2 => ['bg' => 'from-slate-100 to-slate-200',  'border' => 'border-slate-300',  'text' => 'text-slate-700',  'crown' => 'text-slate-400',  'scale' => ''],
                3 => ['bg' => 'from-orange-100 to-orange-200','border' => 'border-orange-300', 'text' => 'text-orange-700', 'crown' => 'text-orange-400', 'scale' => '']
            ];
        @endphp

        @foreach($allRankings->take(3) as $index => $rankUser)
            @php 
                $rank = $index + 1;
                $style = $podiumStyles[$rank];
                $level = floor($rankUser->points / 100) + 1;
            @endphp
            <div class="bg-gradient-to-b {{ $style['bg'] }} p-6 rounded-[32px] border-2 {{ $style['border'] }} shadow-md text-center space-y-4 {{ $style['scale'] }} relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -top-6 -left-6 w-20 h-20 bg-white/20 rounded-full blur-lg"></div>
                
                <div class="space-y-2">
                    <div class="flex justify-center">
                        <div class="relative">
                            <!-- Crown indicator -->
                            <i data-lucide="crown" class="w-8 h-8 {{ $style['crown'] }} absolute -top-6 left-1/2 transform -translate-x-1/2 animate-bounce"></i>
                            
                            @if($rankUser->profile_image && file_exists(public_path('uploads/profiles/' . $rankUser->profile_image)))
                                <img src="{{ asset('uploads/profiles/' . $rankUser->profile_image) }}" class="w-16 h-16 rounded-full object-cover border-2 border-white" alt="Avatar">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xl uppercase border-2 border-white shadow">
                                    {{ substr($rankUser->name, 0, 2) }}
                                </div>
                            @endif
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-slate-900 text-white text-xs font-black flex items-center justify-center border-2 border-white">
                                {{ $rank }}
                            </span>
                        </div>
                    </div>
                    
                    <h3 class="font-extrabold text-slate-800 capitalize text-base">{{ $rankUser->name }}</h3>
                    <div class="flex justify-center gap-1.5">
                        <span class="bg-white/80 text-slate-700 text-[10px] px-2 py-0.5 rounded font-black uppercase">
                            {{ $rankUser->getLeaderboardBadge() }}
                        </span>
                        <span class="bg-slate-900 text-white text-[10px] px-2 py-0.5 rounded font-black uppercase">
                            LV {{ $level }}
                        </span>
                    </div>
                </div>

                <div class="bg-white/60 p-3 rounded-2xl border border-white/50">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Skor Poin</span>
                    <span class="text-lg font-black text-slate-800">{{ $rankUser->points }} Pts</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Ranking table grid -->
    <div class="bg-white dark:bg-darkCard rounded-[36px] border border-slate-200/60 dark:border-darkBorder shadow-sm overflow-hidden relative">
        <div class="p-6 border-b border-slate-100 dark:border-darkBorder flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/30 text-primary-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-base">Papan Peringkat Warrior</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Global Leaderboard</p>
                </div>
            </div>

            <!-- Current User Rank info -->
            <div class="bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 px-4 py-2 rounded-2xl flex items-center gap-4">
                <span class="text-xs font-bold text-primary-600 dark:text-primary-400">Peringkat Anda:</span>
                <span class="text-sm font-black text-primary-700 dark:text-primary-300">#{{ $myRank }} dari {{ count($allRankings) }}</span>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-semibold">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/20 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100 dark:border-darkBorder">
                        <th class="py-4 px-6 text-center w-20">Rank</th>
                        <th class="py-4 px-6">Pengguna</th>
                        <th class="py-4 px-6 text-center w-32">Badge</th>
                        <th class="py-4 px-6 text-center w-24">Level</th>
                        <th class="py-4 px-6 text-right w-32">Total Poin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-darkBorder/40">
                    @foreach($rankings as $index => $rankUser)
                        @php
                            $rank = $index + 1;
                            $level = floor($rankUser->points / 100) + 1;
                            $isMe = $rankUser->id == Auth::user()->id;
                        @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors {{ $isMe ? 'bg-blue-50/30 dark:bg-primary-950/10' : '' }}">
                            <td class="py-4 px-6 text-center">
                                @if($rank <= 3)
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-black text-xs
                                        {{ $rank == 1 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $rank == 2 ? 'bg-slate-100 text-slate-700' : '' }}
                                        {{ $rank == 3 ? 'bg-orange-100 text-orange-700' : '' }}">
                                        {{ $rank }}
                                    </span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">#{{ $rank }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 flex items-center gap-3">
                                @if($rankUser->profile_image && file_exists(public_path('uploads/profiles/' . $rankUser->profile_image)))
                                    <img src="{{ asset('uploads/profiles/' . $rankUser->profile_image) }}" class="w-8 h-8 rounded-full object-cover" alt="Avatar">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-[10px] uppercase shadow-sm">
                                        {{ substr($rankUser->name, 0, 2) }}
                                    </div>
                                @endif
                                <span class="capitalize text-slate-800 dark:text-slate-200 {{ $isMe ? 'font-bold' : '' }}">{{ $rankUser->name }}</span>
                                @if($isMe)
                                    <span class="bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 text-[8px] px-1.5 py-0.2 rounded font-black uppercase">Anda</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[9px] px-2 py-0.5 rounded font-black uppercase tracking-wider">
                                    {{ $rankUser->getLeaderboardBadge() }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center text-slate-500 dark:text-slate-400">
                                Level {{ $level }}
                            </td>
                            <td class="py-4 px-6 text-right font-black text-slate-800 dark:text-white">
                                {{ $rankUser->points }} Pts
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Premium blurred lock screen block if non-premium -->
        @if(!$isPremium)
            <div class="absolute inset-x-0 bottom-0 top-[260px] bg-gradient-to-t from-white/95 via-white/80 to-transparent dark:from-darkBg/95 dark:via-darkBg/80 dark:to-transparent backdrop-blur-[2px] flex flex-col items-center justify-center p-6 text-center space-y-4">
                <div class="w-12 h-12 bg-orange-50 dark:bg-orange-950/20 text-orange-500 rounded-full flex items-center justify-center shadow-md">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-sm font-black text-slate-800 dark:text-white">Peringkat Global Terkunci</h4>
                    <p class="text-[11px] text-slate-400 font-semibold max-w-sm">Akun standard hanya dapat melihat Top 3 peringkat teratas. Buka sisa papan peringkat untuk membandingkan posisimu dengan seluruh Warrior di seluruh dunia!</p>
                </div>
                <a href="{{ route('premium.index') }}" class="bg-gradient-to-r from-primary-600 to-orange-500 text-white font-bold text-[10px] px-6 py-2.5 rounded-xl shadow-md hover:scale-[1.01] transition-transform">Buka Peringkat Global</a>
            </div>
        @endif

    </div>

</div>
@endsection
