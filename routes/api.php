<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}/update', [UserController::class, 'update']);
        Route::delete('users/{user}/delete', [UserController::class, 'destroy']);
    });

    //no admin users
    Route::get('rutas', function(){
        return !( Auth::user()->is_admin == 1);
    });
});

Route::get('guestTest', function(){
    return 'guest';
});
