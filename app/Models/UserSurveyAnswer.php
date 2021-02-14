<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSurveyAnswer extends Model
{
    protected $fillable = [
        'surveyID',
        'userID',
        'answer',
        'additionalMessage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
