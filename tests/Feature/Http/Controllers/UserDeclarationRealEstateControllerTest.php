<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationRealEstateController;
use App\Models\DeclarationRealEstate;

$controller = UserDeclarationRealEstateController::class;
$model = DeclarationRealEstate::class;
$table = 'declaration_real_estates';

$storePayload = [
    'location' => 'Nicosia Center',
    'real_estate_type' => 'apartment',
    'area' => 85,
    'acquisition_type' => 'purchase',
    'acquisition_year' => 2020,
    'acquisition_value' => 180000,
    'current_value' => 210000,
    'rights_encumbrances' => 'None',
];

$updatePayload = array_merge($storePayload, [
    'current_value' => 225000,
]);

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
