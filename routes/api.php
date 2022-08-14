<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1 as Api;

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

Route::group(['prefix' => 'v1'], static function () {
    // Locations statistic routes
    Route::group(['prefix' => 'location'], static function () {
        Route::get('stat-all', [Api\StatLocationController::class, 'all']);
        Route::get('stat-one/{id}', [Api\StatLocationController::class, 'one']);
    });
    // Order process routes
    Route::group(['prefix' => 'order'], static function () {
        Route::post('calc', [Api\OrderController::class, 'calc']);
        Route::post('accept', [Api\OrderController::class, 'accept']);
    });
});
