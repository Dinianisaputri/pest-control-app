<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell font-sans antialiased">
        <div class="mx-auto max-w-md">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="mb-3 flex justify-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f07f5f]/15 ring-1 ring-[#f07f5f]/35">
                            <span class="text-lg font-bold text-[#f07f5f]">PC</span>
                        </div>
                    </div>
                    <span class="auth-badge">Pest Control</span>
                    <h1 class="mt-3 text-2xl font-bold tracking-tight text-white">Monitoring System</h1>
                </div>

                <div class="auth-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
