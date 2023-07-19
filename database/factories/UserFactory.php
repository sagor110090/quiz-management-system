<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
			'name' => $this->faker->name,
			'email' => $this->faker->email,
			'image' => $this->faker->name,
            'password' => $this->faker->password
        ];
    }
}
