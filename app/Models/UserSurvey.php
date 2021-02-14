<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSurvey extends Model
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
        return $this->hasMany(UserSurveyAnswer::class,'surveyID','id');
    }
}
