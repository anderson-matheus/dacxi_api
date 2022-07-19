<?php

namespace App\Clients;

use App\Dtos\CoinDto;
use App\Dtos\PriceDto;
use App\Models\Coin;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoinGeckoClient
{
    private string $apiCoinGecko;

    public function __construct()
    {
        $this->apiCoinGecko = config('client.api_coingecko');
    }

    public function fetchCoins(): array
    {
        try {
            $coins = Http::get("{$this->apiCoinGecko}/coins/list")->json();
            $coinsDto = [];
            foreach ($coins as $coin) {
                $coinDto = new CoinDto($coin['id'], $coin['symbol'], $coin['name']);
                $coinsDto[] = $coinDto;
            }
            return $coinsDto;
        } catch (Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function fetchPrice(Coin $coin): ?PriceDto
    {
        try {
            $prices = Http::get("{$this->apiCoinGecko}/coins/{$coin->external_id}/ohlc", [
                'vs_currency' => 'usd',
                'days' => 1
            ])->json();
            Log::info(json_encode($prices));
            $price = $prices[0];
            $price = new PriceDto($coin->id, $price[1], 'usd');
            return $price;
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }
}