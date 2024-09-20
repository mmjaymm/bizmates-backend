<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PlacesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-places', [PlacesController::class, 'getPlaces']);
Route::get('/get-places/{id}', [PlacesController::class, 'getDetails']);
Route::get('/get-places/photos/{id}', [PlacesController::class, 'getPhotoByPlaces']);
Route::get('/get-weather', [WeatherController::class, 'getWeather']);
