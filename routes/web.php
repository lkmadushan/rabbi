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

Route::middleware('cache.headers:public;max_age=7200')
    ->get(
        'manifest.json',
        fn() => response()->json([
            "name" => "Rabbi Sacks",
            "short_name" => "Rabbi Sacks",
            "description" => "Your Daily Quote",
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

Route::get('OneSignalSDKWorker.js', fn () => response()->file(base_path('OneSignalSDKWorker.js'), [
    'Content-Type' => 'text/javascript',
    'Cache-Control' => 'public, max-age=3600',
]));

Route::post('register', [UserController::class, 'store']);

Route::get('quote', [QuoteController::class, 'index']);

Route::get('{any}', fn() => view('app'))->where('any', '.*');
