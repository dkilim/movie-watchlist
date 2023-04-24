<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Watchlist>
 */
class WatchlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()
        ];
    }

    public function configure(): WatchlistFactory
    {
        return $this->afterCreating(function (Watchlist $watchlist){
            $movies = Movie::inRandomOrder()->take(5)->get();
            $watchlist->movies()->attach($movies);
        });
    }
}
