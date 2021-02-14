<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinBadge extends Model
{
    protected $fillable = [
        'code',
        'title',
        'desc',
        'needPoint',
    ];
}
