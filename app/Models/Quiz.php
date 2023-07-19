<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'quizzes';

    protected $fillable = ['quiz_name','per_question_mark','classroom_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function classroom()
    {
        return $this->hasOne('App\Models\Classroom', 'id', 'classroom_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Question', 'quiz_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'quiz_id', 'id');
    }

     // model boot
     protected static function boot()
     {
         parent::boot();

         static::addGlobalScope('quiz', function (Builder $builder) {
             if (auth()->check()) {
                 if (Auth::user()->hasRole('teacher')) {
                         return $builder->whereHas('classroom', function ($query) {
                             $query->where('teacher_id', auth()->user()->id);
                         });

                 }

             }
         });



     }



}
