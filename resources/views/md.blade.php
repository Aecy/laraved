<x-app-layout>
    <div class="mb-4 mt-16">
        <div class="flex items-center gap-4 text-sm">
            <time class="flex items-center gap-1.5 uppercase text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                17 janvier 2025
            </time>
            <span class="flex items-center gap-1.5 uppercase text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <div class="flex items-center gap-2">
                    <span class="text-muted-foreground">10 vues</span>
                </div>
            </span>
        </div>
        <h1 class="mt-2 text-4xl font-bold tracking-tight sm:text-6xl">
            Exploiter le potentiel de l'AppServiceProvider de Laravel 11
        </h1>
    </div>

    <article class="prose lg:prose-xl">
        <x-markdown>{!! $markdown !!}</x-markdown>
    </article>
</x-app-layout>
