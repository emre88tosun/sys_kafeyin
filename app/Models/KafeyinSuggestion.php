<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinSuggestion extends Model
{
    protected $fillable = [
        'userID',
        'title',
        'desc',
        'isRead',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
