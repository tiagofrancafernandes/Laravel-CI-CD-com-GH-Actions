<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'organization_id' => function (array $attributes) {
                $organization = Organization::whereOrgRef('cliente01')->first();

                if ($organization) {
                    return $organization->id;
                }

                return Organization::factory([
                    'org_ref' => 'cliente01',
                    'owner_id' => User::first()?->id ?? User::factory()->withoutOrganization()->createOne()?->id,
                ])->createOne()?->id;
            },
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Without organization
     */
    public function withoutOrganization(): static
    {
        return $this->state(fn (array $attributes) => [
            'organization_id' => null,
        ]);
    }

    /**
     * Indicate that the model's user is an admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }
}
