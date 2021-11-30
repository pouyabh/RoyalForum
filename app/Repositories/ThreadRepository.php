<?php

namespace App\Repositories;

use App\Models\Thread;
use Illuminate\Support\Facades\Auth;


class ThreadRepository
{
    public function getAvailableThreads()
    {
        $threads = Thread::whereFlag(1)->latest()->get();
        return $threads;
    }

    public function getThreadBySlug($slug)
    {
        $thread = Thread::whereFlag($slug)->first();
        return $thread;
    }

    public function store($request)
    {
        Thread::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'channel_id' => $request->channel_id,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function edit($thread, $request)
    {
        if ($request->has('best_answer_id')) {
            $thread->update([
                'best_answer_id' => $request->best_answer_id
            ]);
        }else{
            $thread->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'channel_id' => $request->channel_id,
            ]);
        }
    }

    public function destroy($thread)
    {
        $thread->deleteOrFail();
    }
}
