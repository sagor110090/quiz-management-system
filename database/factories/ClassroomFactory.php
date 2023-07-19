<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    public function definition()
    {
        return [
			'classroom_name' => $this->faker->name,
			'classroom_unique_id' => $this->faker->name,
			'teacher_id' => $this->faker->name,
        ];
    }
}
