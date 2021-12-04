<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Thread;

;

class AnswerRepository
{
    public function getAllAnswers()
    {
        $answers = Answer::all();
        return $answers;
    }

    public function create($request)
    {
        Thread::find($request->thread_id)->answers()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);
    }

    public function update($answer, $request)
    {
        $answer->update([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);
    }

    public function destroy($answer)
    {
        $answer->deleteOrFail();
    }

}
