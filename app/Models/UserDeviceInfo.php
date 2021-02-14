<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceInfo extends Model
{
    protected $fillable = [
        'userID',
        'brand',
        'device',
        'systemVersion',
        'connType',
    ];
}
