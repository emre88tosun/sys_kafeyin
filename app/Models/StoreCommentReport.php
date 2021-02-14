<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCommentReport extends Model
{
    protected $fillable = [
        'userID',
        'storeCommentID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function comment()
    {
        return $this->hasOne(StoreComment::class,'id','storeCommentID');
    }
}
