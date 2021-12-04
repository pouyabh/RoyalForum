<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{

    public function definition()
    {
        return [
            'content' => $this->faker->word,
            'thread_id' => Thread::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
