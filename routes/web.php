<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;

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

Route::get('{any}', fn() => view('app'))
    ->where('any', '^(?!OneSignalSDKWorker.js|manifest.json).*$');

Route::middleware('cache.headers:public;max_age=7200')
    ->get(
        'manifest.json',
        fn() => response()->json([
            "name" => "Chiefly Quotes",
            "short_name" => "Chiefly Quotes",
            "description" => "Daily quotes from Chiefly.",
            "icons" => [
                [
                    "src" => asset("logo.ico"),
                    "type" => "image/png",
                    "sizes" => "192x192"
                ],
                [
                    "src" => asset("logo.ico"),
                    "type" => "image/png",
                    "sizes" => "512x512"
                ]
            ],
            "start_url" => "/",
            "display" => "standalone",
            "theme_color" => "#000000"
        ])
    );

Route::post('register', [UserController::class, 'store']);

Route::get('quote', [QuoteController::class, 'index']);
