<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Models\Viewable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Post extends Model implements Viewable
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

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
     * @param  Builder<$this>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', now());
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
