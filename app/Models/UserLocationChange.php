<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocationChange extends Model
{
    protected $fillable = [
        'userID',
        'kafeyinLocationID',
    ];
}
