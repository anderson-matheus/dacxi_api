<?php

namespace App\Repositories;

use App\Dtos\CoinDto;
use App\Models\Coin;
use Illuminate\Database\Eloquent\Collection;

class CoinRepository
{
    private Coin $coin;

    public function __construct(Coin $coin = null)
    {
        $this->coin = $coin ?? new Coin();
    }

    public function upsert(CoinDto $coinDto): Coin
    {
        $coin = $this->coin::updateOrCreate(
            $coinDto->mapToUpdateOrCreate(),
            $coinDto->mapToUpdateOrCreate(),
        );
        return $coin;
    }

    public function fetchCoins(array $filters): Collection
    {
        $query = $this->coin;
        if (data_get($filters, 'symbols')) {
            $query = $query->whereIn('symbol', $filters['symbols']);
        }
        $coins = $query->where('active', 1)->get();
        return $coins;
    }

    public function activeBySymbol(string $symbol): ?Coin
    {
        $coin = $this->coin::where('symbol', $symbol)->first();
        $coin->active = 1;
        $coin->save();
        return $coin;
    }
}