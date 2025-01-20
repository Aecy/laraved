<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('can render page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(PostResource::getUrl())
        ->assertSuccessful();
});

it('can be listed', function () {
    $posts = Post::factory()->count(10)->create();

    Livewire::test(ListPosts::class)
        ->assertCanSeeTableRecords($posts);
});

it('can delete', function () {
    $post = Post::factory()->create();
    $otherPost = Post::factory()->create();

    Livewire::test(ListPosts::class)
        ->callTableAction('delete', $post);

    $this->assertDatabaseCount('posts', 1);
});
