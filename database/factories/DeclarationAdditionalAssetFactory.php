<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationAdditionalAsset;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationAdditionalAsset>
 */
class DeclarationAdditionalAssetFactory extends Factory
{
    protected $model = DeclarationAdditionalAsset::class;

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
            'name' => fake()->randomElement(['SomeWatchCompany Submariner', 'SomeArtwork Collection', 'Gold Bullion', 'Yacht']),
            'asset_type' => fake()->randomElement(['Watch', 'Art', 'Precious Metal', 'Vessel']),
            'registration_number' => fake()->bothify('REG-####-??'),
            'acquisition_type' => fake()->randomElement(['Purchase', 'Inheritance', 'Gift']),
            'acquisition_year' => fake()->numberBetween(2010, 2026),
            'value' => fake()->numberBetween(2000, 150000),
        ];
    }
}
