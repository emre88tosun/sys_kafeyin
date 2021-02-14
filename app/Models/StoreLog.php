<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreLog extends Model
{
    protected $fillable = [
        'storeID',
        'userID',
        'desc',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','userID');
    }

    public function magaza()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }
}
