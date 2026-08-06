<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationDeposit;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationDeposit>
 */
class DeclarationDepositFactory extends Factory
{
    protected $model = DeclarationDeposit::class;

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
            'name' => fake()->randomElement(['Bank of FakeBank Savings Account', 'OtherFakeBank Fixed Deposit', 'TestBank Current Account']),
            'account_number' => fake()->iban('CY'),
            'value' => fake()->numberBetween(1000, 100000),
        ];
    }
}
