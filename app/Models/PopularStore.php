<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularStore extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'isPaid',
        'position',
        'viewCount',
    ];

    public function store()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }
}
