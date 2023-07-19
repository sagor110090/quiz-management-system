<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
			'question' => $this->faker->name,
			'quiz_id' => $this->faker->name,
        ];
    }
}
