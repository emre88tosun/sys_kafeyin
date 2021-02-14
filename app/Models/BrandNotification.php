<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandNotification extends Model
{
    protected $fillable = [
        'brandID',
        'desc',
        'isSeen',
    ];
}
