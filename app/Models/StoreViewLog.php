<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreViewLog extends Model
{
    protected $fillable = [
        'storeID',
        'userID',
    ];

    public function viewer()
    {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }
}
