<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $appends = ['activeLoyaltyCardCount','usedLoyaltyCardCount','allLoyaltyCardCount',];
    protected $fillable = [
        'name',
        'isEnabledLoyaltyCard',
        'needStampCount',
        'logo',
        'isPremium',
        'premiumPlanFeePerStore',
        'takeAwayOrderCommissionPercent',
        'otherOrdersCommissionPercent',
        'activityTicketingCommissionPercent',
        'adminNote',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class,'brandID','id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class,'id','brandID');
    }

    public function loyalty_cards()
    {
        return $this->hasMany(LoyaltyCard::class,'brandID','id');
    }

    public function notifs()
    {
        return $this->hasMany(BrandNotification::class,'brandID','id');
    }

    public function today_created_cards()
    {
        return $this->hasMany(LoyaltyCard::class,'brandID','id')->where('loyalty_cards.created_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }

    public function today_approved_cards()
    {
        return $this->hasMany(LoyaltyCard::class,'brandID','id')->where('status','used')->where('loyalty_cards.updated_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }

    public function getActiveLoyaltyCardCountAttribute()
    {
        return $this->loyalty_cards()->where('status','active')->count() ? : 0;
    }

    public function getUsedLoyaltyCardCountAttribute()
    {
        return $this->loyalty_cards()->where('status','used')->count() ? : 0;
    }

    public function getAllLoyaltyCardCountAttribute()
    {
        return $this->loyalty_cards()->count() ? : 0;
    }

}
