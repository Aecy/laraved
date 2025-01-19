<x-app-layout>
    <div>
        <h2 class="scroll-m-20 text-xl font-semibold tracking-tight transition-colors md:text-2xl lg:text-3xl">Bonjour, je suis Mavrick 👋🏻</h2>
        <article class="prose mt-4 text-muted-foreground">
            <p>Développeur web php full-stack passionné et créatif en <a href="https://maps.app.goo.gl/5cQuWGw2cTU1VwTj8" class="text-primary underline decoration-muted decoration-2 underline-offset-4 transition hover:decoration-primary" target="_blank" rel="noreferrer">France</a>. Je conçois des applications web attrayantes, performantes et intuitives, avec une attention particulière aux détails. Toujours curieux et motivé, je m'efforce de perfectionner mes compétences tout en livrant des solutions innovantes.</p><p><strong>Pendant ma carrière</strong>, j'ai développé des produits allant de sites web marketing et e-commerce à des applications d'entreprise complexes, en mettant l'accent sur la livraison d'un code rapide et élégant, accompagné d'interfaces utilisateur agréables.</p><p><strong>Actuellement</strong>, je travaille en tant qu'indépendant à plein temps.</p>
        </article>
    </div>
    <div>
        <h3 class="scroll-m-20 text-xl font-semibold tracking-tight transition-colors md:text-xl lg:text-2xl">
            Compétences
        </h3>
        <div class="mt-4">
            <ul class="flex flex-wrap items-center gap-2.5 py-4">
                @foreach ($competences as $competence)
                    <a
                        href="{{ $competence->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group flex w-fit items-center gap-2 rounded border border-neutral-200 px-3 py-2 hover:bg-neutral-100 dark:border-neutral-700 hover:dark:bg-neutral-800"
                    >
                        <img
                            alt="{{ $competence->name }}'s logo"
                            loading="lazy"
                            width="20"
                            height="20"
                            decoding="async"
                            data-nimg="{{ $loop->index + 1 }}"
                            style="color:transparent"
                            src="{{ $competence->image }}"
                        >
                        <span class="capitalize text-muted-foreground group-hover:text-black dark:text-neutral-400 group-hover:dark:text-white">
                    {{ $competence->name }}
                </span>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
