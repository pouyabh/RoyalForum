<?php

namespace App\Http\Controllers\API\v01\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Thread;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function getAllChannelList()
    {
        return response()->json(Channel::all(), 200);
    }

    public function createNewChannel(Request $request)
    {
        // Validate Inputs
        $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        //Insert Channel into Database
        resolve(ChannelRepository::class);

        //return Response
        return response()->json(['message' => 'Channel Created Successfully'], 201);
    }


}
