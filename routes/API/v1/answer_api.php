<?php


use App\Http\Controllers\API\v1\Answer\AnswerController;
use Illuminate\Support\Facades\Route;

Route::resource('answers', AnswerController::class);
