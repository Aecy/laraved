<?php

declare(strict_types=1);

use App\Models\Competence;

test('to array', function () {
    $competence = Competence::factory()->create()->fresh();

    expect(array_keys($competence->toArray()))->toBe([
        'id',
        'name',
        'image',
        'url',
        'created_at',
        'updated_at',
    ]);
});
