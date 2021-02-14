<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressCounty extends Model
{
    protected $fillable = [
        'cityID',
        'name',
    ];
}
