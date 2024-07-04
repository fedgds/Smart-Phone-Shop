<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Sang Shop' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body  class="bg-slate-100 dark:bg-slate-700">
        @if (request()->is('admin'))
            @livewire('admin.section.navbar')
        @else
            @livewire('user.section.navbar')
        @endif
        <main>
            {{ $slot }}
        </main>
        @livewire('user.section.footer')

        @livewireScripts
    </body>
</html>
