<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FoodController;
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

Route::post('/users/authenticate', AuthController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('foods', FoodController::class);
});
