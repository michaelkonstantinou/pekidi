<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationFamilyMember;
use App\Types\RelationshipType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationFamilyMember>
 */
class DeclarationFamilyMemberFactory extends Factory
{
    protected $model = DeclarationFamilyMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'declaration_id' => Declaration::factory(),
            'full_name' => fake()->name(),
            'national_id' => fake()->bothify('CY######'),
            'profession' => fake()->jobTitle(),
            'born_at' => fake()->date(),
            'relationship' => fake()->randomElement(RelationshipType::cases()),
        ];
    }
}
