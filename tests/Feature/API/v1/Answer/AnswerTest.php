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
        $response = $this->getJson(route('answers.index'))->assertSuccessful();
    }

    public function test_create_answer_should_be_validated()
    {
        $response = $this->postJson(route('answers.store'), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    public function test_submit_answer_for_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store'), [
            'content' => $this->faker->word,
            'thread_id' => $thread->id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    public function test_update_answer_should_be_validated()
    {
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update', [$answer]), []);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    public function test_can_update_own_answer_for_thread()
    {
        $answer = Answer::factory()->create();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->putJson(route('answers.update', [$answer]), [
            'content' => $this->faker->word,
            'thread_id' => Thread::factory()->create()->id,
        ]);
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function can_delete_own_answer()
    {
        Sanctum::actingAs(User::factory()->create());
        $answer = Answer::factory()->create();
        $response = $this->deleteJson(route('answers.destroy',[$answer]));
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }
}
