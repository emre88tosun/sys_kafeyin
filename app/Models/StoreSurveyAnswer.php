<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSurveyAnswer extends Model
{
    protected $fillable = [
        'surveyID',
        'brandID',
        'answer',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brandID','id');
    }
}
