<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/tokens/create/{id}', [UserController::class, 'auth']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/list', [EventsController::class, 'list']);
    Route::get('/{id}', [EventsController::class, 'show']);
    Route::put('/{id}', [EventsController::class, 'updateAll']);
    Route::patch('/{id}', [EventsController::class, 'update']);
    Route::delete('/{id}', [EventsController::class, 'delete']);
});
