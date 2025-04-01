<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a Web Master
        User::create([
            'name' => 'Web Master',
            'email' => 'webmaster@airscape.com',
            'password' => Hash::make('webmaster@airscape.com'),
            'role' => 'webmaster',
        ]);

        // Seed an Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@airscape.com',
            'password' => Hash::make('admin@airscape.com'),
            'role' => 'admin',
        ]);
    }
}
