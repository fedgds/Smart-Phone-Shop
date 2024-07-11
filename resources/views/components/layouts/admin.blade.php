<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Sang Shop' }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-slate-100 dark:bg-slate-700">
        <div class="flex flex-row gap-5">
            <div class="w-1/6">
                @livewire('admin.section.navbar')
            </div>
            <main class="w-5/6">
                {{ $slot }}
            </main>
        </div>        

        @livewireScripts

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
        <x-livewire-alert::scripts />
    </body>
</html>
