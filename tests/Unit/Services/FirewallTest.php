<?php

declare(strict_types=1);

use App\Services\Firewall;

it('detects bots', function () {
    $firewall = new Firewall();

    $request = request();

    request()->server->set('User-Agent', 'Googlebot');
    request()->headers->set('User-Agent', 'Googlebot');

    expect(
        $firewall->isBot($request)
    )->toBeTrue();
});
