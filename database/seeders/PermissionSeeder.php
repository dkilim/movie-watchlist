<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'view_users'],
            ['name' => 'edit_users'],
            ['name' => 'add_user'],
            ['name' => 'view_roles'],
            ['name' => 'edit_roles'],
            ['name' => 'view_movie'],
            ['name' => 'edit_movie'],
            ['name' => 'add_movie']
        ]);
    }
}
