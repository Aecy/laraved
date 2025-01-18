<?php

declare(strict_types=1);

namespace App\Filament\Resources\CompetenceResource\Pages;

use App\Filament\Resources\CompetenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditCompetence extends EditRecord
{
    protected static string $resource = CompetenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
