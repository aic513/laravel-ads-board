<?php

use App\Http\Controllers\Admin\HomeController as Admin;
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

Route::get('/cabinet', [Cabinet::class, 'index'])->name('cabinet');

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
//        'namespace' => 'Admin',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', [Admin::class, 'index'])->name('home');
        Route::resource('users', Users::class);
    }
);

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('register.verify');
