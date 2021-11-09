<?php

namespace Tests\Feature\Http\Controller\API\V01\Channel;


use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_all_channel_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));

        $response->assertStatus(200);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channel.create'), [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
        ]);
        $response->assertStatus(201);
    }

    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'), []);
        $response->assertStatus(422);
    }
}
