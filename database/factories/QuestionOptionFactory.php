<?php

namespace Database\Factories;

use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionOptionFactory extends Factory
{
    protected $model = QuestionOption::class;

    public function definition()
    {
        return [
			'option_name' => $this->faker->name,
			'question_id' => $this->faker->name,
        ];
    }
}
