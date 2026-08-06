<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationInvestmentController;
use App\Models\DeclarationInvestment;

$controller = UserDeclarationInvestmentController::class;
$model = DeclarationInvestment::class;
$table = 'declaration_investments';

$storePayload = [
    'name' => 'MyTest ETF',
    'quantity' => 100,
    'value' => 450,
];

$updatePayload = array_merge($storePayload, [
    'quantity' => 120,
    'value' => 480,
]);

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
