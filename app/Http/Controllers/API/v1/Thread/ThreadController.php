<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.block'])
            ->except([
                'index',
                'show',
            ]);
    }

    public function index(): JsonResponse
    {
        $threads = resolve(ThreadRepository::class)->getAvailableThreads();

        return response()->json($threads, ResponseAlias::HTTP_OK);
    }

    public function show($slug): JsonResponse
    {
        $thread = resolve(ThreadRepository::class)->getThreadBySlug($slug);
        return response()->json($thread, ResponseAlias::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'content' => ['required'],
            'channel_id' => ['required'],
        ]);
        resolve(ThreadRepository::class)->store($request);
        return response()->json(['message' => 'Thread Created Successfully'], ResponseAlias::HTTP_CREATED);
    }

    public function update(Thread $thread, Request $request): JsonResponse
    {
        if ($request->has('best_answer_id')) {
            $request->validate([
                'best_answer_id' => ['required']
            ]);
        } else {
            $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required',
                'channel_id' => 'required'
            ]);
        }
        if (Gate::forUser(auth()->user())->allows('user-thread', $thread)) {
            resolve(ThreadRepository::class)->edit($thread, $request);
            return response()->json([
                'message' => 'Thread Updated Successfully'
            ], ResponseAlias::HTTP_OK);
        }
        return response()->json([
            'message' => 'Access Denied'
        ], ResponseAlias::HTTP_FORBIDDEN);


    }

    public function destroy(Thread $thread, Request $request): JsonResponse
    {
        if (Gate::forUser(auth()->user())->allows('user-thread', $thread)) {
            resolve(ThreadRepository::class)->destroy($thread);

            return response()->json([
                'message' => 'Thread Deleted Successfully'
            ], ResponseAlias::HTTP_OK);
        }
        return response()->json([
            'message' => 'Access Denied'
        ], ResponseAlias::HTTP_FORBIDDEN);


    }
}
