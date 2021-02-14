<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCardApproval extends Model
{
    protected $fillable = [
        'userID',
        'cardID',
        'referralCode',
    ];

    public function card()
    {
        return $this->belongsTo(LoyaltyCard::class,'cardID','id');
    }
}
