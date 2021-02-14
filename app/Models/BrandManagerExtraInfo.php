<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandManagerExtraInfo extends Model
{
    protected $fillable = [
        'userID',
        'city',
        'country',
        'address',
    ];
}
