<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
			'quiz_name' => $this->faker->name,
			'per_question_mark' => rand(1, 100),
			'classroom_id' => $this->faker->name,
        ];
    }
}
