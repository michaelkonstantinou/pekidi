<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Declaration;
use App\Models\DeclarationAdditionalAsset;
use App\Models\DeclarationBusiness;
use App\Models\DeclarationDebt;
use App\Models\DeclarationDeposit;
use App\Models\DeclarationFamilyMember;
use App\Models\DeclarationInvestment;
use App\Models\DeclarationRealEstate;
use App\Models\DeclarationVehicle;
use App\Models\User;

test('copy duplicates declaration and all relationship records correctly', function () {
    $user = User::factory()->create();

    /** @var Declaration $original */
    $original = Declaration::factory()->create([
        'user_id' => $user->id,
        'name' => '2024 Asset Declaration',
    ]);

    // Populate all relations
    DeclarationFamilyMember::factory()->count(2)->create(['declaration_id' => $original->id]);
    DeclarationRealEstate::factory()->count(2)->create(['declaration_id' => $original->id]);
    DeclarationVehicle::factory()->count(1)->create(['declaration_id' => $original->id]);
    DeclarationBusiness::factory()->count(1)->create(['declaration_id' => $original->id]);
    DeclarationInvestment::factory()->count(2)->create(['declaration_id' => $original->id]);
    DeclarationDeposit::factory()->count(3)->create(['declaration_id' => $original->id]);
    DeclarationAdditionalAsset::factory()->count(1)->create(['declaration_id' => $original->id]);
    DeclarationDebt::factory()->count(2)->create(['declaration_id' => $original->id]);

    $copy = $original->copy();

    // Verify main declaration properties
    expect($copy->id)->not->toBe($original->id)
        ->and($copy->name)->toBe('2024 Asset Declaration (copy)')
        ->and($copy->user_id)->toBe($user->id)
        ->and($copy->familyMembers()->count())->toBe(2)
        ->and($copy->realEstates()->count())->toBe(2)
        ->and($copy->vehicles()->count())->toBe(1)
        ->and($copy->businesses()->count())->toBe(1)
        ->and($copy->investments()->count())->toBe(2)
        ->and($copy->deposits()->count())->toBe(3)
        ->and($copy->additionalAssets()->count())->toBe(1)
        ->and($copy->debts()->count())->toBe(2);

    // Assert total DB records doubled across all relationship tables
    $this->assertDatabaseCount('declarations', 2);
    $this->assertDatabaseCount('declaration_family_members', 4);
    $this->assertDatabaseCount('declaration_real_estates', 4);
    $this->assertDatabaseCount('declaration_vehicles', 2);
    $this->assertDatabaseCount('declaration_businesses', 2);
    $this->assertDatabaseCount('declaration_investments', 4);
    $this->assertDatabaseCount('declaration_deposits', 6);
    $this->assertDatabaseCount('declaration_additional_assets', 2);
    $this->assertDatabaseCount('declaration_debts', 4);
});
