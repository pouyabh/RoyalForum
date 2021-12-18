<?php

namespace App\Http\Controllers\API\v1\Subscribe;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Thread;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SubscribeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.block']);
    }

    public function subscribe(Thread $thread): \Illuminate\Http\JsonResponse
    {
        auth()->user()->subscribes()->create([
            'thread_id' => $thread->id
        ]);
        return response()->json([
            'message' => 'User Subscribed Successfully'
        ], ResponseAlias::HTTP_OK);
    }

    public function unsubscribe(Thread $thread): \Illuminate\Http\JsonResponse
    {
        Subscribe::where([
            ['thread_id' => $thread->id],
            ['user_id' => auth()->id()],
        ])->delete();
        return response()->json([
            'message' => 'User Unsubscribed Successfully'
        ], ResponseAlias::HTTP_OK);
    }
}
