<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationRealEstate;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationRealEstate>
 */
class DeclarationRealEstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = DeclarationRealEstate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $acquisitionValue = fake()->numberBetween(50_000, 500_000);

        return [
            'declaration_id' => Declaration::factory(),
            'owner' => fake()->randomElement(OwnerType::cases()),
            'location' => fake()->city() . ', ' . fake()->streetAddress(),
            'real_estate_type' => fake()->randomElement(['apartment', 'house', 'land', 'commercial', 'plot']),
            'area' => fake()->numberBetween(40, 1000), // square meters
            'acquisition_type' => fake()->randomElement(['purchase', 'inheritance', 'gift', 'donation']),
            'acquisition_year' => fake()->numberBetween(1980, (int) date('Y')),
            'acquisition_value' => $acquisitionValue,
            'current_value' => (int) round($acquisitionValue * fake()->randomFloat(2, 0.8, 2.5)),
            'rights_encumbrances' => fake()->optional(0.4, '')->randomElement([
                'Mortgage registered with Bank of Cyprus',
                'Usufruct right reserved',
                'None',
            ]),
        ];
    }
}
