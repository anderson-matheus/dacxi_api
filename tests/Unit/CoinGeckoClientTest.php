<?php

namespace Tests\Unit;

use App\Clients\CoinGeckoClient;
use App\Dtos\CoinDto;
use App\Dtos\PriceDto;
use App\Models\Coin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CoinGeckoClientTest extends TestCase
{
    use DatabaseTransactions;

    public function testFetchCoins()
    {
        $coinGeckoClient = new CoinGeckoClient();
        $apiUrl = config('client.api_coingecko');

        Http::fake([
            "{$apiUrl}/coins/list" => Http::response([
                ['id' => 'test_id', 'symbol' => 'test_symbol', 'name' => 'test_name'],
            ]),
        ], 200);

        $coins = $coinGeckoClient->fetchCoins();
        $expectedCoins = [new CoinDto('test_id', 'test_symbol', 'test_name')];
        $this->assertEquals($coins, $expectedCoins);
    }

    public function testFetchPrice()
    {
        $coin = Coin::factory()->create();

        $coinGeckoClient = new CoinGeckoClient();
        $apiUrl = config('client.api_coingecko');
        Http::fake([
            "{$apiUrl}/coins/{$coin->external_id}/ohlc?vs_currency=usd&days=1" => Http::response([
                [1111, 123455],
            ]),
        ]);

        $price = $coinGeckoClient->fetchPrice($coin);
        $expectedPrice = new PriceDto($coin->id, 123455, 'usd');
        $this->assertEquals($price, $expectedPrice);
    }
}
