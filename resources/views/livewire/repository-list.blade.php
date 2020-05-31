<div class="container mt-8">

    <div class="flex justify-between items-center my-4">
        <div class="text-xl">
            Repositories list
        </div>
        <div>
            <button wire:click="sync"
                    wire:loading.class="opacity-75 pointer-events-none"
                    wire:target="sync"
                    class="bg-blue-800 text-blue-100 px-4 py-2 rounded flex items-center">
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

    <div class="space-y-4">
        @if( count($repositories) == 0 )
            None //todo
        @endif

        @foreach($repositories as $repo)
            <a @if($repo->token !== null) href="{{ route('repo.show', ['id' => $repo->id]) }}" @endif class="flex items-center bg-white shadow-lg rounded-lg p-4 hover:shadow-xl @if($repo->token === null) text-gray-500 @endif">
                <div>
                    @if($repo->token === null)
                        <x-icon icon="git-alt" size="8"></x-icon>
                    @elseif($repo->latestBuild === null || $repo->latestBuild->status == \App\Build::STATUS_SUCCESS)
                        <x-icon icon="check-circle" size="8" class="text-green-500"></x-icon>
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
                        <span class="ml-4 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
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
                        <button @click="isDialogOpen = true"
                                class="uppercase font-semibold text-lg text-blue-800 px-4 py-1 rounded hover:bg-blue-100">
                            Activate
                        </button>
                    </div>
                @endif
            </a>
        @endforeach
    </div>

</div>
