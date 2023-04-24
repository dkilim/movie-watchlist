<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        User::factory()->create([
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'role_id' => '1'
        ]);

        User::factory()->create([
            'firstName' => 'Editor',
            'lastName' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@editor.com',
            'role_id' => '2'
        ]);

        User::factory()->create([
            'firstName' => 'Viewer',
            'lastName' => 'Viewer',
            'username' => 'viewer',
            'email' => 'viewer@viewer.com',
            'role_id' => '3'
        ]);

    }
}
