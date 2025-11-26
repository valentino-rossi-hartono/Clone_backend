<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/event', [EventController::class, 'index']);
    Route::post('/event/create', [EventController::class, 'store']);
    Route::post('/event/update/{id}', [EventController::class, 'update']);
    Route::delete('/event/delete/{id}', [EventController::class, 'destroy']);
    Route::get('/event/{id}', [EventController::class, 'show']);

    Route::post('/logout', [UserController::class, 'logout']);
});