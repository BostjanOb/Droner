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
<body class="antialiased font-sans bg-gray-100">
    {!! file_get_contents(resource_path('icons.svg'))  !!}
    @auth
        <nav class="bg-teal-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0">
                            <img class="h-8" src="/img/droner_w.svg" alt="Workflow logo" />
                        </a>
                    </div>
                    <div class="block">
                        <div class="ml-4 flex items-center md:ml-6">

                            <!-- Profile dropdown -->
                            <div class="ml-3 relative"
                                 x-data="{ isOpen: false }">
                                <div>
                                    <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid"
                                            @click="isOpen = !isOpen"
                                            aria-label="User menu"
                                            aria-haspopup="true">
                                        <img class="h-8 w-8 rounded-full" src="https://www.gravatar.com/avatar/{{ md5(\Auth::user()->email) }}?s=256" alt="" />
                                    </button>
                                </div>
                                <!--
                                  Profile dropdown panel, show/hide based on dropdown state.

                                  Entering: "transition ease-out duration-100"
                                    From: "transform opacity-0 scale-95"
                                    To: "transform opacity-100 scale-100"
                                  Leaving: "transition ease-in duration-75"
                                    From: "transform opacity-100 scale-100"
                                    To: "transform opacity-0 scale-95"
                                -->
                                <div x-show="isOpen"
                                     @click.away="isOpen = false"
                                     x-transition:enter="transition ease-out duration-100 transform"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75 transform"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                    <div class="rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <div class="px-4 py-3">
                                            <p class="text-sm leading-5">
                                                Signed in as
                                            </p>
                                            <p class="text-sm leading-5 font-medium text-gray-900 truncate">
                                                {{ \Auth::user()->name }}
                                            </p>
                                        </div>
                                        <div class="border-t border-gray-100"></div>
                                        <div class="py-1">
                                            <a href="#"
                                               class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                               role="menuitem">Account settings
                                            </a>
                                        </div>
                                        <div class="border-t border-gray-100"></div>
                                        <div class="py-1">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                        class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                                        role="menuitem">
                                                    Sign out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    @yield('content')

    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
