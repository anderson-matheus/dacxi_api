<?php

use App\Http\Controllers\CoinPriceController;
use Illuminate\Http\Request;
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


Route::group(['prefix' => 'coins'], function () {
    Route::group(['prefix' => 'prices'], function () {
        Route::get('latest/{symbol}', [CoinPriceController::class, 'fetchLatestCoinPrice'])->name('api.coins.prices.latest');
        Route::get('history/{symbol}', [CoinPriceController::class, 'fetchHistoryCoinPrice'])->name('api.coins.prices.history');
        Route::get('watch/{symbol}', [CoinPriceController::class, 'watchCoinPrice'])->name('api.coins.prices.watch');
    });
});
