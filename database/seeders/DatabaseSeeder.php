<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            [
                'email' => 'admin@mail.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('power@123'),
                'email_verified_at' => now(),
                'is_admin' => \true,
                'organization_id' => null,
            ]
        );
    }
}
