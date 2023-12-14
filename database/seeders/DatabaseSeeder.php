<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Role;
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
        // \App\Models\User::factory(1)->create();
        User::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@test.com',
            'role' => Role::PIMPINAN,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'role' => Role::ADMIN,
            'password' => Hash::make('password')
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@test.com',
            'role' => Role::KASIR,
            'password' => Hash::make('password')
        ]);

        \App\Models\Product::factory(10)->create();
    }
}
