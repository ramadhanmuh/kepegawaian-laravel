<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::create([
            'name' => 'Kepegawaian',
            'description' => 'Sebuah situs untuk mengelola informasi pegawai.',
            'copyright' => 'kepegawaian 2025',
            'favicon' => 'assets/favicon/favicon.ico',
        ]);
    }
}
