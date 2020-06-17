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
    ['namespace' => 'Auth'],
    function () {
        Route::post('/login', 'AuthController@login')->name('login');
        Route::post('/register', 'AuthController@register')->name('register');
        // Route::post('/email/verify', 'VerificationController@verify')->name('verification.verify');
    }
);

Route::group(
    [
        'namespace' => 'Backend',
        'prefix' => 'admin',
        'middleware' => 'auth:api'
    ],
    function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('posts', 'PostController');
        Route::apiResource('users', 'UserController');
    }
);
