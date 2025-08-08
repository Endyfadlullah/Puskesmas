<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure single admin record with consistent credentials
        Admin::updateOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('admin123')]
        );

        // Optional additional admin (email style username)
        Admin::updateOrCreate(
            ['username' => 'admin@puskesmas.com'],
            ['password' => Hash::make('admin123')]
        );
    }
}
