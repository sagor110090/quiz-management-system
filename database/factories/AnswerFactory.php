<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
			'user_id' => $this->faker->name,
			'quiz_id' => $this->faker->name,
			'question' => $this->faker->name,
			'long_question_answer' => $this->faker->name,
			'short_question_answer' => $this->faker->name,
			'short_question_correct' => $this->faker->name,
			'mark' => $this->faker->name,
        ];
    }
}
