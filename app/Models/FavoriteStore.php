<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteStore extends Model
{
    protected $fillable = [
        'userID',
        'storeID',
    ];

    public function store()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
