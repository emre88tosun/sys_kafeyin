<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegisteredStoreUser extends Model
{
    protected $fillable = [
        'applicationID',
        'referralCode',
        'name',
        'surname',
        'email',
        'gsmNumber',
        'isBrandManager',
        'brandID',
        'isStoreManager',
        'storeID',
        'detail',
    ];

    public function marka()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function magaza()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }

    public function ilkbasvuru()
    {
        return $this->hasOne(OwnershipApplication::class,'id','applicationID');
    }

    public function user()
    {
        return $this->hasOne(User::class,'email','email');
    }
}
