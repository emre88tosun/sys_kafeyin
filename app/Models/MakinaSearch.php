<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakinaSearch extends Model
{
    protected $fillable = [
        'cityID',
        'userID',
        'tag1',
        'tag2',
        'tag3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
