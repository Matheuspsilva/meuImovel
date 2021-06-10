<?php

use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\RealStateSearchController;
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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('search',[RealStateSearchController::class, 'index']);

Route::get('search/{real_state_id}',[RealStateSearchController::class, 'show']);

Route::prefix('v1')->group(function(){

    Route::post('login', [LoginJwtController::class, 'login'])->name('login');

    Route::get('logout', [LoginJwtController::class, 'logout'])->name('logout');

    Route::get('refresh', [LoginJwtController::class, 'refresh'])->name('refresh');

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::resources([
            'real-states' => RealStateController::class,
        ]);

        Route::resources([
            'users' => UserController::class,
        ]);

        Route::resources([
            'categories' => CategoryController::class,
        ]);
        Route::get('categories/{id}/real-state', [CategoryController::class, 'realState']);

        Route::delete('photos/{id}', [RealStatePhotoController::class, 'remove'])->name('delete');

        Route::put('photos/set-thumb/{photoId}/{RealStateId}', [RealStatePhotoController::class, 'setThumb'])->name('setThumb');

    });

});
