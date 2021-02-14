<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreNotification extends Model
{
    protected $fillable = [
        'storeID',
        'desc',
        'isSeen',
    ];
}
