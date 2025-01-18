<?php

declare(strict_types=1);

arch('preset PHP')->preset()->php();

arch('strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('preset Laravel')->preset()->laravel()
    ->ignoring([
        'App\Providers\Filament\AdminPanelProvider',
        'App\Filament\Resources\CompetenceResource\Pages\CreateCompetence',
    ]);

arch('preset Security')
    ->preset()
    ->security()
    ->ignoring('assert');
