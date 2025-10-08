<?php

use App\Models\Declaration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

it('cannot fetch data as a guest', function () {
    $response = $this->getJson('api/user/declarations');

    $response->assertStatus(401);
});

it('can fetch all declarations', function () {
    $user = User::factory()->create();
    $declaration = Declaration::factory()->create(['user_id' => $user->id]);
    $declaration2 = Declaration::factory()->create(['user_id' => $user->id]);
    $response = $this->actingAs($user)
                     ->getJson('api/user/declarations');

    $response->assertStatus(200);
    $response->assertJson([$declaration->toArray(), $declaration2->toArray()]);
});
