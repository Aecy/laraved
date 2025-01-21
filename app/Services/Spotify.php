<?php

declare(strict_types=1);

namespace App\Services;

use App\ValueObjects\SpotifyValue;
use Exception;
use Illuminate\Support\Facades\Http;

final class Spotify
{
    /**
     * Get the currently playing track on Spotify.
     */
    public function getNowPlaying(): ?SpotifyValue
    {
        $endpoint = 'https://api.spotify.com/v1/me/player/currently-playing';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->getAccessToken(),
        ])->get($endpoint);

        $data = $response->json();

        if ($response->ok()) {
            return new SpotifyValue(
                url: $data['item']['external_urls']['spotify'],
                image: $data['item']['album']['images'][0]['url'],
                trackName: $data['item']['name'],
                artistName: $data['item']['artists'][0]['name'],
                albumName: $data['item']['album']['name'],
            );
        }

        return null;
    }

    /**
     * Get the Spotify access token.
     *
     * @throws Exception
     */
    private function getAccessToken(): string
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $basicAuth = base64_encode("{$clientId}:{$clientSecret}");

        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic '.$basicAuth,
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => config('services.spotify.refresh_token'),
        ]);

        if ($response->ok()) {
            $data = $response->json();

            return $data['access_token'] ?? '';
        }

        throw new Exception('Could not retrieve Spotify access token.');
    }
}
