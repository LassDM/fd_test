<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DriversController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'auth_api'], function(){
    Route::get('/cars', [CarsController::class, 'index']);
    Route::get('/cars/{id}', [CarsController::class, 'show']);
    Route::post('/bookCar', [CarsController::class, 'bookCar']);
    // Route::get('/getCar', 'CarController@show');
    // Route::get('/getDriver', 'DriverController@show');
});
// Route::middleware('auth_api')->get('/getEmptyCar', [CarController::class, 'getEmptyCar']);
