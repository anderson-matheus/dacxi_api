<?php

namespace Tests\Feature;

use App\Models\Coin;
use App\Models\Price;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CoinPriceControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testFetchLatestCoinPrice()
    {
        $coin = Coin::factory()->create();
        $price = Price::factory()->create(['coin_id' => $coin->id]);

        $response = $this->get(route('api.coins.prices.latest', ['symbol' => $coin->symbol]));
        $data = $response->json();

        $this->assertEquals($data['coin']['name'], $coin->name);
        $this->assertEquals($data['coin']['symbol'], $coin->symbol);
        $this->assertEquals($data['coin']['external_id'], $coin->external_id);
        $this->assertEquals($data['coin']['active'], $coin->active);

        $this->assertEquals($data['price']['coin_id'], $price->coin_id);
        $this->assertEquals($data['price']['price'], $price->price);
        $this->assertEquals($data['price']['currency'], $price->currency);
    }

    public function testFetchHistoryCoinPrice()
    {
        $coin = Coin::factory()->create();
        $price = Price::factory()->create(['coin_id' => $coin->id]);

        $response = $this->get(route('api.coins.prices.history', ['symbol' => $coin->symbol]));
        $data = $response->json();

        $this->assertEquals($data['coin']['name'], $coin->name);
        $this->assertEquals($data['coin']['symbol'], $coin->symbol);
        $this->assertEquals($data['coin']['external_id'], $coin->external_id);
        $this->assertEquals($data['coin']['active'], $coin->active);

        $this->assertEquals($data['history']['data'][0]['coin_id'], $price->coin_id);
        $this->assertEquals($data['history']['data'][0]['price'], $price->price);
        $this->assertEquals($data['history']['data'][0]['currency'], $price->currency);
    }

    public function testWatchCoinPrice()
    {
        $coin = Coin::factory()->create(['active' => 0]);

        $this->assertEquals($coin->active, 0);

        $response = $this->get(route('api.coins.prices.watch', ['symbol' => $coin->symbol]));
        $data = $response->json();

        $this->assertEquals($data['coin']['name'], $coin->name);
        $this->assertEquals($data['coin']['symbol'], $coin->symbol);
        $this->assertEquals($data['coin']['external_id'], $coin->external_id);
        $this->assertEquals($data['coin']['active'], 1);
    }
}
