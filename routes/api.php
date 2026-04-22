<?php

use App\Http\Controllers\Api\Adverts\AdvertController as ApiAdvertAdvertsController;
use App\Http\Controllers\Api\Adverts\FavoriteController as ApiAdvertsFavoriteController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\User\AdvertController as ApiUserAdvertController;
use App\Http\Controllers\Api\User\FavoriteController as ApiUserFavoriteController;
use App\Http\Controllers\Api\User\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/', [HomeController::class, 'home']);
        Route::post('/register', [RegisterController::class, 'register']);

        Route::middleware('auth:api')->group(function () {
            Route::resource('adverts', ApiAdvertAdvertsController::class)->only('index', 'show');
            Route::post('/adverts/{advert}/favorite', [ApiAdvertsFavoriteController::class, 'add']);
            Route::delete('/adverts/{advert}/favorite', [ApiAdvertsFavoriteController::class, 'remove']);

            Route::group(
                [
                    'prefix' => 'user',
                    'as' => 'user.',
                    'namespace' => 'User',
                ],
                function () {
                    Route::get('/user', [ProfileController::class, 'show']);
                    Route::put('/', [ProfileController::class, 'update']);
                    Route::get('/favorites', [ApiUserFavoriteController::class, 'index']);
                    Route::delete('/favorites/{advert}', [ApiUserFavoriteController::class, 'remove']);

                    Route::resource('adverts', ApiUserAdvertController::class)->only('index', 'show', 'update',
                        'destroy');
                    Route::post('/adverts/create/{category}/{region?}', [ApiUserAdvertController::class, 'store']);

                    Route::put('/adverts/{advert}/photos', [ApiUserAdvertController::class, 'photos']);
                    Route::put('/adverts/{advert}/attributes', [ApiUserAdvertController::class, 'attributes']);
                    Route::post('/adverts/{advert}/send', [ApiUserAdvertController::class, 'send']);
                    Route::post('/adverts/{advert}/close', [ApiUserAdvertController::class, 'send']);
                }
            );
        });
    });
