<?php

declare(strict_types=1);

arch()->preset()->php();

arch('strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('preset Laravel')->preset()->laravel()
    ->ignoring([
        'App\Providers\Filament\AdminPanelProvider',
    ]);

arch('security')
    ->preset()
    ->security()
    ->ignoring('assert');
