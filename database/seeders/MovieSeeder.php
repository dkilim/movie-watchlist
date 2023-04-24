<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $movies = Movie::factory(30)->create();

        $genre = Genre::all();
        $genreIds = $genre->pluck('id')->random(3);
        $movies->each(function ($movie) use ($genreIds) {
            $movie->genres()->sync($genreIds);
        });

    }
}
