<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\Carbon;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at'
    ]);
});

test('is verified', function () {
    $user = User::factory()->create();

    expect($user->email_verified_at)->not->toBeNull();
});

test('is unverified', function () {
    $user = User::factory()->unverified()->create();

    expect($user->email_verified_at)->toBeNull();
});
