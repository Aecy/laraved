<?php

declare(strict_types=1);

namespace App\ValueObjects;

final readonly class SpotifyValue
{
    /**
     * Create a new Spotify value object.
     */
    public function __construct(
        public string $url,
        public string $image,
        public string $trackName,
        public string $artistName,
        public string $albumName,
    ) {}
}
