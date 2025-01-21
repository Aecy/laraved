<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Services\Spotify;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

final class Footer extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $spotify = Cache::remember(
            'spotify',
            300,
            fn () => app(Spotify::class)->getNowPlaying()
        );

        return view('components.footer', [
            'spotify' => $spotify,
        ]);
    }
}
