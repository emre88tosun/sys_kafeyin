<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityTicket extends Model
{
    protected $fillable = [
        'activityID',
        'userID',
        'isUsed',
        'referralCode',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
