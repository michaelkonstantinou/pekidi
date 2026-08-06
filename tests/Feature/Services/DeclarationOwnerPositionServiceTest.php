<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Models\Declaration;
use App\Models\DeclarationDebt;
use App\Models\DeclarationInvestment;
use App\Models\DeclarationRealEstate;
use App\Models\User;
use App\Services\DeclarationOwnerPositionService;
use App\Types\OwnerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

test('it creates a new investment position for an authorized user', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $request = new FormRequest();
    $request->merge([
        'name' => 'Apple Inc. Shares',
        'quantity' => 10,
        'value' => 150,
    ]);

    $service = new DeclarationOwnerPositionService($declaration);
    $response = $service->create($request, OwnerType::Self, DeclarationInvestment::class);

    expect($response->getStatusCode())->toBe(JsonResponse::HTTP_OK);
    $this->assertDatabaseHas('declaration_investments', [
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self->value,
        'name' => 'Apple Inc. Shares',
    ]);
});

test('it denies creation if the user does not own the declaration', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($otherUser);

    $request = new FormRequest();
    $request->merge([
        'location' => 'Nicosia',
        'real_estate_type' => 'apartment',
        'area' => 100,
        'acquisition_type' => 'purchase',
        'acquisition_year' => 2020,
        'acquisition_value' => 150000,
        'current_value' => 180000,
        'rights_encumbrances' => 'None',
    ]);

    $service = new DeclarationOwnerPositionService($declaration);
    $response = $service->create($request, OwnerType::Self, DeclarationRealEstate::class);

    expect($response->getStatusCode())->toBe(JsonResponse::HTTP_UNAUTHORIZED);
    $this->assertDatabaseEmpty('declaration_real_estates');
});

test('it updates an existing real estate position when authorized', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $realEstate = DeclarationRealEstate::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self,
        'current_value' => 200000,
    ]);

    $this->actingAs($user);

    $request = new FormRequest();
    $request->merge([
        'current_value' => 250000,
    ]);

    $service = new DeclarationOwnerPositionService($declaration);
    $response = $service->update($request, OwnerType::Self, $realEstate);

    expect($response->getStatusCode())->toBe(JsonResponse::HTTP_OK);
    $this->assertDatabaseHas('declaration_real_estates', [
        'id' => $realEstate->id,
        'current_value' => 250000,
    ]);
});

test('it prevents updating when there is an owner mismatch', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    // Record is owned by Spouse
    $debt = DeclarationDebt::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Spouse,
    ]);

    $this->actingAs($user);

    $request = new FormRequest();
    $request->merge(['value' => 5000]);

    $service = new DeclarationOwnerPositionService($declaration);
    // Attempting to update as Self
    $response = $service->update($request, OwnerType::Self, $debt);

    expect($response->getStatusCode())->toBe(JsonResponse::HTTP_UNAUTHORIZED);
});

test('it deletes a debt position successfully when valid', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $debt = DeclarationDebt::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self,
    ]);

    $this->actingAs($user);

    $service = new DeclarationOwnerPositionService($declaration);
    $response = $service->destroy(OwnerType::Self, $debt);

    expect($response->getStatusCode())->toBe(JsonResponse::HTTP_OK);
    $this->assertDatabaseMissing('declaration_debts', [
        'id' => $debt->id,
    ]);
});
