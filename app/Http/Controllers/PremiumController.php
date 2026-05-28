<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Reward;
use App\Models\Journal;
use App\Models\UserChallenge;
use App\Models\Challenge;
use Carbon\Carbon;

class PremiumController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch user transaction history
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Check if rewards are claimed
        $hasDarkThemeReward = Reward::where('user_id', $user->id)
            ->where('reward_type', 'theme_dark')
            ->exists();

        $hasSpecialBadgeReward = Reward::where('user_id', $user->id)
            ->where('reward_type', 'badge_special')
            ->exists();

        // Advanced AI Insights based on REAL user data
        $aiInsights = [];
        if ($user->isPremium()) {
            // --- Health Insight: based on health/fitness challenge completions ---
            $fitnessCompleted = UserChallenge::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereHas('challenge', fn($q) => $q->where('category', 'like', '%Fitness%')
                    ->orWhere('category', 'like', '%Olahraga%')
                    ->orWhere('category', 'like', '%Health%'))
                ->count();

            $totalFitness = Challenge::where('category', 'like', '%Fitness%')
                ->orWhere('category', 'like', '%Olahraga%')
                ->orWhere('category', 'like', '%Health%')
                ->count();

            $fitnessRate = $totalFitness > 0 ? round(($fitnessCompleted / $totalFitness) * 100) : 0;

            if ($fitnessCompleted === 0) {
                $aiInsights['health'] = 'Kamu belum menyelesaikan challenge kesehatan & kebugaran. Mulai dari Home Full Body Workout untuk membangun kebiasaan aktif bergerak setiap hari.';
            } else {
                $aiInsights['health'] = "Kamu sudah menyelesaikan {$fitnessCompleted} challenge kebugaran ({$fitnessRate}% dari semua challenge fitness). Konsistensi olahraga membantumu menjaga energi dan sirkulasi tubuh.";
            }

            // --- Mental Insight: based on journal mood data ---
            $journals = Journal::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $totalJournals = $journals->count();

            if ($totalJournals === 0) {
                $aiInsights['mental'] = 'Kamu belum memiliki entri jurnal. Mulai journaling hari ini — mencatat mood dan pikiran terbukti meningkatkan kesadaran diri dan kesehatan mental.';
            } else {
                $positiveMoods = $journals->filter(fn($j) => in_array($j->mood, ['happy', 'excited', 'grateful', 'energetic']))->count();
                $negativeMoods = $journals->filter(fn($j) => in_array($j->mood, ['sad', 'anxious', 'tired', 'stressed']))->count();
                $positiveRate = round(($positiveMoods / $totalJournals) * 100);

                $moodLabel = $positiveRate >= 70 ? 'sangat positif' : ($positiveRate >= 50 ? 'cukup seimbang' : 'cenderung negatif');
                $aiInsights['mental'] = "Dari {$totalJournals} entri jurnal terakhirmu, {$positiveRate}% mencerminkan mood positif ({$moodLabel}). " .
                    ($positiveRate < 50 ? 'Pertimbangkan untuk menambah aktivitas self-care dan olahraga ringan.' : 'Pertahankan kebiasaan journaling ini!');
            }

            // --- Productivity Insight: based on deep work / study challenge completions ---
            $productivityCompleted = UserChallenge::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereHas('challenge', fn($q) => $q->where('category', 'like', '%Produktivitas%')
                    ->orWhere('category', 'like', '%Deep Work%')
                    ->orWhere('name', 'like', '%Fokus%')
                    ->orWhere('name', 'like', '%Belajar%'))
                ->count();

            $streakDays = $user->streak;

            if ($productivityCompleted === 0) {
                $aiInsights['productivity'] = 'Belum ada challenge produktivitas yang diselesaikan. Coba mulai dengan sesi Fokus Belajar 45 Menit untuk melatih Deep Work dan meningkatkan konsentrasi.';
            } else {
                $aiInsights['productivity'] = "Kamu sudah menyelesaikan {$productivityCompleted} challenge produktivitas dengan streak aktif {$streakDays} hari. " .
                    ($streakDays >= 3 ? 'Pola konsistensimu sangat baik — pertahankan waktu belajar di jam yang sama setiap hari.' : 'Tingkatkan frekuensi untuk membangun ritme produktif yang stabil.');
            }
        }

        return view('premium.index', compact('transactions', 'hasDarkThemeReward', 'hasSpecialBadgeReward', 'aiInsights'));
    }

    public function buyPremium(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:1m,6m,1y',
            'payment_method' => 'required|in:qris,shopee,dana',
            'proof_of_payment' => $request->payment_method === 'qris' ? 'nullable' : 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();

        $prices = [
            '1m' => 20000,
            '6m' => 75000,
            '1y' => 120000
        ];

        $price = $prices[$request->plan];

        $daysToAdd = [
            '1m' => 30,
            '6m' => 180,
            '1y' => 365
        ][$request->plan];

        // 1. If payment method is QRIS, it creates a transaction and redirects to Pakasir
        if ($request->payment_method === 'qris') {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'plan' => $request->plan,
                'price' => $price,
                'payment_method' => 'qris',
                'status' => 'pending'
            ]);

            try {
                // Generate unique Order ID that satisfies Pakasir constraint (min 5 characters)
                $formattedOrderId = 'TRX-' . str_pad((string) $transaction->id, 5, '0', STR_PAD_LEFT);

                // Call Pakasir SDK to create a real QRIS payment link
                $pakasirTransaction = \Fadhila36\Pakasir\Facades\Pakasir::createPayment(
                    paymentMethod: \Fadhila36\Pakasir\Enums\PaymentMethod::QRIS,
                    orderId: $formattedOrderId,
                    amount: $price,
                    redirectUrl: route('premium.index')
                );

                // Redirect the user to Pakasir checkout / QRIS page
                return redirect($pakasirTransaction->paymentUrl);

            } catch (\Exception $e) {
                // Rollback transaction if creation fails
                $transaction->delete();

                \Illuminate\Support\Facades\Log::error('Pakasir QRIS Payment Creation Failed: ' . $e->getMessage());

                return back()->with('error', 'Gagal memproses pembayaran QRIS Pakasir: ' . $e->getMessage());
            }
        }

        // 2. If ShopeePay or DANA, manual proof is required
        $proofName = null;
        if ($request->hasFile('proof_of_payment')) {
            $image = $request->file('proof_of_payment');
            $proofName = 'proof_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Move to public storage
            $image->move(public_path('uploads/proofs'), $proofName);
        }

        // Create a pending transaction in database
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'plan' => $request->plan,
            'price' => $price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'proof_of_payment' => $proofName
        ]);

        return redirect()->route('premium.index')->with('success', 'Bukti pembayaran Anda berhasil diunggah! Mohon tunggu verifikasi persetujuan dari Admin.');
    }

    public function redeemPoints()
    {
        $user = Auth::user();

        if ($user->points < 500) {
            return back()->with('error', 'Poin Anda tidak mencukupi. Anda membutuhkan minimal 500 poin untuk menukarkannya dengan Premium.');
        }

        // Deduct points
        $user->points -= 500;
        $user->is_premium = true;

        if ($user->premium_until && $user->premium_until->isFuture()) {
            $user->premium_until = $user->premium_until->addDays(30);
        } else {
            $user->premium_until = Carbon::now()->addDays(30);
        }
        $user->save();

        // Create Reward entry
        Reward::create([
            'user_id' => $user->id,
            'reward_type' => 'premium_1m',
            'claimed_at' => Carbon::now()
        ]);

        return redirect()->route('premium.index')->with('success', 'Selamat! 500 Poin Anda berhasil ditukarkan dengan Akses Premium 1 Bulan gratis.');
    }

    public function claimTheme()
    {
        $user = Auth::user();

        if ($user->points < 100 && !$user->isPremium()) {
            return back()->with('error', 'Klaim Tema Custom memerlukan minimal 100 poin atau status Premium!');
        }

        // Deduct 100 points if not premium
        if (!$user->isPremium()) {
            $user->points -= 100;
        }

        $user->theme_dark_unlocked = true;
        $user->save();

        Reward::create([
            'user_id' => $user->id,
            'reward_type' => 'theme_dark',
            'claimed_at' => Carbon::now()
        ]);

        return redirect()->route('premium.index')->with('success', 'Tema Custom Dark Mode berhasil diklaim! Silakan aktifkan di pengaturan profil.');
    }

    public function claimBadge()
    {
        $user = Auth::user();

        if ($user->points < 150 && !$user->isPremium()) {
            return back()->with('error', 'Klaim Badge Spesial memerlukan minimal 150 poin atau status Premium!');
        }

        // Deduct 150 points if not premium
        if (!$user->isPremium()) {
            $user->points -= 150;
        }

        $user->badge_unlocked = true;
        $user->save();

        Reward::create([
            'user_id' => $user->id,
            'reward_type' => 'badge_special',
            'claimed_at' => Carbon::now()
        ]);

        return redirect()->route('premium.index')->with('success', 'Badge Spesial berhasil diklaim! Anda dapat menggunakannya sebagai lencana profil sekarang.');
    }

    /**
     * Handle incoming webhook notification from Pakasir Payment Gateway.
     */
    public function handlePakasirWebhook(Request $request)
    {
        // 1. Log incoming Pakasir webhook for debugging
        \Illuminate\Support\Facades\Log::info('Incoming Pakasir Webhook Payload:', $request->all());

        // 2. Read order_id from Pakasir payload (usually order_id or external_id)
        $orderId = $request->input('order_id') ?: $request->input('external_id');

        if (!$orderId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing order_id or external_id in payload.'
            ], 400);
        }

        // 3. Find the corresponding Transaction record
        // Extract numeric ID by removing 'TRX-' prefix and stripping leading zeros
        $cleanId = (int) str_replace('TRX-', '', $orderId);
        $transaction = Transaction::where('id', $cleanId)->orWhere('id', $orderId)->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found for ID: ' . $orderId
            ], 404);
        }

        // 4. If transaction is already completed, return success immediately
        if ($transaction->status === 'completed') {
            return response()->json([
                'success' => true,
                'message' => 'Transaction was already completed.'
            ], 200);
        }

        // 5. Update transaction status to completed
        $transaction->status = 'completed';
        $transaction->save();

        // 6. Update user's premium status and end date
        $user = $transaction->user;
        if ($user) {
            $daysToAdd = [
                '1m' => 30,
                '6m' => 180,
                '1y' => 365
            ][$transaction->plan] ?? 30;

            $user->is_premium = true;
            if ($user->premium_until && $user->premium_until->isFuture()) {
                $user->premium_until = $user->premium_until->addDays($daysToAdd);
            } else {
                $user->premium_until = Carbon::now()->addDays($daysToAdd);
            }
            $user->save();

            \Illuminate\Support\Facades\Log::info("User ID {$user->id} premium status activated via Pakasir Webhook. Plan: {$transaction->plan} (+{$daysToAdd} days).");
        }

        return response()->json([
            'success' => true,
            'message' => 'Webhook processed successfully, transaction marked as completed, and premium activated.'
        ], 200);
    }

    /**
     * Approve manual premium transaction (Admin Simulation).
     */
    public function approveTransaction(Transaction $transaction)
    {
        if ($transaction->status === 'completed') {
            return back()->with('info', 'Transaksi ini sudah selesai disetujui sebelumnya.');
        }

        $transaction->status = 'completed';
        $transaction->save();

        $daysToAdd = [
            '1m' => 30,
            '6m' => 180,
            '1y' => 365
        ][$transaction->plan] ?? 30;

        $user = $transaction->user;
        if ($user) {
            $user->is_premium = true;
            if ($user->premium_until && $user->premium_until->isFuture()) {
                $user->premium_until = $user->premium_until->addDays($daysToAdd);
            } else {
                $user->premium_until = Carbon::now()->addDays($daysToAdd);
            }
            $user->save();
        }

        return back()->with('success', "Simulasi Persetujuan Sukses! Transaksi #{$transaction->id} berhasil disetujui dan status Premium akun telah aktif selama {$daysToAdd} hari.");
    }
}
