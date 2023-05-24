<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Organization;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // TODO: no refatoring, separar em seeders individuais

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

        Question::updateOrCreate(
            [
                'id' => '98b5c111-2c24-4c2b-89c5-68c666bcc44d',
            ],
            [
                ...Question::factory()->withoutOrganization()
                ->makeOne()
                ->only([
                    'default_title',
                    'title_langs',
                    'questions',
                ]),
                ...[
                    'id' => '98b5c111-2c24-4c2b-89c5-68c666bcc44d',
                ]
            ]
        );

        Organization::updateOrCreate(
            [
                'org_ref' => 'cliente01',
            ],
            [
                ...Organization::factory()
                    ->makeOne()
                    ->only([
                        'org_ref',
                        'owner_id',
                    ]),
                ...[
                    'org_ref' => 'cliente01',
                    'name' => 'Cliente 01',
                ]
            ]
        );
    }
}
