<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinStory extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'imageLink',
        'isActive',
        'viewCount',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }
}
