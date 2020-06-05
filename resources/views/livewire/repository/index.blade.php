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
            <!-- Replace with your content -->
            <div class="space-y-4">
                @if( count($repositories) == 0 )
                    None //todo
                @endif

                @foreach($repositories as $repo)
                    <a @if($repo->token !== null) href="{{ route('repo.show', ['repo' => $repo]) }}"
                       @endif class="flex items-center bg-white shadow-lg rounded-lg p-4 hover:shadow-xl @if($repo->token === null) text-gray-500 @endif">
                        <div>
                            @if($repo->token === null)
                                <x-icon icon="git-alt" size="8"></x-icon>
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
                        <div class="ml-4">
                            <h4 class="font-semibold text-lg flex items-center">
                                {{ $repo->name }}
                                <span class="ml-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">
                                {{ $repo->drone_slug }}
                            </span>
                            </h4>

                            @if($repo->latestBuild)
                                <div class="text-gray-600">
                                    @switch($repo->latestBuild->status)
                                        @case(\App\Build::STATUS_FAILURE)
                                        @case(\App\Build::STATUS_SUCCESS)
                                        Last build: {{ $repo->latestBuild->finished_at->diffForHumans() }}
                                        @break
                                        @case(\App\Build::STATUS_RUNNING)
                                        Build started: {{ $repo->latestBuild->started_at->diffForHumans() }}
                                        @break
                                        @case(\App\Build::STATUS_SEND)
                                        Send to Drone CI: {{ $repo->latestBuild->send_at->diffForHumans() }}
                                        @break
                                        @case(\App\Build::STATUS_CREATED)
                                        Next build: {{ $repo->latestBuild->start_at->diffForHumans() }}
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        </div>

                        @if($repo->token === null)
                            <div class="flex-1 text-right">
                                <button wire:click="activate({{ $repo->id }})"
                                        class="uppercase font-semibold text-lg text-teal-800 px-4 py-1 rounded hover:bg-teal-100">
                                    Activate
                                </button>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
            <!-- /End replace -->
        </div>
    </main>
</div>
