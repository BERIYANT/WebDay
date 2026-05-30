<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    /**
     * Display a listing of the feedbacks/suggestions.
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user');

        // Optional search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Remove the specified feedback/suggestion from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $userName = $feedback->user ? $feedback->user->name : 'Pengguna';
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
            ->with('success', "Saran dari @{$userName} berhasil dihapus.");
    }
}
