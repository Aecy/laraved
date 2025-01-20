<x-app-layout>
    <div class="mb-4 mt-16">
        <div class="flex items-center gap-4 text-sm">
            <time class="flex items-center gap-1.5 uppercase text-muted-foreground">
                <x-heroicon-o-calendar class="size-5" />
                {{ $post->published_at->format('d F Y') }}
            </time>
            <div class="flex items-center gap-1.5 uppercase text-muted-foreground">
                <x-heroicon-o-eye class="size-5" />
                <div class="flex items-center gap-2">
                    <span class="text-muted-foreground">{{ $post->views }} vues</span>
                </div>
            </div>
        </div>
        <h1 class="mt-2 text-4xl font-bold tracking-tight sm:text-6xl">
            {{ $post->title }}
        </h1>
    </div>

    <article class="prose lg:prose-xl">
        <x-markdown>{!! $post->content !!}</x-markdown>
    </article>
</x-app-layout>
