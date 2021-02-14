<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'cityID',
        'name',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class,'locationID','id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'cityID','id');
    }
}
