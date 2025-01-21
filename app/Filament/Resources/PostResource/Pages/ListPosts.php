<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListPosts extends ListRecords
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
            Actions\CreateAction::make(),
        ];
    }
}
