<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationBusinessController;
use App\Models\DeclarationBusiness;

$controller = UserDeclarationBusinessController::class;
$model = DeclarationBusiness::class;
$table = 'declaration_businesses';

$storePayload = [
    'name' => 'Acme Cyprus Ltd',
    'business_type' => 'LLC',
    'involvement_type' => 'Shareholder',
    'value' => 50000,
];

$updatePayload = [
    'name' => 'Acme Cyprus Ltd',
    'business_type' => 'LLC',
    'involvement_type' => 'Shareholder',
    'value' => 75000,
];

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
