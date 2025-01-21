<?php

declare(strict_types=1);

namespace App\Filament\Resources\CompetenceResource\Pages;

use App\Filament\Resources\CompetenceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCompetence extends CreateRecord
{
    /**
     * The resource that this page belongs to.
     */
    protected static string $resource = CompetenceResource::class;
}
