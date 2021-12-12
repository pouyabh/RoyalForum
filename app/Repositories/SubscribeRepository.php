<?php

namespace App\Repositories;

use App\Models\Subscribe;

class SubscribeRepository
{
    public function getNotifiableUsers($thread_id)
    {
        return Subscribe::where('thread_id', $thread_id)->pluck('user_id')->all();
    }
}
