<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

final readonly class Firewall
{
    /**
     * Determine if the request is from a bot.
     */
    public function isBot(Request $request): bool
    {
        $bots = ['Google-PageRenderer', 'Googlebot', 'bot', 'crawler', 'spider', 'Yandex', 'BingPreview'];
        $userAgent = $request->userAgent();

        return str()->contains(
            str($userAgent)->lower(),
            array_map('strtolower', $bots)
        );
    }
}
