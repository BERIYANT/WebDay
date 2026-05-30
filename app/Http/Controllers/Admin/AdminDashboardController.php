<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Challenge;
use App\Models\CommunityPost;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with statistics and overview.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'premium_users' => User::where('is_premium', true)->count(),
            'total_challenges' => Challenge::count(),
            'total_posts' => CommunityPost::count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('price'),
        ];

        // Fetch recent pending transactions
        $recentTransactions = Transaction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Fetch top streak users
        $topStreaks = User::orderBy('streak', 'desc')
            ->limit(5)
            ->get();

        // Fetch latest community posts
        $recentPosts = CommunityPost::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'topStreaks', 'recentPosts'));
    }
}
