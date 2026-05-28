<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'description',
        'difficulty',
        'points_reward',
        'time_estimate',
        'is_premium',
        'youtube_link'
    ];

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }
}
