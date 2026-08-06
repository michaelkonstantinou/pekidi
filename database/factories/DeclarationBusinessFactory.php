<?php

namespace Database\Factories;

use App\Models\Declaration;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeclarationBusiness>
 */
class DeclarationBusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'declaration_id' => Declaration::factory(),
            'owner' => fake()->randomElement(OwnerType::cases()),
            'name' => fake()->company(),
            'business_type' => fake()->randomElement(['LLC', 'Private Limited Company', 'Sole Proprietorship', 'Partnership']),
            'involvement_type' => fake()->randomElement(['Shareholder', 'Director', 'Managing Partner', 'Sole Owner']),
            'value' => fake()->numberBetween(5000, 500000),
        ];
    }
}
