<?php

namespace App\Http\Controllers\API\v1\Client;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientController extends Controller
{
    public function userNotification(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user()->unreadnotifications(), ResponseAlias::HTTP_OK);
    }
}
