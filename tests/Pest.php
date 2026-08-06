<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use App\Models\Declaration;
use App\Models\User;
use App\Types\OwnerType;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\JsonResponse;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function assertIndexReturnsOwnerPositions(string $controllerClass, string $modelClass): void
{
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $modelClass::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self,
    ]);

    $modelClass::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Spouse,
    ]);

    $url = action([$controllerClass, 'index'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
    ]);

    $response = test()->actingAs($user)->getJson($url);

    $response->assertOk();
    $response->assertJsonCount(1);
}

function assertIndexUnauthorizedForNonOwner(string $controllerClass): void
{
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $owner->id]);

    $url = action([$controllerClass, 'index'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
    ]);

    $response = test()->actingAs($otherUser)->getJson($url);

    $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
}

function assertStoreCreatesPosition(string $controllerClass, string $tableName, array $payload): void
{
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $url = action([$controllerClass, 'store'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
    ]);

    $response = test()->actingAs($user)->postJson($url, $payload);

    $response->assertOk();
    test()->assertDatabaseHas($tableName, array_merge($payload, [
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self->value,
    ]));
}

function assertStoreUnauthorizedForNonOwner(string $controllerClass, string $tableName, array $payload): void
{
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $owner->id]);

    $url = action([$controllerClass, 'store'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
    ]);

    $response = test()->actingAs($otherUser)->postJson($url, $payload);

    $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    test()->assertDatabaseEmpty($tableName);
}

function assertUpdateModifiesPosition(string $controllerClass, string $modelClass, string $tableName, array $updatePayload): void
{
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $record = $modelClass::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self,
    ]);

    $paramName = lcfirst(str_replace('Declaration', '', class_basename($modelClass)));
    $paramName = Str::snake($paramName);

    $url = action([$controllerClass, 'update'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
        $paramName => $record,
    ]);

    $response = test()->actingAs($user)->putJson($url, $updatePayload);

    $response->assertOk();
    test()->assertDatabaseHas($tableName, array_merge([
        'id' => $record->id,
    ], $updatePayload));
}

function assertDestroyDeletesPosition(string $controllerClass, string $modelClass, string $tableName): void
{
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);

    $record = $modelClass::factory()->create([
        'declaration_id' => $declaration->id,
        'owner' => OwnerType::Self,
    ]);

    $paramName = lcfirst(str_replace('Declaration', '', class_basename($modelClass)));
    $paramName = Str::snake($paramName);

    $url = action([$controllerClass, 'destroy'], [
        'declaration' => $declaration,
        'owner' => OwnerType::Self->value,
        $paramName => $record,
    ]);

    $response = test()->actingAs($user)->deleteJson($url);

    $response->assertOk();
    test()->assertDatabaseMissing($tableName, ['id' => $record->id]);
}
