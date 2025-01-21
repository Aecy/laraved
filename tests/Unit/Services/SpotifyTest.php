<?php

declare(strict_types=1);

use App\Services\Spotify;
use App\ValueObjects\SpotifyValue;
use Illuminate\Support\Facades\Http;

it('returns currently playing track when Spotify API responds successfully', function () {
    Http::fake([
        'https://api.spotify.com/v1/me/player/currently-playing' => Http::response([
            'item' => [
                'external_urls' => [
                    'spotify' => 'https://open.spotify.com/track/example',
                ],
                'album' => [
                    'images' => [
                        ['url' => 'https://example.com/image.jpg'],
                    ],
                    'name' => 'Test Album',
                ],
                'name' => 'Test Track',
                'artists' => [
                    ['name' => 'Test Artist'],
                ],
            ],
        ]),
        'https://accounts.spotify.com/api/token' => Http::response([
            'access_token' => 'test_access_token',
        ]),
    ]);

    $spotify = new Spotify();
    $nowPlaying = $spotify->getNowPlaying();

    expect($nowPlaying)->toBeInstanceOf(SpotifyValue::class)
        ->and($nowPlaying->url)->toBe('https://open.spotify.com/track/example')
        ->and($nowPlaying->image)->toBe('https://example.com/image.jpg')
        ->and($nowPlaying->trackName)->toBe('Test Track')
        ->and($nowPlaying->artistName)->toBe('Test Artist')
        ->and($nowPlaying->albumName)->toBe('Test Album');
});

it('throws an exception when access token cannot be retrieved', function () {
    Http::fake([
        'https://accounts.spotify.com/api/token' => Http::response([], 400),
    ]);

    $spotify = new Spotify();

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Could not retrieve Spotify access token.');

    $spotify->getNowPlaying();
});
