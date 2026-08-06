<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationDepositController;
use App\Models\DeclarationDeposit;

$controller = UserDeclarationDepositController::class;
$model = DeclarationDeposit::class;
$table = 'declaration_deposits';

$storePayload = [
    'name' => 'Bank of FakeBank Savings',
    'account_number' => 'CY123456789012345678901234',
    'value' => 25000,
];

$updatePayload = [
    'name' => 'Bank of FakeBank Savings',
    'account_number' => 'CY123456789012345678901234',
    'value' => 30000,
];

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
