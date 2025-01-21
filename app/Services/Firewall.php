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
        // TODO: Implement the logic here

        return false;
    }
}
