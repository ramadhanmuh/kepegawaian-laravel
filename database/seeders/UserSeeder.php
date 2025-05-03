<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rama',
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin',
            'phone' => '082298114878',
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Amar',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
            'phone' => '082298124728',
            'role' => 'admin',
        ]);
    }
}
