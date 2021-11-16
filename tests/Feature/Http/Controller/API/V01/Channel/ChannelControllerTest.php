<?php

namespace Tests\Feature\Http\Controller\API\V01\Channel;


use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_all_channel_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));

        $response->assertStatus(Response::HTTP_OK);
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
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update_should_be_validated()
    {
        $channel = Channel::factory()->create();
        $response = $this->putJson(route('channel.update', $channel), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $channel = Channel::factory()->create();
        $response = $this->json('PUT', route('channel.update', $channel->id), [
            'name' => $channel->name,
            'slug' => $channel->slug,
        ]);

        $updatedChannel = Channel::find($channel->id);

        $this->assertEquals($channel->name, $updatedChannel->name);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_channel_delete_should_be_validated()
    {
        $channel = Channel::factory()->create();
        $response = $this->deleteJson(route('channel.delete', $channel->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $channel = Channel::factory()->create();
        $response = $this->json('DELETE', route('channel.delete', $channel->id), [
            'id' => $channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
