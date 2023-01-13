<?php

use App\Http\Controllers\Admin\Adverts\AdvertController as AdminAdvert;
use App\Http\Controllers\Admin\Adverts\AttributeController as Attribute;
use App\Http\Controllers\Admin\Adverts\CategoryController as AdvertCategory;
use App\Http\Controllers\Admin\HomeController as Admin;
use App\Http\Controllers\Admin\RegionController as Region;
use App\Http\Controllers\Admin\UsersController as Users;
use App\Http\Controllers\Adverts\AdvertController as AdvertAdvert;
use App\Http\Controllers\Auth\LoginController as Login;
use App\Http\Controllers\Auth\VerificationController as Verification;
use App\Http\Controllers\Cabinet\AdvertController as CabinetAdvert;
use App\Http\Controllers\Cabinet\Adverts\CreateController as CabinetAdvertsCreate;
use App\Http\Controllers\Cabinet\Adverts\ManageController as CabinetAdvertsManage;
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

Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
//    'namespace' => 'Adverts',
], function () {
    Route::get('/show/{advert}', [AdvertAdvert::class, 'show'])->name('show');
    Route::post('/show/{advert}/phone', [AdvertAdvert::class, 'phone'])->name('phone');

    Route::get('/all/{category?}', [AdvertAdvert::class, 'index'])->name('index.all');
    Route::get('/{region?}/{category?}', [AdvertAdvert::class, 'index'])->name('index');
});

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
        });

        Route::group([
            'prefix' => 'adverts',
            'as' => 'adverts.',
            'namespace' => 'Adverts',
            'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', [CabinetAdvert::class, 'index'])->name('index');
            Route::get('/create', [CabinetAdvertsCreate::class, 'category'])->name('create');
            Route::get('/create/region/{category}/{region?}',
                [CabinetAdvertsCreate::class, 'region'])->name('create.region');
            Route::get('/create/advert/{category}/{region?}',
                [CabinetAdvertsCreate::class, 'advert'])->name('create.advert');
            Route::post('/create/advert/{category}/{region?}',
                [CabinetAdvertsCreate::class, 'store'])->name('create.advert.store');

            Route::get('/{advert}/edit', [CabinetAdvertsManage::class, 'editForm'])->name('edit');
            Route::put('/{advert}/edit', [CabinetAdvertsManage::class, 'edit']);
            Route::get('/{advert}/photos', [CabinetAdvertsManage::class, 'photosForm'])->name('photos');
            Route::post('/{advert}/photos', [CabinetAdvertsManage::class, 'photos']);
            Route::get('/{advert}/attributes', [CabinetAdvertsManage::class, 'attributesForm'])->name('attributes');
            Route::post('/{advert}/attributes', [CabinetAdvertsManage::class, 'attributes']);
            Route::post('/{advert}/send', [CabinetAdvertsManage::class, 'send'])->name('send');
            Route::post('/{advert}/close', [CabinetAdvertsManage::class, 'close'])->name('close');
            Route::delete('/{advert}/destroy', [CabinetAdvertsManage::class, 'destroy'])->name('destroy');
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

            Route::group(
                [
                    'prefix' => 'adverts',
                    'as' => 'adverts.'
                ], function () {
                Route::get('/', [AdminAdvert::class, 'index'])->name('index');
                Route::get('/{advert}/edit', [AdminAdvert::class, 'editForm'])->name('edit');
                Route::put('/{advert}/edit', [AdminAdvert::class, 'edit']);
                Route::get('/{advert}/photos', [AdminAdvert::class, 'photosForm'])->name('photos');
                Route::post('/{advert}/photos', [AdminAdvert::class, 'photos']);
                Route::get('/{advert}/attributes', [AdminAdvert::class, 'attributesForm'])->name('attributes');
                Route::post('/{advert}/attributes', [AdminAdvert::class, 'attributes']);
                Route::post('/{advert}/moderate', [AdminAdvert::class, 'moderate'])->name('moderate');
                Route::get('/{advert}/reject', [AdminAdvert::class, 'rejectForm'])->name('reject');
                Route::post('/{advert}/reject', [AdminAdvert::class, 'reject']);
                Route::delete('/{advert}/destroy', [AdminAdvert::class, 'destroy'])->name('destroy');
            });
        });
    }
);