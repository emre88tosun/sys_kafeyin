<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinBoolSetting extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'value',
    ];
}
