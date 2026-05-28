<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Fetch ranking of all users sorted by points
        $allRankings = User::orderBy('points', 'desc')->get();

        // Calculate rank of current user
        $myRank = 1;
        foreach ($allRankings as $index => $rankUser) {
            if ($rankUser->id == $user->id) {
                $myRank = $index + 1;
                break;
            }
        }

        // Limit lists: non-premium can only see top 3 + themselves, premium can see all (global leaderboard)!
        $rankings = [];
        $isPremium = $user->isPremium();
        
        if ($isPremium) {
            $rankings = $allRankings;
        } else {
            // Non-premium only sees top 3
            $rankings = $allRankings->take(3);
        }

        return view('leaderboard.index', compact('rankings', 'myRank', 'isPremium', 'allRankings'));
    }
}
