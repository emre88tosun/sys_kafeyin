<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteArticle extends Model
{
    protected $fillable = [
        'userID',
        'articleID',
    ];

    public function article()
    {
        return $this->hasOne(Article::class,'id','articleID');
    }
}
