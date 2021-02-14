<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinNews extends Model
{
    protected $fillable = [
        'cityID',
        'title',
        'desc',
        'imageLink',
    ];
}
