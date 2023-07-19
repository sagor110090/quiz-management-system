<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassroomStudent extends Pivot
{

    protected $table = 'classroom_user';

    protected $fillable = [
        'classroom_id',
        'user_id',
    ];

}

