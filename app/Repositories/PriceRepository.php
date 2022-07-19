<?php

namespace App\Repositories;

use App\Dtos\PriceDto;
use App\Models\Price;
use Illuminate\Pagination\LengthAwarePaginator;

class PriceRepository
{
    private $price;

    public function __construct(Price $price = null)
    {
        $this->price = $price ?? new Price();
    }

    public function store(PriceDto $priceDto): Price
    {
        $price = $this->price::create($priceDto->mapToStore());
        return $price;
    }

    public function getLatest(int $coinId): ?Price
    {
        $price = $this->price::where('coin_id', $coinId)->orderBy('created_at', 'desc')->first();
        return $price;
    }

    public function fetch(array $filters): ?LengthAwarePaginator
    {
        $query = $this->price;
        if (data_get($filters, 'coin_id')) {
            $query = $query->where('coin_id', $filters['coin_id']);
        }
        $prices = $query->orderBy('created_at', 'desc')->paginate(15);
        return $prices;
    }
}