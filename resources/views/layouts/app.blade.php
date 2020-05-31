<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Droner') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    @auth
    <nav class="bg-blue-900 text-blue-100">
        <div class="container flex h-16 items-center">

            <div class="flex-1">
                <a href="/" class="uppercase font-light text-lg">Droner</a>
            </div>

            <div>
                <button class="rounded-full">
                    <img class="h-8 w-8 rounded-full" src="https://www.gravatar.com/avatar/{{ md5(\Auth::user()->email) }}?s=256" alt="" />
                </button>
            </div>
        </div>
    </nav>
    @endauth

    @yield('content')

    @livewireScripts
</body>
</html>
