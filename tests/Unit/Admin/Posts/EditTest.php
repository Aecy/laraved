<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('can render page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(PostResource::getUrl('edit', [
            'record' => Post::factory()->create(),
        ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $post = Post::factory()->create();

    Livewire::test(EditPost::class, [
        'record' => $post->getRouteKey(),
    ])->assertFormSet([
        'title' => $post->title,
        'slug' => $post->slug,
        'short_description' => $post->short_description,
        'content' => $post->content,
        'tags' => $post->tags,
        'views' => $post->views,
        'published_at' => $post->published_at,
    ]);
});

it('can save', function () {
    $post = Post::factory()->create();
    $newPost = Post::factory()->make();

    Livewire::test(EditPost::class, [
        'record' => $post->getRouteKey(),
    ])
        ->fillForm([
            'title' => $newPost->title,
            'slug' => $newPost->slug,
            'short_description' => $newPost->short_description,
            'content' => $newPost->content,
            'tags' => $newPost->tags,
            'views' => $newPost->views,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($post->refresh())
        ->title->toBe($newPost->title)
        ->slug->toBe($newPost->slug)
        ->short_description->toBe($newPost->short_description)
        ->content->toBe($newPost->content)
        ->tags->toBe($newPost->tags)
        ->views->toBe($newPost->views);
});
