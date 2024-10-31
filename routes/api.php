<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchedulePlanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;


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

Route::middleware('auth:sanctum')->group(function () {
    // return $request->user();
    Route::get('/schedule_plans', [SchedulePlanController::class, 'index']);
    Route::get('/schedule_plans/history', [SchedulePlanController::class, 'history']);
    Route::get('/drivers', [DriverController::class, 'index']);
    Route::get('/schedule_plans', [SchedulePlanController::class, 'index']);
    Route::get('/manifest', [SchedulePlanController::class, 'manifest']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('login', [AuthController::class, 'login']);

 








 






