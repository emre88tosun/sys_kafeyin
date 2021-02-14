<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinStringSetting extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'value',
    ];
}
