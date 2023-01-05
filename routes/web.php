<?php

use App\Http\Controllers\Admin\Adverts\AttributeController as Attribute;
use App\Http\Controllers\Admin\Adverts\CategoryController as AdvertCategory;
use App\Http\Controllers\Admin\HomeController as Admin;
use App\Http\Controllers\Admin\RegionController as Region;
use App\Http\Controllers\Admin\UsersController as Users;
use App\Http\Controllers\Auth\LoginController as Login;
use App\Http\Controllers\Auth\VerificationController as Verification;
use App\Http\Controllers\Cabinet\AdvertController as Advert;
use App\Http\Controllers\Cabinet\HomeController as Cabinet;
use App\Http\Controllers\Cabinet\ProfileController as Profile;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/login/phone', [Login::class, 'phone'])->name('login.phone');
Route::post('/login/phone', [Login::class, 'verify']);

Route::get('/verify/{token}', [Verification::class, 'verify'])->name('register.verify');


Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', [Cabinet::class, 'index'])->name('home');

        Route::group(
            [
                'prefix' => 'profile',
                'as' => 'profile.'
            ], function () {
            Route::get('/', [Profile::class, 'index'])->name('home');
            Route::get('/edit', [Profile::class, 'edit'])->name('edit');
            Route::put('/update', [Profile::class, 'update'])->name('update');
            Route::post('/phone', [Profile::class, 'request']);
            Route::get('/phone', [Profile::class, 'form'])->name('phone');
            Route::put('/phone', [Profile::class, 'verify'])->name('phone.verify');
            Route::post('/phone/auth', [Profile::class, 'auth'])->name('phone.auth');
            Route::resource('adverts', Advert::class);
        });
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