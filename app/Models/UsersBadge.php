<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersBadge extends Model
{
    protected $fillable = [
        'userID',
        'badgeID',
        'currentPoint',
        'isDone',
    ];
}
