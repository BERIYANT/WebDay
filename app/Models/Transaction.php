<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'price',
        'payment_method',
        'status',
        'proof_of_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
