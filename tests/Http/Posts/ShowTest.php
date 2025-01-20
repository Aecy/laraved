<?php

declare(strict_types=1);

use App\Models\Post;

use function Pest\Laravel\get;

it('can see single post', function () {
    $post = Post::factory()->create();

    $response = get('/posts/'.$post->slug);

    $response->assertOk()
        ->assertSee($post->title);
});
