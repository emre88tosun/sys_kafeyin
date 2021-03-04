<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipApplicationReferral extends Model
{
    protected $fillable = [
        'brandID',
        'referralCode',
        'isUsed',
        'isValid',
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function basvuru()
    {
        return $this->hasOne(OwnershipApplication::class,'referralID','id');
    }
}
