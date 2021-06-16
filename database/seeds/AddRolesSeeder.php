<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AddRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['id' => 1,'name' => 'admin']);
        Role::create(['id' => 2, 'name' => 'moderator']);
        Role::create(['id' => 3,'name' => 'teacher']);
        Role::create(['id' => 4,'name' => 'advisor']);
        Role::create(['id' => 5,'name' => 'student']);
    }
}
