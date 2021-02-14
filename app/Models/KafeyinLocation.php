<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinLocation extends Model
{
    protected $fillable = [
        'cityID',
        'name',
        'latitude',
        'longitude',
    ];

    public function usage()
    {
        return $this->hasMany(UserLocationChange::class,'kafeyinLocationID','id');
    }
}
