<x-app-layout>
    <div>
        <h2 class="scroll-m-20 text-xl font-semibold tracking-tight transition-colors md:text-2xl lg:text-3xl">
            {{ __('Derniers articles') }}
        </h2>
        <ul class="flex flex-col gap-4 mt-7">
            @foreach ($posts as $post)
            <li>
                <a class="group flex items-center gap-3 rounded-lg border border-black/15 p-4 transition-colors duration-300 ease-in-out hover:bg-black/5 dark:border-white/20 hover:dark:bg-white/10" href="{{ route('posts.show', $post->slug) }}">
                    <div class="w-full group-hover:text-black group-hover:dark:text-white">
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="text-sm uppercase text-muted-foreground">
                                {{ $post->published_at->format('d F Y') }}
                            </div>
                        </div>
                        <div class="mt-3 font-semibold">{{ $post->title }}</div>
                        <div class="line-clamp-2 text-sm text-muted-foreground">{{ $post->short_description }}</div>
                        <ul class="mt-2 flex flex-wrap gap-1">
                            @foreach ($post->tags as $tag)
                                <li class="rounded bg-black/5 px-1 py-0.5 text-xs uppercase text-black/75 dark:bg-white/20 dark:text-white/75">{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <x-arrow/>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
