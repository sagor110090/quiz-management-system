<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'answers';

    protected $fillable = ['user_id','quiz_id','question','long_question_answer','short_question_answer','short_question_correct','mark','missing_word'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quiz()
    {
        return $this->hasOne('App\Models\Quiz', 'id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
