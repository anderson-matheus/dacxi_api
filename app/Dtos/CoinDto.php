<?php

namespace App\Dtos;

class CoinDto
{
    private string $externalId;
    private string $symbol;
    private string $name;

    public function __construct(string $externalId, string $symbol, string $name)
    {
        $this->externalId = $externalId;
        $this->symbol = $symbol;
        $this->name = $name;
    }

    public function mapToUpdateOrCreate(): array
    {
        return [
            'external_id' => $this->externalId,
            'symbol' => $this->symbol,
            'name' => $this->name,
        ];
    }
}