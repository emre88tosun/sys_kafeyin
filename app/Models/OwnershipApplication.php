<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipApplication extends Model
{
    protected $fillable = [
        'brandID',
        'referralID',
        'detail',
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function ref()
    {
        return $this->hasOne(OwnershipApplicationReferral::class,'id','referralID');
    }
}
