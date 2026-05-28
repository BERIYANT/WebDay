<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Challenge;
use App\Models\UserChallenge;
use Carbon\Carbon;

class ChallengeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch all challenges grouped by category
        $challenges = Challenge::all()->groupBy('category');

        // Fetch user progress on these challenges
        $userChallenges = UserChallenge::where('user_id', $user->id)
            ->get()
            ->keyBy('challenge_id');

        return view('challenges.index', compact('challenges', 'userChallenges'));
    }

    public function start(Challenge $challenge)
    {
        $user = Auth::user();

        // Premium validation
        if ($challenge->is_premium && !$user->isPremium()) {
            return back()->with('error', 'Challenge ini memerlukan akses Premium! Silakan upgrade akun Anda terlebih dahulu.');
        }

        // Start user challenge
        $userChallenge = UserChallenge::firstOrCreate(
            [
                'user_id' => $user->id,
                'challenge_id' => $challenge->id
            ],
            [
                'status' => 'started',
                'progress' => 0,
                'watched_seconds' => 0
            ]
        );

        return back()->with('success', "Challenge '{$challenge->name}' berhasil dimulai!");
    }

    public function complete(Challenge $challenge)
    {
        $user = Auth::user();
        
        // Premium validation
        if ($challenge->is_premium && !$user->isPremium()) {
            return back()->with('error', 'Challenge ini memerlukan akses Premium!');
        }

        // If the challenge has a YouTube video, they MUST watch it instead of clicking "Selesaikan" manually
        if ($challenge->youtube_link && !request()->has('bypass_video')) {
            return back()->with('error', 'Challenge ini memiliki materi video wajib! Anda harus menonton minimal 50% video untuk menyelesaikan.');
        }

        $userChallenge = UserChallenge::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->first();

        if (!$userChallenge) {
            // Force start first
            $userChallenge = UserChallenge::create([
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
                'status' => 'started',
                'progress' => 0
            ]);
        }

        if ($userChallenge->status !== 'completed') {
            $userChallenge->status = 'completed';
            $userChallenge->progress = 100;
            $userChallenge->completed_at = Carbon::now();
            $userChallenge->save();

            // Award points
            $user->points += $challenge->points_reward;
            $user->save();

            // Update streak (auto-increment or reset)
            $user->updateStreak();

            return back()->with('success', "Selamat! Anda menyelesaikan '{$challenge->name}' dan mendapatkan {$challenge->points_reward} poin!");
        }

        return back()->with('info', "Challenge '{$challenge->name}' sudah diselesaikan sebelumnya.");
    }

    // Dynamic Youtube input update
    public function updateYoutubeLink(Request $request, Challenge $challenge)
    {
        $request->validate([
            'youtube_link' => 'required|url'
        ]);

        $challenge->youtube_link = $request->youtube_link;
        $challenge->save();

        return back()->with('success', 'Link video tutorial berhasil diperbarui secara dinamis!');
    }

    // Video progress tracking API (Anti-cheat)
    public function trackVideoProgress(Request $request)
    {
        $request->validate([
            'challenge_id' => 'required|exists:challenges,id',
            'progress' => 'required|numeric|min:0|max:100',
            'watched_seconds' => 'required|integer'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $challenge = Challenge::find($request->challenge_id);
        
        // Premium protection
        if ($challenge->is_premium && !$user->isPremium()) {
            return response()->json(['error' => 'Premium access required'], 403);
        }

        $userChallenge = UserChallenge::firstOrCreate(
            [
                'user_id' => $user->id,
                'challenge_id' => $challenge->id
            ],
            [
                'status' => 'started',
                'progress' => 0,
                'watched_seconds' => 0
            ]
        );

        // Update progress
        if ($userChallenge->status !== 'completed') {
            $newProgress = max($userChallenge->progress, $request->progress);
            $userChallenge->progress = $newProgress;
            $userChallenge->watched_seconds = max($userChallenge->watched_seconds, $request->watched_seconds);
            
            // Anti-cheat trigger: If they reached 50% or more, automatically mark as completed!
            if ($newProgress >= 50) {
                $userChallenge->status = 'completed';
                $userChallenge->completed_at = Carbon::now();
                $userChallenge->save();

                // Award points
                $user->points += $challenge->points_reward;
                $user->save();

                // Update streak
                $user->updateStreak();

                return response()->json([
                    'success' => true,
                    'status' => 'completed',
                    'message' => "Hebat! Anda menonton 50%+ video dan berhasil menyelesaikan challenge '{$challenge->name}'! +{$challenge->points_reward} Poin ditambahkan.",
                    'points' => $user->points
                ]);
            }

            $userChallenge->save();
        }

        return response()->json([
            'success' => true,
            'status' => $userChallenge->status,
            'progress' => $userChallenge->progress
        ]);
    }
}
