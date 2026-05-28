<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Partner;
use App\Models\PartnerMessage;
use App\Models\User;
use Carbon\Carbon;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1. Get mutual partners (saling follow)
        $mutualPartners = $user->mutualPartners();
        
        // 2. Get following and followers lists
        $followingIds = Partner::where('user_id_1', $user->id)->where('status', 'following')->pluck('user_id_2');
        $followersIds = Partner::where('user_id_2', $user->id)->where('status', 'following')->pluck('user_id_1');
        
        $following = User::whereIn('id', $followingIds->diff($followersIds))->get();
        $followers = User::whereIn('id', $followersIds->diff($followingIds))->get();
        
        // 3. Set active partner for comparison and chat
        $activePartnerId = $request->query('active_partner_id');
        $partner = null;
        
        if ($activePartnerId) {
            $partner = User::find($activePartnerId);
        } elseif ($mutualPartners->count() > 0) {
            $partner = $mutualPartners->first();
        }
        
        $comparison = [];
        if ($partner) {
            $comparison = [
                'user_points' => $user->points,
                'partner_points' => $partner->points,
                'user_streak' => $user->streak,
                'partner_streak' => $partner->streak,
                'joint_progress' => min(100, round((($user->points + $partner->points) / 1500) * 100)) // Joint goal: 1500 points
            ];
        }

        // 4. Fetch partner suggestions (excluding self, already followed)
        $excludeIds = $followingIds->merge([$user->id]);
        
        $search = $request->query('search');
        $availablePartnersQuery = User::whereNotIn('id', $excludeIds)
            ->where('id', '!=', $user->id);

        if (!empty($search)) {
            $availablePartnersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $availablePartners = $availablePartnersQuery->limit(6)->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partner.partials.suggestions', compact('availablePartners'))->render()
            ]);
        }

        return view('partner.index', compact('partner', 'comparison', 'mutualPartners', 'following', 'followers', 'availablePartners'));
    }

    public function fetchMessages(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $partnerId = $request->query('partner_id');
        if (!$partnerId) {
            return response()->json(['messages' => []]);
        }

        // Verify if they are mutual partners before loading chat (or at least following/follower relation)
        $messages = PartnerMessage::where(function($q) use ($user, $partnerId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $partnerId);
        })->orWhere(function($q) use ($user, $partnerId) {
            $q->where('sender_id', $partnerId)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'receiver_id' => 'required|exists:users,id'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $partnerId = $request->receiver_id;

        // Store user message (real chat — no bot reply)
        $userMessage = PartnerMessage::create([
            'sender_id' => $user->id,
            'receiver_id' => $partnerId,
            'message' => $request->message
        ]);

        return response()->json([
            'success' => true,
            'user_message' => $userMessage
        ]);
    }

    public function toggleFollow(User $targetUser)
    {
        $user = Auth::user();
        
        if ($user->id == $targetUser->id) {
            return back()->with('error', "Anda tidak dapat mengikuti diri sendiri!");
        }

        // Check if already following
        $existing = Partner::where('user_id_1', $user->id)
            ->where('user_id_2', $targetUser->id)
            ->where('status', 'following')
            ->first();

        if ($existing) {
            // Unfollow
            $existing->delete();
            
            // Also clean up any reverse accepted partnerships if they existed
            Partner::where('user_id_1', $targetUser->id)->where('user_id_2', $user->id)->where('status', 'accepted')->update(['status' => 'following']);
            
            $message = "Batal mengikuti {$targetUser->name}.";
        } else {
            // Follow
            Partner::create([
                'user_id_1' => $user->id,
                'user_id_2' => $targetUser->id,
                'status' => 'following'
            ]);

            // Check if mutual follow (targetUser also follows user)
            $isMutual = Partner::where('user_id_1', $targetUser->id)
                ->where('user_id_2', $user->id)
                ->where('status', 'following')
                ->exists();

            if ($isMutual) {
                // Seed initial mutual follow welcome message
                PartnerMessage::create([
                    'sender_id' => $targetUser->id,
                    'receiver_id' => $user->id,
                    'message' => "Halo! Kita sekarang resmi saling follow sebagai progress partner. Yuk kita selesaikan challenge bareng!"
                ]);
                $message = "Berhasil mengikuti balik {$targetUser->name}! Anda sekarang adalah Progress Partner.";
            } else {
                $message = "Berhasil mengikuti {$targetUser->name}!";
            }
        }

        return back()->with('success', $message);
    }
}
