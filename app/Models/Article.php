<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'isActive',
        'title',
        'desc',
        'imageLink',
        'hasVideo',
        'videoLink',
        'viewCount',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteArticle::class,'articleID','id');
    }
}
