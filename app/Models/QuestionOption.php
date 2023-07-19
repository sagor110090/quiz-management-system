<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'question_options';

    protected $fillable = ['option_name','question_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function question()
    {
        return $this->hasOne('App\Models\Question', 'id', 'question_id');
    }

}
