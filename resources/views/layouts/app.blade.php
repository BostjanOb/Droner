<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Droner') }}</title>

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    @auth

        {!! file_get_contents(resource_path('fa.svg'))  !!}

        <nav class="bg-teal-900 text-teal-100">
            <div class="container flex h-16 items-center">

                <div class="flex-1">
                    <a href="/" class="uppercase font-light text-lg">
                        <img src="/img/droner_w.svg" alt="Droner" class="h-10">
                    </a>
                </div>

                <div>
                    <button class="rounded-full">
                        <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/{{ md5(\Auth::user()->email) }}?s=256" alt="" />
                    </button>
                </div>
            </div>
        </nav>
    @endauth

    @yield('content')

    @livewireScripts
</body>
</html>
