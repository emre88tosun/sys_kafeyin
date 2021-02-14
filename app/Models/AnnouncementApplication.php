<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementApplication extends Model
{
    protected $fillable = [
        'brandID',
        'title',
        'desc',
        'imageLink',
        'status',
        'adminMessage',
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }
}
