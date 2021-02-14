<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'followerID',
        'followingID',
    ];

    public function follower_user()
    {
        return $this->hasOne(User::class,'id','followerID');
    }

    public function following_user()
    {
        return $this->hasOne(User::class,'id','followingID');
    }
}
