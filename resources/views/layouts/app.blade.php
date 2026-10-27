<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Smart Pest Monitoring</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="app-shell antialiased">
        <div class="min-h-screen">
            @include('partials.nav')

            @isset($header)
                <header class="mx-auto w-full max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    <div class="page-header">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
