<?php


use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth Routes
    include __DIR__ . '\API\v1\auth_api.php';

    // Channel Routes
    include __DIR__ . '\API\v1\channel_api.php';

    // Thread Routes
    include __DIR__ . '\API\v1\thread_api.php';

    // Answer Routes
    include __DIR__ . '\API\v1\answer_api.php';

});
