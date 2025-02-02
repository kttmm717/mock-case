<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'shipping_zipcode' => $this->faker->postcode(),
            'shipping_address' => $this->faker->address(),
            'shipping_building' => $this->faker->secondaryAddress(),
            'payment_method' => $this->faker->randomElement(['card', 'konbini'])
        ];
    }
}
