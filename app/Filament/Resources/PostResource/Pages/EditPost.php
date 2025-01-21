<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPost extends EditRecord
{
    /**
     * The resource that this page belongs to.
     */
    protected static string $resource = PostResource::class;

    /**
     * Get the actions available on the page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
