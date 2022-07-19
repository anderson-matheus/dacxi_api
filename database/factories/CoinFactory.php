<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CoinFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->name;
        return [
            'name' => $name, 
            'symbol' => Str::slug($name, '-'),
            'external_id' => Str::slug($this->faker->name, '-'),
            'active' => 1,
        ];
    }
}
