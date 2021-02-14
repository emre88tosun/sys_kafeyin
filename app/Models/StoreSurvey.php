<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSurvey extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'trueString',
        'falseString',
        'isActive',
        'type',
    ];

    public function answers()
    {
        return $this->hasMany(StoreSurveyAnswer::class,'surveyID','id');
    }
}
