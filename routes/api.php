<?php


use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Channel\ChannelController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth Routes
    include __DIR__ . '\API\v1\auth_api.php';

    // Channel Routes
    include __DIR__ . '\API\v1\channel_api.php';

});
