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

Route::group(['middleware'=>'auth_api'], function(){
    Route::get('/drivers', [DriversController::class, 'index']);
    Route::get('/drivers/{id}', [DriversController::class, 'show']);
    Route::get('/cars', [CarsController::class, 'index']);
    Route::get('/cars/{id}', [CarsController::class, 'show']);
    Route::post('/bookCar', [CarsController::class, 'bookCar']);
    Route::post('/releaseCar', [CarsController::class, 'releaseCar']);
});
