<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemViewLog extends Model
{
    protected $fillable = [
        'menuItemID',
        'userID',
    ];
}
