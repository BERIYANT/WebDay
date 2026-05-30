<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Approve manual premium transaction.
     */
    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini tidak berstatus pending dan tidak bisa disetujui.');
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

        return back()->with('success', "Transaksi #{$transaction->id} oleh @{$user->name} disetujui! Status Premium diaktifkan (+{$daysToAdd} hari).");
    }

    /**
     * Reject manual premium transaction.
     */
    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini tidak berstatus pending.');
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return back()->with('success', "Transaksi #{$transaction->id} berhasil ditolak.");
    }
}
