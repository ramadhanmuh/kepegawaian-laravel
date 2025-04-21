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
            'email' => 'rama@gmail.com',
            'password' => 'rama',
            'phone' => '082298114878',
            'role' => 'super_admin',
        ]);
    }
}
