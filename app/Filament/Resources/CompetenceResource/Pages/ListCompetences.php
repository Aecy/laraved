<?php

declare(strict_types=1);

namespace App\Filament\Resources\CompetenceResource\Pages;

use App\Filament\Resources\CompetenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListCompetences extends ListRecords
{
    /**
     * The resource that this page belongs to.
     */
    protected static string $resource = CompetenceResource::class;

    /**
     * Get the actions available on the page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
