<?php

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

Route::group(
    [
        'namespace' => 'Auth',
    ],
    function () {
        Route::post('/login', 'LoginController@login')->name('login');
        Route::post('/register', 'RegisterController@register')->name('register');
        Route::post('/email/verify', 'VerificationController@verify')->name('verification.verify');
    }
);

Route::middleware('jwt-auth')->get('/users', function (Request $request) {
    return response()->json(['ok' => 'users list']);
});
