<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Journal;
use App\Models\Challenge;
use App\Models\UserChallenge;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch all journals for this user
        $journals = Journal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Calculate Consistency Rate (over last 14 days)
        $last14Days = [];
        $journaledDaysCount = 0;
        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $hasEntry = Journal::where('user_id', $user->id)
                ->whereDate('created_at', $date)
                ->exists();
                
            $last14Days[$date->format('Y-m-d')] = $hasEntry;
            if ($hasEntry) {
                $journaledDaysCount++;
            }
        }
        $consistencyRate = round(($journaledDaysCount / 14) * 100);

        // 2. Compile Mood Statistics
        $moodCounts = [
            'happy' => 0,
            'neutral' => 0,
            'sad' => 0,
            'stressed' => 0,
            'energetic' => 0
        ];
        foreach ($journals as $journal) {
            if (isset($moodCounts[$journal->mood])) {
                $moodCounts[$journal->mood]++;
            }
        }
        $totalJournals = count($journals);
        $moodStats = [];
        foreach ($moodCounts as $mood => $count) {
            $moodStats[$mood] = [
                'count' => $count,
                'percentage' => $totalJournals > 0 ? round(($count / $totalJournals) * 100) : 0
            ];
        }

        // 3. Calendar Highlights: Fetch dates for active highlights (this month)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $calendarEntries = Journal::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function($journal) {
                return $journal->created_at->format('j'); // Return day number
            })->unique()->toArray();

        // 4. Fetch the Gratitude Journal Challenge to allow inline video tracking
        $gratitudeChallenge = Challenge::where('name', 'like', '%Gratitude%')->first();
        $gratitudeUserChallenge = $gratitudeChallenge 
            ? UserChallenge::where('user_id', $user->id)->where('challenge_id', $gratitudeChallenge->id)->first()
            : null;

        return view('journal.index', compact(
            'journals',
            'consistencyRate',
            'moodStats',
            'calendarEntries',
            'gratitudeChallenge',
            'gratitudeUserChallenge'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'mood' => 'required|in:happy,neutral,sad,stressed,energetic'
        ]);

        $user = Auth::user();

        // Create journal entry
        Journal::create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'mood' => $request->mood
        ]);

        // Award journaling bonus points (15 points per entry)
        $user->points += 15;
        $user->save();

        // Check if there is an active journaling challenge and complete it
        $journalChallenge = Challenge::where('name', 'like', '%Menulis Jurnal%')->first();
        if ($journalChallenge) {
            UserChallenge::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'challenge_id' => $journalChallenge->id
                ],
                [
                    'status' => 'completed',
                    'progress' => 100,
                    'completed_at' => Carbon::now()
                ]
            );
        }

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil disimpan! Anda mendapatkan +15 poin.');
    }
}
