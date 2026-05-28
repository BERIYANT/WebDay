<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Challenge;
use App\Models\UserChallenge;
use App\Models\Journal;
use App\Models\Partner;
use App\Models\PartnerMessage;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Calculate Stats
        $totalPoints = $user->points;
        
        $completedChallengesCount = UserChallenge::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $activePartnersCount = $user->mutualPartners()->count();

        $streak = $user->streak;

        // 2. Fetch today's challenges (e.g. 3 default challenges of the day)
        // Let's select a few challenges for today
        $todayChallenges = Challenge::where('is_premium', false)->limit(3)->get();
        
        // Track the user's completion of these 3 challenges
        $todayUserChallenges = [];
        $completedTodayCount = 0;
        
        foreach ($todayChallenges as $challenge) {
            $userCh = UserChallenge::where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->first();
                
            $todayUserChallenges[] = [
                'challenge' => $challenge,
                'status' => $userCh ? $userCh->status : 'not_started',
                'progress' => $userCh ? $userCh->progress : 0,
                'record' => $userCh
            ];
            
            if ($userCh && $userCh->status == 'completed') {
                $completedTodayCount++;
            }
        }

        $todayProgressPercentage = count($todayChallenges) > 0 
            ? round(($completedTodayCount / count($todayChallenges)) * 100) 
            : 0;

        // 3. AI Motivator Messages (Dynamic content based on user attributes)
        $aiMotivation = $this->generateAIMotivation($user, $completedChallengesCount);
        $aiReminders = $this->generateAIReminders($user);

        // 4. Partner Data
        $mutualPartners = $user->mutualPartners();
        $partner = $mutualPartners->first();

        $partnerMessages = [];
        if ($partner) {
            $partnerId = $partner->id;
            
            // Fetch recent messages
            $partnerMessages = PartnerMessage::where(function($q) use ($user, $partnerId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $partnerId);
            })->orWhere(function($q) use ($user, $partnerId) {
                $q->where('sender_id', $partnerId)->where('receiver_id', $user->id);
            })->orderBy('created_at', 'asc')->get();
        }

        return view('dashboard.index', compact(
            'totalPoints',
            'completedChallengesCount',
            'activePartnersCount',
            'streak',
            'todayUserChallenges',
            'todayProgressPercentage',
            'aiMotivation',
            'aiReminders',
            'partner',
            'partnerMessages'
        ));
    }

    public function getAIRemindersJson()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        $aiReminders = $this->generateAIReminders($user);
        return response()->json([
            'reminders' => $aiReminders
        ]);
    }

    private function generateAIMotivation($user, $completedCount)
    {
        $name = ucfirst($user->name);

        // --- Real data signals ---
        // 1. How many total challenges completed ever
        // 2. Streak
        // 3. Points
        // 4. Latest journal mood (from last 3 journals)
        $latestMoods = \App\Models\Journal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->pluck('mood');

        $negativeMoodCount = $latestMoods->filter(fn($m) => in_array($m, ['sad', 'anxious', 'tired', 'stressed']))->count();
        $positiveMoodCount = $latestMoods->filter(fn($m) => in_array($m, ['happy', 'excited', 'grateful', 'energetic']))->count();

        // Condition: streak is strong
        if ($user->streak >= 7) {
            return "Luar biasa {$name}! 🔥 Streak {$user->streak} hari beruntun — ini bukan keberuntungan, ini disiplin sejati. AI kami mendeteksi konsistensimu masuk kategori Top Challenger. Teruskan!";
        }

        if ($user->streak >= 3) {
            return "Solid, {$name}! Streak {$user->streak} hari kamu lagi on-fire 🔥. Jangan putus sekarang — tinggal sedikit lagi menuju Warrior tier di leaderboard!";
        }

        // Condition: mood mostly negative recently
        if ($negativeMoodCount >= 2) {
            return "Hai {$name}, AI kami melihat beberapa hari terakhir terasa berat dari catatan jurnalmu. Itu wajar! Mulai kecil saja hari ini — satu challenge selesai sudah cukup untuk membalikkan keadaan. Kamu kuat dari yang kamu kira 💪";
        }

        // Condition: mood mostly positive
        if ($positiveMoodCount >= 2) {
            return "Mood-mu lagi bagus, {$name}! 😊 AI kami deteksi energi positif dari jurnalmu. Manfaatkan momentum ini — selesaikan semua challenge hari ini dan naiki posisi leaderboard!";
        }

        // Condition: close to premium via points
        if ($user->points >= 400 && !$user->isPremium()) {
            $remaining = max(0, 500 - $user->points);
            if ($remaining > 0) {
                return "Hai {$name}, kamu tinggal {$remaining} poin lagi menuju Premium gratis! Selesaikan challenge hari ini dan klaim akses eksklusifmu.";
            } else {
                return "Selamat {$name}! Poin kamu ({$user->points}) sudah cukup untuk ditukar Premium 1 Bulan. Tukarkan sekarang di menu Premium!";
            }
        }

        // Condition: new user, no challenges yet
        if ($user->points == 0 && $completedCount == 0) {
            return "Halo {$name}! 👋 Selamat datang! Mulai perjalananmu dengan memilih satu challenge hari ini. Setiap langkah kecil membentuk kebiasaan besar.";
        }

        // Default based on completed count
        if ($completedCount >= 10) {
            return "Hebat, {$name}! Sudah {$completedCount} challenge berhasil kamu taklukkan. Konsistensimu luar biasa — terus jaga ritme ini!";
        }

        return "Semangat {$name}! Kamu sudah menyelesaikan {$completedCount} challenge. Ingat — 1% lebih baik setiap hari menghasilkan perubahan 37x lebih besar dalam setahun. Yuk lanjut!";
    }

    private function generateAIReminders($user)
    {
        $reminders = [];

        // 1. Journal reminder — check if journaled TODAY
        $hasJournaledToday = \App\Models\Journal::where('user_id', $user->id)
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->exists();

        if (!$hasJournaledToday) {
            $reminders[] = "📓 Kamu belum menulis jurnal hari ini. Luangkan 2 menit untuk mencatat moodmu — konsistensi journaling terbukti meningkatkan kesehatan mental.";
        }

        // 2. Challenge reminder — check real challenge progress
        $todayChallenges = \App\Models\Challenge::where('is_premium', false)->limit(3)->get();
        $startedCount = 0;
        $completedCount = 0;
        $totalCount = $todayChallenges->count();

        foreach ($todayChallenges as $challenge) {
            $userCh = \App\Models\UserChallenge::where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->first();

            if ($userCh) {
                if ($userCh->status === 'started') $startedCount++;
                elseif ($userCh->status === 'completed') $completedCount++;
            }
        }

        if ($startedCount > 0) {
            $reminders[] = "⏳ Kamu punya {$startedCount} challenge yang sudah dimulai tapi belum selesai. Selesaikan sekarang untuk klaim poin dan jaga streak!";
        }

        $remaining = $totalCount - $completedCount;
        if ($remaining > 0 && $completedCount < $totalCount) {
            $reminders[] = "🎯 Tinggal {$remaining} challenge lagi untuk hari ini. Selesaikan semuanya dan streak harianmu aman!";
        } elseif ($completedCount === $totalCount && $totalCount > 0) {
            $reminders[] = "🏆 Semua challenge hari ini selesai! Streak harianmu aman. Cek leaderboard untuk lihat posisimu sekarang.";
        }

        // 3. Streak at-risk reminder
        if ($user->last_streak_date !== null && !$user->last_streak_date->isToday() && !$user->last_streak_date->isYesterday() && $user->streak > 1) {
            $reminders[] = "⚠️ Streak {$user->streak} hari kamu dalam bahaya! Kamu belum menyelesaikan challenge beberapa hari. Selesaikan satu sekarang sebelum streak-mu hilang.";
        }

        // 4. Partner reminder
        $hasMutualPartner = $user->mutualPartners()->count() > 0;
        if (!$hasMutualPartner) {
            $reminders[] = "🤝 Kamu belum punya progress partner. Follow pengguna lain di menu Partner dan minta mereka follow balik untuk saling pantau progres!";
        }

        return $reminders;
    }
}
