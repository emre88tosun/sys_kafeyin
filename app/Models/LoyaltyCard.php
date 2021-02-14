<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCard extends Model
{
    protected $fillable = [
        'userID',
        'brandID',
        'approverStoreID',
        'stampCount',
        'status',
        'isDeleted',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function approver_store()
    {
        return $this->belongsTo(Store::class,'approverStoreID','id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }
}
