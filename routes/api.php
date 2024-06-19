<?php

use App\Http\Controllers\V1JobController;
use App\Http\Middleware\ClientVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// create routes for jobs
Route::prefix('v1')->middleware(ClientVerification::class)->group(function () {
    Route::post('/post/job', [V1JobController::class, 'postJob']);
    Route::post('/update/job', [V1JobController::class, 'updateJob']);
    Route::post('/update/job/status', [V1JobController::class, 'updateJobStatus']);
    Route::post('/delete/job', [V1JobController::class, 'deleteJob']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
