<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Ionic\VisitController;

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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('user', [UserController::class, 'getUser']);

});

Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);

Route::get('visits', [VisitController::class, 'index']);
Route::post('visits', [VisitController::class, 'store']);
Route::get('visits/{id}', [VisitController::class, 'show']);
Route::put('visits/{id}', [VisitController::class, 'update']);
Route::delete('visits/{id}', [VisitController::class, 'destroy']);

