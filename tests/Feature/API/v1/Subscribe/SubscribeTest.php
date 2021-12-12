<?php

namespace Tests\Feature\API\v1\Subscribe;

use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_user_can_subscribe_to_a_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('subscribe', [$thread]));
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'message' => 'User Subscribed Successfully'
        ]);
    }

    public function test_user_can_unsubscribe_from_a_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('unsubscribe', [$thread]));
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'message' => 'User Unsubscribed Successfully'
        ]);
    }

    //check database for create

    //check database for delete

    public function test_notification_will_send_to_subscribes_of_a_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();
        $thread = Thread::factory()->create();

        $response = $this->postJson(route('subscribe', [$thread]));
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'message' => 'User Subscribed Successfully'
        ]);
        $answer_response = $this->postJson(route('answers.store'), [
            'content' => 'test',
            'thread_id' => $thread->id,
        ])->assertSuccessful();
        $answer_response->assertJson(['message' => 'Answer Created Successfully']);
        Notification::assertSentTo($user, NewReplySubmitted::class);
    }
}
