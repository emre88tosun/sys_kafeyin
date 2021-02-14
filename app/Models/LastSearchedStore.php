<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastSearchedStore extends Model
{
    protected $fillable = [
        'userID',
        'storeID',
    ];
}
