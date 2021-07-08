<?php

use App\Http\Controllers\Api\RealStateController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->namespace('Api')->group(function(){

    Route::prefix('real-states')->group(function(){

        Route::get('/',[RealStateController::class, 'index'])->name('index'); //api/v1/real-states/

        Route::post('/',[RealStateController::class, 'store']); //api/v1/real-states/

        Route::put('/{id}',[RealStateController::class, 'update']); //api/v1/real-states/{id}


    });

});
