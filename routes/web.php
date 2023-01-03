<?php

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

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('register.verify');
