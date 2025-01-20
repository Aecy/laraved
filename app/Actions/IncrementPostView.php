<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Post;

final class IncrementPostView
{
    public function execute(Post $post): void
    {
        $post->increment('views');
    }
}
