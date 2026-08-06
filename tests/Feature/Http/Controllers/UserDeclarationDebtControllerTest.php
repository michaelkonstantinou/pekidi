<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserDeclarationDebtController;
use App\Models\DeclarationDebt;

$controller = UserDeclarationDebtController::class;
$model = DeclarationDebt::class;
$table = 'declaration_debts';

$storePayload = [
    'creditor_name' => 'Bank of Cyprus',
    'debt_type' => 'mortgage',
    'value' => 150000,
];

$updatePayload = array_merge($storePayload, [
    'value' => 142000,
]);

test('index returns positions for owner when authorized', fn () => assertIndexReturnsOwnerPositions($controller, $model));

test('index returns unauthorized for non-owner', fn () => assertIndexUnauthorizedForNonOwner($controller));

test('store creates position when authorized', fn () => assertStoreCreatesPosition($controller, $table, $storePayload));

test('store returns unauthorized for non-owner', fn () => assertStoreUnauthorizedForNonOwner($controller, $table, $storePayload));

test('update modifies position when authorized', fn () => assertUpdateModifiesPosition($controller, $model, $table, $updatePayload));

test('destroy deletes position when authorized', fn () => assertDestroyDeletesPosition($controller, $model, $table));
