<?php


use App\Http\Controllers\API\v1\Subscribe\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::post('subscribe/{thread}', [SubscribeController::class, 'subscribe'])->name('subscribe');
Route::post('unsubscribe/{thread}', [SubscribeController::class, 'unsubscribe'])->name('unsubscribe');
