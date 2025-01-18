<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=atkinson-hyperlegible:400,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased max-w-3xl h-full mx-auto px-5 bg-dot">
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
</body>
</html>
