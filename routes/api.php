<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
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
//subscription apis
Route::get('check-google-play-status/{id}',[ApplicationController::class,"checkStatusAndroidApp"])->name('check.google');
Route::get('check-app-store-status/{id}',[ApplicationController::class,"checkStatusIOsApp"])->name('check.gooogle');
Route::post('change-status-expired/{id}',[ApplicationController::class,"changeStatusExpired"]);
//auth admin

Route::get('list-expired-sub',[AdminController::class,"listExpiredStatus"]);
//Auth route
Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth')
], function () {
    Route::post('login-admin',[AdminController::class,"login"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
