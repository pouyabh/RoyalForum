<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->getJson(route('threads.index'));

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_thread_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->getJson(route('threads.show', $thread->slug));

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_can_create_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('threads.store'), [
            'title' => $thread->title,
            'slug' => $thread->slug,
            'content' => $thread->content,
            'channel_id' => $thread->channel_id,
            'user_id' => $thread->user_id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertSeeText([
            'Thread Created Successfully'
        ]);

    }

    public function test_thread_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $response = $this->putJson(route('threads.update', $thread), [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraph,
            'channel_id' => Channel::factory()->create()->id,
            'user_id' => $user->id,
        ])->assertSuccessful();

        $response->assertSeeText([
            'Thread Updated Successfully'
        ]);
    }

    public function test_add_best_answer()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $response = $this->putJson(route('threads.update', $thread), [
            'best_answer_id' => 1,
        ])->assertSuccessful();
    }

    public function test_update_thread_should_validate()
    {
        $thread = Thread::factory()->create();
        $response = $this->putJson(route('threads.update', $thread), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_delete()
    {
        $thread = Thread::factory()->create();
        $response = $this->deleteJson(route('threads.destroy', $thread))->assertSuccessful();

        $response->assertSeeText('Thread Deleted Successfully');
    }


}
