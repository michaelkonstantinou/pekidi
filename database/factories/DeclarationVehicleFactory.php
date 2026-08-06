<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Declaration;
use App\Models\DeclarationVehicle;
use App\Types\OwnerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclarationVehicle>
 */
class DeclarationVehicleFactory extends Factory
{
    protected $model = DeclarationVehicle::class;

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
            'description' => fake()->randomElement(['2021 BMW X5', '2019 Mercedes-Benz C200', '2022 Toyota Yaris Hybrid', '2018 Audi A4']),
            'value' => fake()->numberBetween(8000, 60000),
        ];
    }
}
