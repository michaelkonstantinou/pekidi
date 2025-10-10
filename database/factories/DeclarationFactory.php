<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Declaration>
 */
class DeclarationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->domainName(),
            'full_name' => fake()->name(),
            'home_address' => fake()->address(),
            'profession' => fake()->jobTitle(),
            'national_id' => fake()->randomNumber(6),
            'user_id' => 1
        ];
    }
}
