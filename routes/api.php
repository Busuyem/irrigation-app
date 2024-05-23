<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WateringEventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('zones', ZoneController::class);

Route::prefix('zones/{zone}/schedules')->group(function () {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::post('/', [ScheduleController::class, 'store']);
    Route::get('{schedule}', [ScheduleController::class, 'show']);
    Route::put('{schedule}', [ScheduleController::class, 'update']);
    Route::delete('{schedule}', [ScheduleController::class, 'destroy']);
});

Route::prefix('zones/{zone}/watering-events')->group(function () {
    Route::post('start', [WateringEventController::class, 'start']);
    Route::post('stop', [WateringEventController::class, 'stop']);
    Route::get('status', [WateringEventController::class, 'status']);
});

