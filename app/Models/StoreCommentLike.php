<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCommentLike extends Model
{
    protected $fillable = [
        'userID',
        'storeCommentID',
    ];
}
