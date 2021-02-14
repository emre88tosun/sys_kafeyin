<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorChoiceStore extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'position',
        'viewCount',
    ];

    public function store()
    {
        return $this->hasOne(Store::class,'id','storeID');
    }
}
