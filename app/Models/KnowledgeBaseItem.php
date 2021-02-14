<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBaseItem extends Model
{
    protected $fillable = [
        'category',
        'title',
        'desc',
        'position',
        'isActive',
    ];
}
