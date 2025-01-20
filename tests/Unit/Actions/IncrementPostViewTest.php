<?php

declare(strict_types=1);

use App\Actions\IncrementPostView;
use App\Models\Post;

test('increment post view', function () {
    $post = Post::factory()->create([
        'views' => 1,
    ]);

    $incrementPostView = new IncrementPostView();
    $incrementPostView->execute($post);

    $this->assertEquals(2, $post->views);
});
