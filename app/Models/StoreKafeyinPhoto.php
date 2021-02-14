<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreKafeyinPhoto extends Model
{
    protected $fillable = [
        'storeID',
        'imageLink',
    ];
}
