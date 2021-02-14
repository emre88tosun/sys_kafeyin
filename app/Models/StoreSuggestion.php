<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSuggestion extends Model
{
    protected $fillable = [
        'userID',
        'storeName',
        'storeCity',
        'storeLocation',
        'isRead',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
