<?php

namespace App\Dtos;

class PriceDto
{
    private int $coinId;
    private float $price;
    private string $currency;

    public function __construct(int $coinId, float $price, string $currency)
    {
        $this->coinId = $coinId;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function mapToStore()
    {
        return [
            'coin_id' => $this->coinId,
            'price' => $this->price,
            'currency' => $this->currency,
        ];
    }
}