<?php

namespace Chiiya\FilamentAccessControl\Database\Factories;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilamentUserFactory extends Factory
{
    protected $model = FilamentUser::class;

    public function definition(): array
    {
        $values = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email' => $this->faker->email,
        ];

        if (Feature::enabled(Feature::ACCOUNT_EXPIRY)) {
            return array_merge($values, [
                'expires_at' => $this->faker->dateTimeBetween('+3 weeks', '+6 months'),
            ]);
        }

        return $values;
    }
}
