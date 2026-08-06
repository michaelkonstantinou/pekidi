<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Models\Declaration;
use App\Models\DeclarationDebt;
use App\Models\DeclarationInvestment;
use App\Models\DeclarationRealEstate;
use App\Models\User;
use App\Services\DeclarationTotalService;
use App\Types\OwnerType;

test('it accurately computes investments total value using quantity times value', function () {
    // 1. Arrange: Create a declaration with DeclarationInvestment records
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    // 10 units @ 50.00 = 500.00 (self)
    DeclarationInvestment::factory()->create([
        'declaration_id' => $declaration->id,
        'quantity' => 10,
        'value' => 50.00,
        'owner' => OwnerType::Self,
    ]);

    // 5 units @ 100.00 = 500.00 (spouse)
    DeclarationInvestment::factory()->create([
        'declaration_id' => $declaration->id,
        'quantity' => 5,
        'value' => 100.00,
        'owner' => OwnerType::Spouse,
    ]);

    // 2. Act
    $service = new DeclarationTotalService($declaration->id);
    $totals = $service->calculateTotalValues();

    // 3. Assert
    expect($totals->investments->count)->toBe(2);
    expect($totals->investments->totalValue)->toBe(1000.00); // (10 * 50) + (5 * 100)
    expect($totals->investments->selfValue)->toBe(500.00);   // (10 * 50)
    expect($totals->investments->jointValue)->toBe(1000.00); // self + spouse
});

test('it correctly filters self and joint asset ownerships across standard assets', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    // Real estate: current_value column
    DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'current_value' => 200000.00,
        'owner' => OwnerType::Self,
    ]);

    DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'current_value' => 100000.00,
        'owner' => OwnerType::Spouse,
    ]);

    DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'current_value' => 50000.00,
        'owner' => OwnerType::Child, // Should not count towards joint or self
    ]);

    $service = new DeclarationTotalService($declaration->id);
    $totals = $service->calculateTotalValues();

    expect($totals->realEstates->totalValue)->toBe(350000.00);
    expect($totals->realEstates->selfValue)->toBe(200000.00);
    expect($totals->realEstates->jointValue)->toBe(300000.00);
});

test('it correctly categorizes debts and calculates liability totals and net worth', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    // Self asset
    DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'current_value' => 150000.00,
        'owner' => OwnerType::Self,
    ]);

    // DeclarationDebt 1: Mortgage (self)
    DeclarationDebt::factory()->create([
        'declaration_id' => $declaration->id,
        'debt_type' => 'mortgage',
        'value' => 50000.00,
        'owner' => OwnerType::Self,
    ]);

    // DeclarationDebt 2: Credit Card (spouse)
    DeclarationDebt::factory()->create([
        'declaration_id' => $declaration->id,
        'debt_type' => 'credit_card',
        'value' => 5000.00,
        'owner' => OwnerType::Spouse,
    ]);

    $service = new DeclarationTotalService($declaration->id);
    $totals = $service->calculateTotalValues();

    // Check debts
    expect($totals->debts->count)->toBe(2);
    expect($totals->debts->totalValue)->toBe(55000.00);
    expect($totals->debts->selfValue)->toBe(50000.00);
    expect($totals->debts->jointValue)->toBe(55000.00);

    // Check DeclarationDebt type breakdown
    expect($totals->debts->byType['mortgage']->totalValue)->toBe(50000.00);
    expect($totals->debts->byType['credit_card']->totalValue)->toBe(5000.00);

    // Net worth check: Personal (Assets Self - Debt Self) = 150000 - 50000 = 100000
    expect($totals->netWorth->personal)->toBe(100000.00);
    // Family Net worth: 150000 - 55000 = 95000
    expect($totals->netWorth->family)->toBe(95000.00);
});

test('it calculates asset distribution chart percentages accurately', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    // 80,000 Real Estate (80%)
    DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'current_value' => 80000.00,
        'owner' => OwnerType::Self,
    ]);

    // 200 units @ 100 = 20,000 Investments (20%)
    DeclarationInvestment::factory()->create([
        'declaration_id' => $declaration->id,
        'quantity' => 200,
        'value' => 100.00,
        'owner' => OwnerType::Self,
    ]);

    $service = new DeclarationTotalService($declaration->id);
    $chartData = $service->calculateAssetDistributionChartData();

    expect($chartData['total_assets_value'])->toBe(100000.00);
    expect($chartData['series'])->toHaveCount(2);

    $realEstateChart = collect($chartData['series'])->firstWhere('relation', 'real_estates');
    $investmentChart = collect($chartData['series'])->firstWhere('relation', 'investments');

    expect($realEstateChart['percentage'])->toBe(80.00);
    expect($investmentChart['percentage'])->toBe(20.00);
});
