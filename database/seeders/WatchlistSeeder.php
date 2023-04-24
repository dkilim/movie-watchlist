<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user)
        {
            Watchlist::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
