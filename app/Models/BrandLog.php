<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandLog extends Model
{
    protected $fillable = [
        'brandID',
        'userID',
        'desc',
        'detail',
    ];
}
