<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    public function create(Request $request)
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
        ]);
    }
}
