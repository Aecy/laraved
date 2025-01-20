<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('can see the post pages', function () {
    $response = get('/posts');

    $response->assertOk()
        ->assertSee('Derniers articles');
});
