<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_name' => $this->faker->word(),
            'image' => 'https://via.placeholder.com/200',
            'price' => $this->faker->numberBetween(100,10000),
            'is_sold' => $this->faker->boolean(),
            'favorite' => $this->faker->numberBetween(0,50),
            'item_description' => $this->faker->realText(20),
            'category_ids' => Category::inRandomOrder()->take(rand(1,3))->pluck('id')->toArray(),
            'condition_id' => Condition::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
