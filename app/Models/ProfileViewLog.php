<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileViewLog extends Model
{
    protected $fillable = [
        'userID',
        'viewingUserID',
    ];
}
