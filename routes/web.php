<?php

use App\Http\Controllers\Admin\Adverts\AdvertController as AdminAdvert;
use App\Http\Controllers\Admin\Adverts\AttributeController as Attribute;
use App\Http\Controllers\Admin\Adverts\CategoryController as AdvertCategory;
use App\Http\Controllers\Admin\BannerController as AdminBanner;
use App\Http\Controllers\Admin\HomeController as Admin;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RegionController as Region;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UsersController as Users;
use App\Http\Controllers\Adverts\AdvertController as AdvertAdvert;
use App\Http\Controllers\Auth\LoginController as Login;
use App\Http\Controllers\Auth\VerificationController as Verification;
use App\Http\Controllers\BannerController as Banner;
use App\Http\Controllers\Cabinet\Adverts\AdvertController as CabinetAdvert;
use App\Http\Controllers\Cabinet\Adverts\CreateController as CabinetAdvertsCreate;
use App\Http\Controllers\Cabinet\Adverts\FavoriteController as CabinetAdvertsFavorite;
use App\Http\Controllers\Cabinet\Adverts\ManageController as CabinetAdvertsManage;
use App\Http\Controllers\Cabinet\Banners\BannerController as CabinetBannerManage;
use App\Http\Controllers\Cabinet\Banners\CreateController as CabinetBannerCreate;
use App\Http\Controllers\Cabinet\FavoriteController as CabinetFavorite;
use App\Http\Controllers\Cabinet\HomeController as Cabinet;
use App\Http\Controllers\Cabinet\PhoneController as Phone;
use App\Http\Controllers\Cabinet\ProfileController as Profile;
use App\Http\Controllers\Cabinet\TicketController as CabinetTicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
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

Route::get('/banner/get', [Banner::class, 'get'])->name('banner.get');
Route::get('/banner/{banner}/click', [Banner::class, 'click'])->name('banner.click');

Route::get('/banner/get', 'BannerController@get')->name('banner.get');
Route::get('/banner/{banner}/click', 'BannerController@click')->name('banner.click');

Route::get('/login/{network}', 'Auth\NetworkController@redirect')->name('login.network');
Route::get('/login/{network}/callback', 'Auth\NetworkController@callback');


Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
    'namespace' => 'Adverts',
], function () {
    Route::get('/show/{advert}', [AdvertAdvert::class, 'show'])->name('show');
    Route::post('/show/{advert}/phone', [AdvertAdvert::class, 'phone'])->name('phone');
    Route::post('/show/{advert}/favorites', [CabinetAdvertsFavorite::class, 'add'])->name('favorites');
    Route::delete('/show/{advert}/favorites', [CabinetAdvertsFavorite::class, 'remove']);

    Route::get('/{adverts_path?}', [AdvertAdvert::class, 'index'])->name('index')->where('adverts_path', '.+');
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
            Route::post('/phone', [Phone::class, 'request']);
            Route::get('/phone', [Phone::class, 'form'])->name('phone');
            Route::put('/phone', [Phone::class, 'verify'])->name('phone.verify');
            Route::post('/phone/auth', [Phone::class, 'auth'])->name('phone.auth');
        });

        Route::get('favorites', [CabinetFavorite::class, 'index'])->name('favorites.index');
        Route::delete('favorites/{advert}', [CabinetFavorite::class, 'remove'])->name('favorites.remove');

        Route::resource('tickets', CabinetTicketController::class)->only([
            'index',
            'show',
            'create',
            'store',
            'destroy'
        ]);
        Route::post('tickets/{ticket}/message', [CabinetTicketController::class, 'message'])->name('tickets.message');

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


        Route::group([
            'prefix' => 'banners',
            'as' => 'banners.',
            'namespace' => 'Banners',
            'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', [CabinetBannerManage::class, 'index'])->name('index');
            Route::get('/create', [CabinetBannerCreate::class, 'category'])->name('create');
            Route::get('/create/region/{category}/{region?}',
                [CabinetBannerCreate::class, 'region'])->name('create.region');
            Route::get('/create/banner/{category}/{region?}',
                [CabinetBannerCreate::class, 'banner'])->name('create.banner');
            Route::post('/create/banner/{category}/{region?}',
                [CabinetBannerCreate::class, 'store'])->name('create.banner.store');

            Route::get('/show/{banner}', [CabinetBannerManage::class, 'show'])->name('show');
            Route::get('/{banner}/edit', [CabinetBannerManage::class, 'editForm'])->name('edit');
            Route::put('/{banner}/edit', [CabinetBannerManage::class, 'edit']);
            Route::get('/{banner}/file', [CabinetBannerManage::class, 'fileForm'])->name('file');
            Route::put('/{banner}/file', [CabinetBannerManage::class, 'file']);
            Route::post('/{banner}/send', [CabinetBannerManage::class, 'send'])->name('send');
            Route::post('/{banner}/cancel', [CabinetBannerManage::class, 'cancel'])->name('cancel');
            Route::post('/{banner}/order', [CabinetBannerManage::class, 'order'])->name('order');
            Route::delete('/{banner}/destroy', [CabinetBannerManage::class, 'destroy'])->name('destroy');
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


        Route::resource('pages', AdminPageController::class);

        Route::group(['prefix' => 'pages/{page}', 'as' => 'pages.'], function () {
            Route::post('/first', [AdminPageController::class, 'first'])->name('first');
            Route::post('/up', [AdminPageController::class, 'up'])->name('up');
            Route::post('/down', [AdminPageController::class, 'down'])->name('down');
            Route::post('/last', [AdminPageController::class, 'last'])->name('last');
        });

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


        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', [AdminBanner::class, 'index'])->name('index');
            Route::get('/{banner}/show', [AdminBanner::class, 'show'])->name('show');
            Route::get('/{banner}/edit', [AdminBanner::class, 'editForm'])->name('edit');
            Route::put('/{banner}/edit', [AdminBanner::class, 'edit']);
            Route::post('/{banner}/moderate', [AdminBanner::class, 'moderate'])->name('moderate');
            Route::get('/{banner}/reject', [AdminBanner::class, 'rejectForm'])->name('reject');
            Route::post('/{banner}/reject', [AdminBanner::class, 'reject']);
            Route::post('/{banner}/pay', [AdminBanner::class, 'pay'])->name('pay');
            Route::delete('/{banner}/destroy', [AdminBanner::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            Route::get('/', [AdminTicketController::class, 'index'])->name('index');
            Route::get('/{ticket}/show', [AdminTicketController::class, 'show'])->name('show');
            Route::get('/{ticket}/edit', [AdminTicketController::class, 'editForm'])->name('edit');
            Route::put('/{ticket}/edit', [AdminTicketController::class, 'edit']);
            Route::post('{ticket}/message', [AdminTicketController::class, 'message'])->name('message');
            Route::post('/{ticket}/close', [AdminTicketController::class, 'close'])->name('close');
            Route::post('/{ticket}/approve', [AdminTicketController::class, 'approve'])->name('approve');
            Route::post('/{ticket}/reopen', [AdminTicketController::class, 'reopen'])->name('reopen');
            Route::delete('/{ticket}/destroy', [AdminTicketController::class, 'destroy'])->name('destroy');
        });
    }
);

Route::get('/{page_path}', [PageController::class, 'show'])->name('page')->where('page_path', '.+');
