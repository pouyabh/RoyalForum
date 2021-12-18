<?php

namespace Tests\Feature\API\v1\Answer;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_answers()
    {
        $response = $this->get(route('answers.index'));

        $response->assertSuccessful();
    }

    public function test_create_answer_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    public function test_submit_answer_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store'), [
            'content' => $this->faker->word,
            'thread_id' => $thread->id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    public function test_user_score_will_increase_by_submit_new_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store'), [
            'content' => $this->faker->word,
            'thread_id' => $thread->id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $this->assertEquals(10, $user->score);
    }

    public function test_update_answer_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update', [$answer]), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    public function test_can_update_own_answer_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->putJson(route('answers.update', $answer), [
            'content' => $this->faker->word,
            'thread_id' => Thread::factory()->create()->id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function can_delete_own_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->deleteJson(route('answers.destroy', $answer));
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }
}
