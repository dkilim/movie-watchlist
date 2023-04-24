<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->name;
        return [
            'title' => $title,
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl,
            'rating' => $this->faker->numberBetween(1,10),
            'slug' => Str::slug($title,'-')
        ];
    }
}
