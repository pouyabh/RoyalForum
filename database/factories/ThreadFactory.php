<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraph,
            'user_id' => User::factory()->create()->id,
            'channel_id' => Channel::factory()->create()->id,
        ];
    }
}
