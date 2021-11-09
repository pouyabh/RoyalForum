<?php

use App\Http\Controllers\API\v01\Auth\AuthController;
use App\Http\Controllers\API\v01\Channel\ChannelController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('user', [AuthController::class, 'user'])->name('auth.user');
    });

    // Channel Routes
    Route::prefix('channel')->group(function () {
        Route::get('all', [ChannelController::class, 'getAllChannelList'])->name('channel.all');
        Route::post('create', [ChannelController::class, 'createNewChannel'])->name('channel.create');
    });
});
