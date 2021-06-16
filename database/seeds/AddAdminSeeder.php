<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->fill([
            'name' => 'Admin',
            'email' => 'amindiyass0101@gmail.com',
            'phone' => '87777777777',
            'debt' => 0,
            'password' => \Illuminate\Support\Facades\Hash::make('62Amin1999001'),
        ]);
        $user->save();

        $user->assignRole('admin');


    }
}
