<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        Repositories list
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="shadow-sm rounded-md">
                        <button wire:click="sync"
                                wire:loading.class="opacity-75 pointer-events-none"
                                wire:target="sync"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline-teal focus:border-teal-700 active:bg-teal-700 transition duration-150 ease-in-out">
                                <x-icon wire:loading.class="spin"
                                        wire:target="sync"
                                        icon="sync"
                                        size="4"
                                        class="mr-2">
                                </x-icon>
                                Sync with Drone CI
                            </button>
                    </span>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul>
                    @foreach($repositories as $repo)
                        <li>
                            <a @if($repo->token !== null) href="{{ route('repo.show', ['repo' => $repo]) }}" @endif
                            class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="min-w-0 flex-1 flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($repo->token === null)
                                                <x-icon icon="git-alt" size="8" class="text-gray-500"></x-icon>
                                            @elseif($repo->latestBuild === null || $repo->latestBuild->status == \App\Build::STATUS_SUCCESS)
                                                <x-icon icon="check-circle" size="8" class="text-teal-500"></x-icon>
                                            @elseif($repo->latestBuild->status == \App\Build::STATUS_SEND || $repo->latestBuild->status == \App\Build::STATUS_CREATED)
                                                <x-icon icon="hourglass-half" size="8" class="text-orange-500"></x-icon>
                                            @elseif($repo->latestBuild->status == \App\Build::STATUS_RUNNING)
                                                <x-icon icon="cog" size="8" class="text-blue-500 spin"></x-icon>
                                            @elseif($repo->latestBuild->status == \App\Build::STATUS_FAILURE)
                                                <x-icon icon="exclamation-circle" size="8" class="text-red-500"></x-icon>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                            <div>
                                                <div class="leading-5 font-semibold text-teal-600 truncate">
                                                    {{ $repo->name }}
                                                </div>
                                                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                    <x-icon icon="drone" size="4" class="flex-shrink-0 mr-1.5 text-gray-400"/>
                                                    <span class="truncate">{{ $repo->drone_slug }}</span>
                                                </div>
                                            </div>
                                            <div class="hidden md:block">
                                                @if($repo->latestBuild)
                                                    <div>
                                                        <div class="text-sm leading-5 text-gray-900">
                                                            @switch($repo->latestBuild->status)
                                                                @case(\App\Build::STATUS_FAILURE)
                                                                @case(\App\Build::STATUS_SUCCESS)
                                                                Last build on {{ $repo->latestBuild->finished_at->format('F j, Y H:i') }}
                                                                @break
                                                                @case(\App\Build::STATUS_RUNNING)
                                                                Build started: {{ $repo->latestBuild->started_at->format('F j, Y H:i') }}
                                                                @break
                                                                @case(\App\Build::STATUS_SEND)
                                                                Send to Drone CI: {{ $repo->latestBuild->send_at->format('F j, Y H:i') }}
                                                                @break
                                                                @case(\App\Build::STATUS_CREATED)
                                                                Next build: {{ $repo->latestBuild->start_at->format('F j, Y H:i') }}
                                                                @break
                                                            @endswitch
                                                        </div>
                                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                            <x-icon icon="check-circle" size="5" class="lex-shrink-0 mr-1.5 text-green-400" />
                                                            Build #{{ $repo->latestBuild->drone_number }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @if($repo->token === null)
                                            <span class="inline-flex rounded-md shadow-sm">
                                              <button wire:click="activate({{ $repo->id }})"
                                                      type="button"
                                                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-teal-100 hover:bg-teal-50 focus:outline-none focus:border-teal-300 focus:shadow-outline-teal active:bg-teal-200 transition ease-in-out duration-150">
                                                <x-icon icon="check" size="5" class="-ml-1 mr-2"/>
                                                Activate
                                              </button>
                                            </span>
                                        @else
                                            <x-icon icon="chevron-right" size="5" class="flex-shrink-0 mr-1.5 text-gray-400" />
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </main>
</div>
