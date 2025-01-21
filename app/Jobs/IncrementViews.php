<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Post;
use App\Services\Firewall;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class IncrementViews implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  Collection<array-key, Post>  $viewables
     */
    public function __construct(
        private Collection $viewables,
        private int|string $id,
    ) {
        //
    }

    /**
     * Dispatch the job using the session.
     *
     * @param  Collection<array-key, Post>|Post  $viewables
     */
    public static function dispatchUsingSession(Collection|Post $viewables): ?PendingDispatch
    {
        if (app(Firewall::class)->isBot(request())) {
            return null;
        }

        $id = auth()->id() ?? session()->getId();

        /** @var Collection<array-key, Post> $viewables */
        $viewables = $viewables instanceof Model ? collect([$viewables]) : $viewables;

        return self::dispatch($viewables, $id);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->viewables->isEmpty()) {
            return;
        }

        $key = "viewed.{$this->getModelName()}.for.user.{$this->id}";
        $lock = Cache::lock($key);

        $recentlyViewed = collect();

        try {
            $lock->block(5);

            $recentlyViewed = $this->getRecentlyViewed($key);
        } catch (LockTimeoutException) { // @codeCoverageIgnore
            $this->release(10); // @codeCoverageIgnore
        } finally {
            $lock->release();
        }

        if ($recentlyViewed->isNotEmpty()) {
            /** @var Post $model */
            $model = $recentlyViewed->first();

            /** @var array<int, int> $ids */
            $ids = $recentlyViewed->pluck('id')->toArray();

            $model::incrementViews($ids);
        }
    }

    /**
     * Get the model name.
     */
    public function getModelName(): string
    {
        if ($this->viewables->isEmpty()) {
            return '';
        }

        $model = $this->viewables->first();

        return mb_strtolower(class_basename($model));
    }

    /**
     * Get the recently viewed items.
     *
     * @return Collection<array-key, Post> $key
     */
    private function getRecentlyViewed(string $key): Collection
    {
        /** @var array<int, int> $viewed */
        $viewed = Cache::get($key, []);

        $recentlyViewed = $this->viewables
            ->reject(fn (Model $model): bool => in_array($model->id, $viewed, true))
            ->values();

        Cache::put($key, array_unique(array_merge(
            $viewed,
            $recentlyViewed->pluck('id')->toArray(),
        )), now()->addMinutes(120));

        return $recentlyViewed;
    }
}
