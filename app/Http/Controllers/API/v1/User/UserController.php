<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function leaderboards()
    {
        return resolve(UserRepository::class)->leaderboards();
    }
}
