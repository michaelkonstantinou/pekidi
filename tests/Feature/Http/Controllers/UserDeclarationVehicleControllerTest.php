<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationVehicleController;
use App\Models\DeclarationVehicle;

$controller = UserDeclarationVehicleController::class;
$model = DeclarationVehicle::class;
$table = 'declaration_vehicles';

$storePayload = [
    'description' => '2022 Toyota Yaris Hybrid',
    'value' => 18000,
];

$updatePayload = [
    'description' => '2022 Toyota Yaris Hybrid',
    'value' => 16500,
];

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
