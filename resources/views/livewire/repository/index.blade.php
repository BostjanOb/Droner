<div class="container mt-8">

    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                Repositories list
            </h2>
        </div>

        <div class="mt-5 flex items-center lg:mt-0 lg:ml-4">
            <button wire:click="sync"
                    wire:loading.class="opacity-75 pointer-events-none"
                    wire:target="sync"
                    type="button"
                    class="ml-3 shadow-sm inline-flex items-center px-6 py-3 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline-teal focus:border-teal-700 active:bg-teal-700 transition duration-150 ease-in-out">
                <x-icon wire:loading.class="spin"
                        wire:target="sync"
                        icon="sync"
                        size="4"
                        class="mr-2">
                </x-icon>
                Sync with Drone CI
            </button>
        </div>
    </div>


    <div class="space-y-4 mt-4">
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

</div>
