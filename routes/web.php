<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LeaderboardController;

// Public landing page
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
})->name('landing');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/auth/google/select', [AuthController::class, 'selectGoogleAccount'])->name('auth.google.select');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes (Requires User to be logged in)
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard Home
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ai-reminders', [DashboardController::class, 'getAIRemindersJson'])->name('dashboard.ai-reminders');

    // 2. Challenges
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('/challenges/{challenge}/start', [ChallengeController::class, 'start'])->name('challenges.start');
    Route::post('/challenges/{challenge}/complete', [ChallengeController::class, 'complete'])->name('challenges.complete');
    Route::post('/challenges/{challenge}/youtube', [ChallengeController::class, 'updateYoutubeLink'])->name('challenges.youtube');
    Route::post('/challenges/track-video', [ChallengeController::class, 'trackVideoProgress'])->name('challenges.track-video');

    // 3. Journaling
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');

    // 4. Progress Partner
    Route::get('/partner', [PartnerController::class, 'index'])->name('partner.index');
    Route::get('/partner/messages', [PartnerController::class, 'fetchMessages'])->name('partner.messages');
    Route::post('/partner/messages', [PartnerController::class, 'sendMessage'])->name('partner.send-message');
    Route::post('/partner/toggle-follow/{targetUser}', [PartnerController::class, 'toggleFollow'])->name('partner.toggle-follow');

    // 5. Community Feed (Locked inside the controller for premium)
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community/post', [CommunityController::class, 'storePost'])->name('community.store-post');
    Route::post('/community/post/{post}/comment', [CommunityController::class, 'storeComment'])->name('community.store-comment');
    Route::post('/community/post/{post}/like', [CommunityController::class, 'toggleLike'])->name('community.toggle-like');

    // 6. Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // 7. Premium System
    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/buy', [PremiumController::class, 'buyPremium'])->name('premium.buy');
    Route::post('/premium/redeem', [PremiumController::class, 'redeemPoints'])->name('premium.redeem');
    Route::post('/premium/claim-theme', [PremiumController::class, 'claimTheme'])->name('premium.claim-theme');
    Route::post('/premium/claim-badge', [PremiumController::class, 'claimBadge'])->name('premium.claim-badge');
    Route::post('/premium/approve/{transaction}', [PremiumController::class, 'approveTransaction'])->name('premium.approve');

    // 8. User Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'updateProfile'])->name('settings.update');
});

// Pakasir Payment Gateway Webhook
Route::post('/payment/pakasir/webhook', [PremiumController::class, 'handlePakasirWebhook'])->name('payment.pakasir.webhook');

// Route sementara untuk cPanel (Bisa dihapus setelah berhasil)
Route::get('/jalankan-migrasi', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate --force');
        return 'Migrasi database berhasil!<br><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/bersih-cache', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return 'Cache berhasil dibersihkan!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

