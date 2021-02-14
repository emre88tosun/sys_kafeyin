<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressNeighborhood extends Model
{
    protected $fillable = [
        'districtID',
        'name',
        'postalCode',
    ];
}
