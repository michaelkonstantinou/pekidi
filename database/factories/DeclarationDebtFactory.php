<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationDebt;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationDebt>
 */
class DeclarationDebtFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = DeclarationDebt::class;

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
            'creditor_name' => fake()->randomElement([
                'Bank of Cyprus',
                'Hellenic Bank',
                'Eurobank Cyprus',
                'Astra Credit',
                'Tax Department of Cyprus',
            ]),
            'debt_type' => fake()->randomElement([
                'mortgage',
                'home_loan',
                'vehicle_loan',
                'business_loan',
                'student_loan',
                'credit_card',
                'tax_debt',
            ]),
            'value' => fake()->numberBetween(1_000, 250_000),
        ];
    }
}
