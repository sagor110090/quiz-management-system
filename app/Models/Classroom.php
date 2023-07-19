<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Classroom extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'classrooms';

    protected $fillable = ['classroom_name','classroom_unique_id','teacher_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes()
    {
        return $this->hasMany('App\Models\Quiz', 'classroom_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teacher()
    {
        return $this->hasOne('App\Models\User', 'id', 'teacher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\User')->using('App\Models\ClassroomStudent');
    }

    // model boot
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('classStudent', function (Builder $builder) {
            if (auth()->check()) {
                if (Auth::user()->hasRole('student')) {
                        return $builder->whereHas('students', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });

                }
                if (Auth::user()->hasRole('teacher')) {
                    return $builder->where('teacher_id', auth()->user()->id);
                }
            }
        });



    }


}
