<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationAdditionalAssetController;
use App\Models\DeclarationAdditionalAsset;

$controller = UserDeclarationAdditionalAssetController::class;
$model = DeclarationAdditionalAsset::class;
$table = 'declaration_additional_assets';

$storePayload = [
    'name' => 'Luxury Watch Collection',
    'asset_type' => 'Jewelry & Watches',
    'registration_number' => 'REG-9876-CY',
    'acquisition_type' => 'Purchase',
    'acquisition_year' => 2021,
    'value' => 35000,
];

$updatePayload = [
    'name' => 'Luxury Watch Collection',
    'asset_type' => 'Jewelry & Watches',
    'registration_number' => 'REG-9876-CY',
    'acquisition_type' => 'Purchase',
    'acquisition_year' => 2025,
    'value' => 40000,
];

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
