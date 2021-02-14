<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCommentPhoto extends Model
{
    protected $fillable = [
        'userID',
        'storeID',
        'commentID',
        'imageLink',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }
}
