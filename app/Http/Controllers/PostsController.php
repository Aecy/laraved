<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\IncrementViews;
use App\Models\Post;
use Illuminate\View\View;

final class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::query()->published()
            ->latest('published_at')
            ->get();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Post $post): View
    {
        IncrementViews::dispatchUsingSession($post);

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
