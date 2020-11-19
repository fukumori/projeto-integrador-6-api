<?php

namespace Database\Factories;

class ProductFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'lista_id' => \App\Models\Lista::factory(),
            'quantity' => $this->faker->randomNumber(2),
            'value' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
