<?php

use App\Http\Controllers\Admin\Adverts\AttributeController as Attribute;
use App\Http\Controllers\Admin\Adverts\CategoryController as AdvertCategory;
use App\Http\Controllers\Admin\HomeController as Admin;
use App\Http\Controllers\Admin\RegionController as Region;
use App\Http\Controllers\Admin\UsersController as Users;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Cabinet\HomeController as Cabinet;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', [Cabinet::class, 'index'])->name('home');
    }
);

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {
        Route::get('/', [Admin::class, 'index'])->name('home');
        Route::resource('users', Users::class);
        Route::post('/users/{user}/verify', [Users::class, 'verify'])->name('users.verify');
        Route::resource('regions', Region::class);
        Route::group(
            [
                'prefix' => 'adverts',
                'as' => 'adverts.',
            ], function () {
            Route::resource('categories', AdvertCategory::class);

            Route::group(
                [
                    'prefix' => 'categories/{category}',
                    'as' => 'categories.'
                ], function () {
                Route::post('/first', [AdvertCategory::class, 'first'])->name('first');
                Route::post('/up', [AdvertCategory::class, 'up'])->name('up');
                Route::post('/down', [AdvertCategory::class, 'down'])->name('down');
                Route::post('/last', [AdvertCategory::class, 'last'])->name('last');
                Route::resource('attributes', Attribute::class)->except('index');
            });
        });
    }
);

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('register.verify');
