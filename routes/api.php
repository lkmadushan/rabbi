<?php

use App\UseCases\FindDailyQuoteUseCase;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('quote',function () {
    return app(FindDailyQuoteUseCase::class)->execute(Carbon::now());
});

Route::post('register',[UserController::class,'store']);

