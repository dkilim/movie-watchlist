<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = Role::factory()->create([
            'name' => 'Admin'
        ]);

       $editor = Role::factory()->create([
            'name' => 'Editor'
        ]);

       $viewer = Role::factory()->create([
            'name' => 'Viewer'
        ]);

       $permission = Permission::all();

       $admin->permissions()->attach($permission->pluck('id'));

       $editor->permissions()->attach($permission->pluck('id'));
       $editor->permissions()->detach(5);

       $viewer->permissions()->attach([1,4,6,]);
    }
}
