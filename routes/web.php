<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use App\UseCases\FindDailyQuoteUseCase;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('register', [UserController::class, 'store']);

Route::get('quote', [QuoteController::class, 'index']);

Route::get('{any}', function () {
    return view('app');
})->where('any','.*');
