<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Smart Pest Monitoring</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell font-sans antialiased">
        <div class="auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="mb-4 flex justify-center">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#edf3f8] text-sm font-bold text-[#244b70]">
                            SP
                        </div>
                    </div>
                    <span class="auth-badge">Pest Control</span>
                    <h1 class="mt-3 text-xl font-bold tracking-tight">Smart Pest Monitoring</h1>
                </div>

                <div class="auth-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
