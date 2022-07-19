<?php

namespace Tests\Unit;

use App\Models\Coin;
use App\Models\Price;
use App\Services\CoinService;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CoinServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpsertAllCoins()
    {
        $coinService = new CoinService();
        $apiUrl = config('client.api_coingecko');

        Http::fake([
            "{$apiUrl}/coins/list" => Http::response([
                ['id' => 'test_id', 'symbol' => 'test_symbol', 'name' => 'test_name'],
            ]),
        ], 200);

        $coinService->upsertAllCoins();
        $expectedCoin = new Coin();
        $expectedCoin->external_id = 'test_id';
        $expectedCoin->symbol = 'test_symbol';
        $expectedCoin->name = 'test_name';

        $coin = Coin::where('symbol', 'test_symbol')->first();
        $this->assertEquals($coin->external_id, $expectedCoin->external_id);
        $this->assertEquals($coin->symbol, $expectedCoin->symbol);
        $this->assertEquals($coin->name, $expectedCoin->name);
    }

    public function testStoreCoinsPrice()
    {
        $coinService = new CoinService();
        $apiUrl = config('client.api_coingecko');
        $coin = Coin::factory()->create();

        Http::fake([
            "{$apiUrl}/coins/{$coin->external_id}/ohlc?vs_currency=usd&days=1" => Http::response([
                [1111, 123455],
            ]),
        ]);

        $coinService->storeCoinsPrice(['symbols' => $coin->symbol]);
        $expectedPrice = new Price();
        $expectedPrice->coin_id = $coin->id;
        $expectedPrice->price = 123455;
        $expectedPrice->currency = 'usd';

        $price = Price::where('coin_id', $coin->id)->first();
        $this->assertEquals($price->coin_id, $expectedPrice->coin_id);
        $this->assertEquals($price->price, $expectedPrice->price);
        $this->assertEquals($price->currency, $expectedPrice->currency);
    }
}
