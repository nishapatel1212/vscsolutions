<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ company('company_name', config('app.name', 'Laravel')) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .auth-hero {
                background-color: #10131a;
                background-image:
                    linear-gradient(100deg, rgba(10, 12, 18, 0.92) 0%, rgba(10, 12, 18, 0.55) 35%, rgba(10, 12, 18, 0.15) 70%, rgba(10, 12, 18, 0.55) 100%),
                    linear-gradient(0deg, rgba(5, 7, 10, 0.85) 0%, rgba(5, 7, 10, 0.1) 35%, transparent 55%),
                    repeating-linear-gradient(0deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 48px),
                    repeating-linear-gradient(90deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 48px),
                    url("{{ asset('images/auth/login-hero.webp') }}");
                background-size: cover, cover, 48px 48px, 48px 48px, cover;
                background-position: center, center, center, center, center;
                background-repeat: no-repeat, no-repeat, repeat, repeat, no-repeat;
                position: relative;
            }
            .auth-hero::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, transparent 0%, rgba(250, 180, 30, 0.6) 50%, transparent 100%);
                height: 2px;
                top: 0;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col md:flex-row">

            <!-- Left: Hero panel -->
            <div class="auth-hero hidden md:flex md:w-1/2 flex-col justify-between p-8 lg:p-12 text-white relative overflow-hidden">
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-semibold tracking-wider uppercase text-amber-300">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M11.983 1.907a.75.75 0 00-1.292-.657L4.1 10.25a.75.75 0 00.591 1.213h4.206l-1.372 6.323a.75.75 0 001.292.657l6.591-9a.75.75 0 00-.591-1.193h-4.206l1.372-6.343z"/></svg>
                        Licensed Electricians
                    </span>
                </div>

                <div class="max-w-lg">
                    <h1 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-6">
                        Powering Homes &amp;
                        <span class="text-amber-400">Businesses</span>
                        Across Australia
                    </h1>
                    <div class="flex items-center gap-3 text-sm text-white/70 mb-8">
                        <span class="w-8 h-px bg-amber-400"></span>
                        Trusted &middot; Licensed &middot; Local {{ company('rec_number') ? '— ' . company('rec_number') : '' }}
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="min-w-0">
                            <p class="text-2xl font-bold truncate">{{ company('rec_number', 'Licensed') }}</p>
                            <p class="text-xs uppercase tracking-wide text-white/50 mt-1">REC Number</p>
                        </div>
                        <div class="min-w-0">
                            <p class="text-2xl font-bold truncate">VIC</p>
                            <p class="text-xs uppercase tracking-wide text-white/50 mt-1">Service Area</p>
                        </div>
                        <div class="min-w-0">
                            <p class="text-2xl font-bold truncate">4.9/5 ★</p>
                            <p class="text-xs uppercase tracking-wide text-white/50 mt-1">Reviews</p>
                        </div>
                    </div>
                </div>

                <div></div>
            </div>

            <!-- Right: Form panel -->
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-gray-50 px-6 py-12 min-w-0">
                <div class="w-full max-w-md bg-white px-6 py-8 sm:px-10 sm:py-10 shadow-xl rounded-2xl border border-gray-100">

                    <div class="flex items-center gap-3 mb-8">
                        <img src="{{ asset('images/logo/latin_logo_icon.png') }}" alt="{{ company('company_name') }} Logo" class="h-14 w-14 object-contain rounded-full bg-gray-900 p-2">
                        <div>
                            <p class="text-lg font-bold text-gray-900 leading-tight">{{ company('company_name', 'Latin Electrical') }}</p>
                            @if (company('rec_number'))
                                <p class="text-[11px] uppercase tracking-wider text-gray-400">REC {{ company('rec_number') }}</p>
                            @endif
                        </div>
                    </div>

                    {{ $slot }}
                </div>

                <p class="mt-8 text-xs text-gray-400 text-center">
                    &copy; {{ date('Y') }} {{ company('company_name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
