<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('see homepage', function () {
    $response = get('/');

    $response->assertOk()
        ->assertSee('Bonjour, je suis Mavrick 👋🏻');
});
