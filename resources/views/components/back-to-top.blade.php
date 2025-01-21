@props([
    'offset' => '800',
])

<div
    x-cloak
    x-data="{ show: false, offset: {{ $offset }} }"
    x-on:scroll.window="show = window.pageYOffset >= offset"
    class="fixed bottom-8 right-8"
>
    <button
        x-show="show"
        x-transition.duration.500ms
        x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="rounded-full bg-primary p-2 shadow-lg"
    >
        <x-heroicon-o-arrow-up class="size-6 dark:text-black text-white" />
    </button>
</div>
