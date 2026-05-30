<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'points',
        'streak',
        'last_login_date',
        'last_streak_date',
        'is_premium',
        'premium_until',
        'theme_dark_unlocked',
        'badge_unlocked',
        'selected_badge',
        'selected_theme',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_until' => 'datetime',
            'last_login_date' => 'date',
            'last_streak_date' => 'date',
        ];
    }

    /**
     * Update streak based on today's challenge completion.
     * Call this every time a challenge is completed.
     */
    public function updateStreak(): void
    {
        $today = Carbon::today();

        if ($this->last_streak_date === null) {
            // First time completing a challenge
            $this->streak = 1;
            $this->last_streak_date = $today;
        } elseif ($this->last_streak_date->isToday()) {
            // Already updated streak today, do nothing
            return;
        } elseif ($this->last_streak_date->isYesterday()) {
            // Completed yesterday → keep the streak going
            $this->streak += 1;
            $this->last_streak_date = $today;
        } else {
            // Missed at least one day → reset streak
            $this->streak = 1;
            $this->last_streak_date = $today;
        }

        $this->save();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPremium()
    {
        if ($this->is_premium) {
            if ($this->premium_until === null || $this->premium_until->isFuture()) {
                return true;
            }
        }
        return false;
    }

    public function getLeaderboardBadge()
    {
        // If badge claimed, user can select their special badge, otherwise auto-calculate based on points
        if ($this->badge_unlocked && $this->selected_badge !== 'Beginner') {
            return $this->selected_badge;
        }

        $points = $this->points;
        if ($points >= 1000) return 'Legend';
        if ($points >= 500) return 'Master';
        if ($points >= 250) return 'Warrior';
        if ($points >= 100) return 'Challenger';
        return 'Beginner';
    }

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class)->orderBy('created_at', 'desc');
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getPartner()
    {
        $partnerShip = Partner::where(function($query) {
            $query->where('user_id_1', $this->id)
                  ->orWhere('user_id_2', $this->id);
        })->where('status', 'accepted')->first();

        if ($partnerShip) {
            $partnerId = ($partnerShip->user_id_1 == $this->id) ? $partnerShip->user_id_2 : $partnerShip->user_id_1;
            return User::find($partnerId);
        }
        return null;
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'partners', 'user_id_1', 'user_id_2')->wherePivot('status', 'following');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'partners', 'user_id_2', 'user_id_1')->wherePivot('status', 'following');
    }

    public function isFollowing(User $other)
    {
        return Partner::where('user_id_1', $this->id)->where('user_id_2', $other->id)->where('status', 'following')->exists();
    }

    public function isMutualPartner(User $other)
    {
        return $this->isFollowing($other) && $other->isFollowing($this);
    }

    public function mutualPartners()
    {
        $followingIds = Partner::where('user_id_1', $this->id)->where('status', 'following')->pluck('user_id_2');
        $followerIds = Partner::where('user_id_2', $this->id)->where('status', 'following')->pluck('user_id_1');
        
        $mutualIds = $followingIds->intersect($followerIds);
        
        return User::whereIn('id', $mutualIds)->get();
    }

    public function getTodayProgressPercentage()
    {
        $todayChallengesCount = Challenge::where('is_premium', false)->limit(3)->count();
        if ($todayChallengesCount == 0) return 0;
        
        $todayChallengesIds = Challenge::where('is_premium', false)->limit(3)->pluck('id');
        
        $completedTodayCount = UserChallenge::where('user_id', $this->id)
            ->whereIn('challenge_id', $todayChallengesIds)
            ->where('status', 'completed')
            ->count();
            
        return round(($completedTodayCount / $todayChallengesCount) * 100);
    }
}
