<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::prefix('posts')
    ->as('posts.')
    ->group(static function (): void {
        Route::get('/', [PostsController::class, 'index'])->name('index');
        Route::get('/{post:slug}', [PostsController::class, 'show'])->name('show');
    });
