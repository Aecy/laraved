<?php

declare(strict_types=1);

use App\ValueObjects\SpotifyValue;

it('payload array to object', function () {
    $payload = [
        'url' => 'https://open.spotify.com/track/1',
        'image' => 'https://example.com/image.jpg',
        'trackName' => 'Track Name',
        'artistName' => 'Artist Name',
        'albumName' => 'Album Name',
    ];

    $data = new SpotifyValue(...$payload);

    expect($data)->toBeInstanceOf(SpotifyValue::class);
});
