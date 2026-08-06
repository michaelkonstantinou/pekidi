<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationInvestment;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<DeclarationInvestment>
 */
class DeclarationInvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = DeclarationInvestment::class;

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
            'name' => fake()->company() . ' ' . fake()->randomElement(['Shares', 'Bonds', 'Equity', 'Funds']),
            'registration_number' => fake()->optional(0.7)->bothify('CY-#####-??'),
            'country' => fake()->optional(0.8)->countryCode(),
            'quantity' => fake()->numberBetween(1, 1000),
            'acquisition_type' => fake()->optional(0.7)->randomElement(['purchase', 'inheritance', 'gift', 'grant']),
            'acquisition_year' => fake()->optional(0.9)->numberBetween(1990, (int) date('Y')),
            'value' => fake()->numberBetween(10, 5000),
        ];
    }
}
