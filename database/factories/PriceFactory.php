<?php

namespace Database\Factories;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    public function definition()
    {
        return [
            'coin_id' => Coin::factory(), 
            'price' => $this->faker->numberBetween(10, 1000), 
            'currency' => 'usd'
        ];
    }
}
