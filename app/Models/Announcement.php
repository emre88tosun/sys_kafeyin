<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'cityID',
        'brandID',
        'title',
        'desc',
        'imageLink',
        'position',
        'isActive',
        'viewCount',
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id','cityID');
    }
}
