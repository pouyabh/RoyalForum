<?php

namespace App\Http\Controllers\API\v1\Answer;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AnswerController extends Controller
{
    public function index(): JsonResponse
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();
        return response()->json($answers, ResponseAlias::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'content' => ['required'],
            'thread_id' => ['required'],
        ]);
        resolve(AnswerRepository::class)->create($request);
        return response()->json(['message' => 'Answer Created Successfully'], ResponseAlias::HTTP_CREATED);
    }

    public function update(Answer $answer, Request $request): JsonResponse
    {
        $request->validate([
            'content' => ['required'],
            'thread_id' => ['required'],
        ]);
        if (Gate::forUser(auth()->user())->allows('user-answer', $answer)) {
            resolve(AnswerRepository::class)->update($answer, $request);
            return response()->json(['message' => 'Answer Updated Successfully'], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Access Denied'
            ], ResponseAlias::HTTP_FORBIDDEN);
        }
    }

    public function destroy(Answer $answer): JsonResponse
    {
        if (Gate::forUser(auth()->user())->allows('user-answer', $answer)) {
            resolve(AnswerRepository::class)->destroy($answer);
            return response()->json(['message' => 'Answer Deleted Successfully'], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Access Denied'
            ], ResponseAlias::HTTP_FORBIDDEN);
        }
    }
}
