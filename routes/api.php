<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

//pagina de error Unauthorised
Route::get('403', function () {
    return response()->json([
        'success' => false,
        'code' => 403,
        'message' => 'unautorized'
    ]);
})->name('error403');

Route::middleware(['auth:sanctum'])->group(function () {

    //admin users
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'is_admin',
        'as' => 'admin.'
    ], function () {
        //users
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}/update', [UserController::class, 'update']);
        Route::delete('users/{user}/delete', [UserController::class, 'destroy']);
        Route::put('users/{user}/assignMaster', [UserController::class, 'assignAdmin']);

        //roles
        Route::get('roles', [RoleController::class, 'index'])->middleware('role:guess');
        Route::post('roles', [RoleController::class, 'store']);
        Route::get('roles/{role}', [RoleController::class, 'show']);
        Route::put('roles/{role}/update', [RoleController::class, 'update']);
        Route::delete('roles/{role}/delete', [RoleController::class, 'destroy']);
        Route::post('roles/{user}/assingRole', [RoleController::class, 'assingRole']);

        //settings
        Route::get('settings/{setting}', [SettingController::class, 'show']);
        Route::put('settings/{setting}/update', [SettingController::class, 'update']);
        Route::delete('settings/{setting}/delete', [SettingController::class, 'destroy']);
    });

    //no admin users
    Route::get('rutas', function(){
        return 'ok';
    });

});

Route::get('guestTest', function(){
    return 'guest';
});
