<div class="container mt-8">

    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                <a href="{{ route('repo.show', ['repo' => $repo]) }}">
                    {{ $repo->name }}
                </a>
            </h2>
        </div>

        <div class="mt-5 flex items-center lg:mt-0 lg:ml-4">
            <a href="{{ route('repo.show', ['repo' => $repo]) }}"
               class="shadow-sm inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-100 transition duration-150 ease-in-out">
                <x-icon icon="times" size="5" class="mr-2 text-gray-500 -ml-1" />
                Back
            </a>

            <button wire:click="save"
                    type="button"
                    class="ml-3 shadow-sm inline-flex items-center px-6 py-3 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:shadow-outline-teal focus:border-teal-700 active:bg-teal-700 transition duration-150 ease-in-out">
                <x-icon icon="save" size="5" class="mr-2 -ml-1" />
                Save
            </button>
        </div>
    </div>


    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div>
            <dl>
                <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Primary user
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $repo->owner->name }} - {{ $repo->owner->email }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Drone slug
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $repo->drone_slug }}
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Git link
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $repo->git_link }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Token
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <pre>{{ $repo->token }}</pre>
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Active
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <label class="inline-flex items-center">
                            <input wire:model="active"
                                   type="checkbox"
                                   class="form-checkbox h-6 w-6 text-teal-600">
                        </label>
                    </dd>
                </div>
                <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Threshold
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <label class="block">
                            <input wire:model="threshold"
                                   type="number"
                                   class="form-input block">
                        </label>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Assigned users
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="border border-gray-200 rounded-md">
                            @foreach($repo->users as $user)
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                                    <div class="w-0 flex-1 flex items-center">
                                        <x-icon icon="user" size="5" class="text-gray-400 flex-shrink-0" />
                                        <span class="ml-2 flex-1 w-0 truncate">
                                            {{ $user->name }} - {{ $user->email }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
