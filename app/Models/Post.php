<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /**
     * @param  Builder<$this>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', now());
    }

    /**
     * Increment the views for the given post IDs.
     */
    public static function incrementViews(array $ids): void
    {
        self::withoutTimestamps(function () use ($ids): void {
            self::query()
                ->whereIn('id', $ids)
                ->increment('views');
        });
    }

    /**
     * @return array<string,mixed>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'tags' => 'array',
        ];
    }
}
