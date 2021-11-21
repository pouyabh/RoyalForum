<?php

use App\Http\Controllers\API\v1\Channel\ChannelController;
use Illuminate\Support\Facades\Route;

Route::prefix('channel')->group(function () {
    Route::get('all', [ChannelController::class, 'getAllChannelList'])->name('channel.all');
    Route::middleware(['can:channel management', 'auth:sanctum'])->group(function () {
        Route::post('create', [ChannelController::class, 'createNewChannel'])->name('channel.create');
        Route::put('update/{channel}', [ChannelController::class, 'updateChannel'])->name('channel.update');
        Route::delete('delete/{channel}', [ChannelController::class, 'deleteChannel'])->name('channel.delete');
    });
});
