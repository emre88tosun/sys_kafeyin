<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastAddedStore extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'position',
        'viewCount',
    ];

    public function store()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }
}
