<?php

namespace Database\Factories;

use App\Models\Auther;
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
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(),
            'auther_id' => Auther::inRandomOrder()->first()?->id ?? Auther::factory(),
            'genre' => $this->faker->randomElement(['fiction','non-fiction','sci-fi','fantasy']),
            'published_at' => $this->faker->date(),
            'total_copies' => $this->faker->numberBetween(1,50),
            'available_copies' => $this->faker->numberBetween(0.50),
            'price' => $this->faker->randomFloat(2,50,200),
            'cover_image'=> $this->faker->imageUrl(200,300,'books',true,'Book Cover'),
            'status' => $this->faker->randomElement(['available','unavailable']),
        ];
    }
}
