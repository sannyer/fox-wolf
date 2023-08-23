<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/weather/{cityName}', [WeatherController::class, 'getWeatherByCity']);
Route::get('/liveweather/{cityName}', [WeatherController::class, 'getLiveWeatherByCity']);
Route::get('/schema', [WeatherController::class, 'getWeatherSchema']);
Route::get('/update', [WeatherController::class, 'updateWeatherData']);
