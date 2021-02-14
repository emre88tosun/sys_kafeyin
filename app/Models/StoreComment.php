<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreComment extends Model
{
    protected $fillable = [
        'storeID',
        'userID',
        'commentPoint',
        'commentText',
    ];

    public function photos()
    {
        return $this->hasMany(StoreCommentPhoto::class,'commentID','id');
    }

    public function likes()
    {
        return $this->hasMany(StoreCommentLike::class,'storeCommentID','id');
    }

    public function commenter()
    {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }
}
