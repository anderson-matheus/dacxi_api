<?php

namespace App\Http\Controllers;

use App\Repositories\CoinRepository;
use App\Repositories\PriceRepository;
use App\Services\PriceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CoinPriceController extends Controller
{
    private CoinRepository $coinRepository;
    private PriceRepository $priceRepository;

    public function __construct(
        CoinRepository $coinRepository = null,
        PriceRepository $priceRepository = null)
    {
        $this->coinRepository = $coinRepository ?? new CoinRepository();
        $this->priceRepository = $priceRepository ?? new PriceRepository();
    }

    public function fetchLatestCoinPrice($symbol, Request $request)
    {
        try {
            $coins = $this->coinRepository->fetchCoins(['symbols' => [$symbol]]);
            $coin = $coins[0];
            $price = $this->priceRepository->getLatest($coin->id);
            return new JsonResponse(['coin' => $coin, 'price' => $price]);
        } catch (Exception $e) {
            Log::error($e);
            return new JsonResponse([], 400);
        }
    }

    public function fetchHistoryCoinPrice($symbol, Request $request)
    {
        try {
            $coins = $this->coinRepository->fetchCoins(['symbols' => [$symbol]]);
            $coin = $coins[0];
            $prices = $this->priceRepository->fetch(['coin_id' => $coin->id]);
            return new JsonResponse(['coin' => $coin, 'history' => $prices]);
        } catch (Exception $e) {
            Log::error($e);
            return new JsonResponse([], 400);
        }
    }

    public function watchCoinPrice($symbol, Request $request)
    {
        try {
            $coin = $this->coinRepository->activeBySymbol($symbol);
            return new JsonResponse(['coin' => $coin]);
        } catch (Exception $e) {
            Log::error($e);
            return new JsonResponse([], 400);
        }
    }
}
