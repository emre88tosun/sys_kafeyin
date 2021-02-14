<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteActivity extends Model
{
    protected $fillable = [
        'userID',
        'activityID',
    ];

    public function activity()
    {
        return $this->hasOne(Activity::class,'id','activityID');
    }
}
