<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\User\ProfileController;
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
Route::get('/', [HomeController::class, 'home']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:api')->get('/user', [ProfileController::class, 'show']);
