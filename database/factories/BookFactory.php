<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'authors' => [$this->faker->name],
            'number_of_pages' => $this->faker->numberBetween(100, 1000),
            'publisher' => $this->faker->company,
            'country' => $this->faker->country,
            'release_date' => $this->faker->date()
        ];
    }
}
