<footer class="mt-16 border-t border-muted pt-8 sm:mt-20 lg:mt-24" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">
        Footer
    </h2>
    <div class="pb-8">
        @if (is_null($spotify))
            <div class="flex flex-row-reverse items-center justify-between gap-2 sm:flex-row sm:justify-start">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" role="img" view-box="0 0 24 24"
                     class="size-6" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"></path>
                </svg>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                    <div class="font-semibold md:text-lg">Rien n'est écouté</div>
                    <span class="hidden md:inline-flex">—</span>
                    <p class="text-xs text-muted-foreground sm:text-sm">Spotify</p>
                </div>
            </div>
        @else
            <a
                href="{{ $spotify->url }}"
                target="_blank"
                class="select-none"
                title="En train d'écouter {{ $spotify->trackName }} par {{ $spotify->artistName }} sur Spotify"
                rel="noreferrer"
            >
                <div class="flex flex-row-reverse items-center justify-between gap-2 sm:flex-row sm:justify-start">
                    <img
                        src="{{ $spotify->image }}"
                        alt="Couverture d'album : '{{ $spotify->albumName }}' par '{{ $spotify->artistName }}'"
                        width="64"
                        height="64"
                        class="size-6 rounded border"
                    />
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                        <div class="font-semibold md:text-lg">{{ $spotify->artistName }}</div>
                        <span class="hidden md:inline-flex">—</span>
                        <p class="text-xs text-gray-500 sm:text-sm">{{ $spotify->trackName }}</p>
                    </div>
                </div>
            </a>
        @endif
        <p class="mt-4 text-left text-xs leading-5 text-muted-foreground sm:text-right">
            &copy; {{ now()->format('Y') }} Maved, EI. Tous droits réservés.
        </p>
    </div>
</footer>
