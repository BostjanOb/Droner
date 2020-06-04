<div class="container mt-8" wire:poll.5s>
    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                {{ $repo->name }}
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                    <x-icon icon="id-card" size="5" class="text-gray-400 mr-2" />
                    <a href="{{ \Illuminate\Support\Str::finish(config('droner.drone_url'), '/') . $repo->drone_slug  }}"
                       target="_blank"
                       class="hover:underline"
                       rel="noopener noreferrer">
                        {{ $repo->drone_slug }}
                    </a>
                </div>
                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                    <x-icon icon="git-alt" size="5" class="text-gray-400 mr-1" />
                    <a href="{{ $repo->git_link }}"
                       target="_blank"
                       class="hover:underline"
                       rel="noopener noreferrer">
                        {{ $repo->git_link }}
                    </a>
                </div>
                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                    <x-icon icon="hourglass-half" size="5" class="text-gray-400 mr-1" />
                    {{ $repo->threshold }} minutes
                </div>
            </div>
        </div>

        <div class="mt-5 flex lg:mt-0 lg:ml-4">
            <a href="{{ route('repo.edit', ['repo' => $repo]) }}"
               class="shadow-sm inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-100 transition duration-150 ease-in-out">
                <x-icon icon="pencil-alt" size="3" class="mr-2" />
                Edit
            </a>

            <button wire:click="queue"
                    class="ml-3 shadow-sm inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline-teal focus:border-teal-700 active:bg-teal-700 transition duration-150 ease-in-out">
                <x-icon icon="play-circle" size="5" class="mr-2 -ml-1"></x-icon>
                Queue new build
            </button>
        </div>
    </div>

    <div class="mt-4 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                            Build #
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                            Drone status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($builds as $build)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($build->status == \App\Build::STATUS_SUCCESS)
                                            <x-icon icon="check-circle" size="8" class="text-teal-500"></x-icon>
                                        @elseif($build->status == \App\Build::STATUS_CREATED)
                                            <x-icon icon="hourglass-start" size="8" class="text-teal-300"></x-icon>
                                        @elseif($build->status == \App\Build::STATUS_SEND)
                                            <x-icon icon="hourglass-end" size="8" class="text-teal-700"></x-icon>
                                        @elseif($build->status == \App\Build::STATUS_RUNNING)
                                            <x-icon icon="cog" size="8" class="text-blue-500 spin"></x-icon>
                                        @elseif($build->status == \App\Build::STATUS_FAILURE)
                                            <x-icon icon="exclamation-circle" size="8" class="text-red-500"></x-icon>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ \Illuminate\Support\Str::finish(config('droner.drone_url'), '/') . $repo->drone_slug . '/' . $build->drone_number  }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="block font-medium text-gray-900 mb-2 hover:underline">
                                            Build #{{ $build->drone_number }}
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            Added: {{ $build->created_at->diffForHumans() }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Planned start: {{ $build->start_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                @if($build->status == \App\Build::STATUS_CREATED)
                                    <button wire:click="forceSend({{ $build->id }})"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline-teal focus:border-blue-700 active:bg-blue-700 transition duration-150 ease-in-out">
                                        Force send
                                    </button>
                                @else
                                    <dl class="text-sm leading-5 sm:grid sm:grid-cols-3 sm:gap-1">
                                        <dt class="font-medium text-gray-500">Send</dt>
                                        <dd class="text-gray-900 sm:mt-0 sm:col-span-2">{{ optional($build->send_at)->diffForHumans() ?? '/' }}</dd>

                                        <dt class="font-medium text-gray-500">Started</dt>
                                        <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">{{ optional($build->started_at)->diffForHumans() ?? '/' }}</dd>

                                        <dt class="font-medium text-gray-500">Finished</dt>
                                        <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">{{ optional($build->finished_at)->diffForHumans() ?? '/' }}</dd>
                                    </dl>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 whitespace-no-wrap border-b border-gray-200 text-center">
                                <p class="font-bold text-xl">No builds yet</p>
                                <button wire:click="queue"
                                        class="mt-3 shadow-sm inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline-teal focus:border-teal-700 active:bg-teal-700 transition duration-150 ease-in-out">
                                    <x-icon icon="play-circle" size="5" class="mr-2 -ml-1"></x-icon>
                                    Queue new build
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
