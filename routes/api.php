<?php

use App\Http\Controllers\Api\Auth\SessionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\UserController;
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


Route::prefix('v1')->namespace('Api')->group(function () {


    Route::post('login', [SessionController::class, 'login']);
    Route::post('logout', [SessionController::class, 'logout']);
    Route::post('refresh', [SessionController::class, 'refresh']);


    Route::group(['middleware' => ['jwt.auth']], function () {

        Route::prefix('real-states')->group(function () {

            Route::get('/', [RealStateController::class, 'index']); //api/v1/real-states/

            Route::post('/', [RealStateController::class, 'store']); //api/v1/real-states/

            Route::put('/{id}', [RealStateController::class, 'update']); //api/v1/real-states/{id}

            Route::get('/{id}', [RealStateController::class, 'show']); //api/v1/real-states/{id}

            Route::delete('/{id}', [RealStateController::class, 'destroy']); //api/v1/real-states/{id}

        });

        Route::prefix('users')->group(function () {

            Route::get('/', [UserController::class, 'index']); //api/v1/users/

            Route::post('/', [UserController::class, 'store']); //api/v1/users/

            Route::put('/{id}', [UserController::class, 'update']); //api/v1/users/{id}

            Route::get('/{id}', [UserController::class, 'show']); //api/v1/users/{id}

            Route::delete('/{id}', [UserController::class, 'destroy']); //api/v1/users/{id}

        });

        Route::prefix('categories')->group(function () {

            Route::get('/{id}/real-states', [CategoryController::class, 'realStates']); //api/v1/categories/{id}/real-states

            Route::get('/', [CategoryController::class, 'index']); //api/v1/categories/

            Route::post('/', [CategoryController::class, 'store']); //api/v1/categories/

            Route::put('/{id}', [CategoryController::class, 'update']); //api/v1/categories/{id}

            Route::get('/{id}', [CategoryController::class, 'show']); //api/v1/categories/{id}

            Route::delete('/{id}', [CategoryController::class, 'destroy']); //api/v1/categories/{id}

        });
    });
});
