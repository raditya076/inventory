<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->word(),
            'category_id' => 1,
            'quantity'    => $this->faker->numberBetween(1, 100),
            'price'       => $this->faker->numberBetween(10000, 1000000),
        ];
    }
}
