<?php

use App\Http\Controllers\Api\V1\Admin\TokenController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('tokens', [TokenController::class, 'store']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::delete('tokens', [TokenController::class, 'destroy']);

        });
    });
});
