<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin admin',
            'email' => 'admin@gmail.com',
            'is_admin' => true,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'user user',
            'email' => 'user@gmail.com',
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);
    }
}
