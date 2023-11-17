<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\UseCases\FindDailyQuoteUseCase;

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

