<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePost extends CreateRecord
{
    /**
     * The resource that this page belongs to.
     */
    protected static string $resource = PostResource::class;
}
