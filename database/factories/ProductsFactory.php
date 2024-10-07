<?php

namespace Database\Factories;
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    

    public function definition()
    {
        return [
            // Create Dummy Data
            'name' => $this->faker->words(3, true), // Generate a random name with 3 words
            'price' => $this->faker->randomFloat(2, 100, 1000), // Random price between 100 and 10000 with 2 decimal places
            'image' => $this->faker->imageUrl(640, 480, 'products', true), // Random product image URL (640x480)
        ];
    }
    
}
