<?php

namespace App\Http\Controllers\API\v1\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Thread;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function getAllChannelList()
    {
        // get all Channels
        $all = resolve(ChannelRepository::class)->all();
        return response()->json($all, Response::HTTP_OK);
    }

    public function createNewChannel(Request $request)
    {
        // Validate Inputs
        $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        //Insert Channel into Database
        resolve(ChannelRepository::class)->create($request->name, $request->slug);

        //return Response
        return response()->json(['message' => 'Channel Created Successfully'], Response::HTTP_CREATED);
    }

    public function updateChannel(Channel $channel, Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        // Update Channel into Database
        resolve(ChannelRepository::class)->update($channel->id, $request->name, $request->slug);

        return response()->json([
            'message' => 'Channel Edited Successfully',
        ], Response::HTTP_OK);
    }

    public function deleteChannel(Channel $channel, Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);

        resolve(ChannelRepository::class)->delete($channel->id);

        return \response()->json([
            'message' => 'Channel Deleted Successfully',
        ], Response::HTTP_OK);
    }


}
