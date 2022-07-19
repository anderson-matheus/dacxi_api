<?php

namespace App\Services;

use App\Clients\CoinGeckoClient;
use App\Repositories\CoinRepository;
use App\Repositories\PriceRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class CoinService
{
    private $coinGeckoClient, $coinRepository, $priceRepository;

    public function __construct(
        CoinGeckoClient $coinGeckoClient = null,
        CoinRepository $coinRepository = null,
        PriceRepository $priceRepository = null) {
        $this->coinGeckoClient = $coinGeckoClient ?? new CoinGeckoClient();
        $this->coinRepository = $coinRepository ?? new CoinRepository();
        $this->priceRepository = $priceRepository ?? new PriceRepository();
    }

    public function upsertAllCoins(): void
    {
        $coinsDto = $this->coinGeckoClient->fetchCoins();
        foreach ($coinsDto as $coinDto) {
            $coin = $this->coinRepository->upsert($coinDto);
            Log::info("Upserted with success {$coin}");
        }
    }

    public function storeCoinsPrice(array $symbols = []): void
    {
        try {
            $coins = $this->coinRepository->fetchCoins(['symbols' => $symbols]);
            foreach ($coins as $coin) {
                $priceDto = $this->coinGeckoClient->fetchPrice($coin);
                if (is_null($priceDto)) {
                    continue;
                }
                $this->priceRepository->store($priceDto);
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}