<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('repo.show', ['repo' => $repo]) }}">
                        <h1 class="text-3xl font-bold leading-tight text-gray-900 flex items-center">
                            <x-icon icon="chevron-left" size="6" class="text-gray-400 mr-2" />
                            {{ $repo->name }}
                        </h1>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label for="username" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Primary user
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 text-sm sm:mt-px sm:pt-2">
                            {{ $repo->owner->name }} - {{ $repo->owner->email }}
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="about" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Drone slug
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 text-sm  sm:mt-px sm:pt-2">
                            {{ $repo->drone_slug }}
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="about" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Git link
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 text-sm  sm:mt-px sm:pt-2">
                            {{ $repo->git_link }}
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="about" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Token
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 text-sm  sm:mt-px sm:pt-2">
                            {{ $repo->token }}
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-5 sm:border-t sm:border-gray-200 sm:pt-5">
                        <div role="group" aria-labelledby="label-notifications">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-baseline">
                                <div class="text-base leading-6 font-medium text-gray-900 sm:text-sm sm:leading-5 sm:text-gray-700" id="label-notifications">
                                    Active
                                </div>
                                <div class="sm:col-span-2">
                                    <div class="max-w-lg">
                                        <span wire:model="active"
                                              x-data="{
                                                    checked: {{ (int)$repo->active }}
                                                  }"
                                              @click="checked = !checked; $dispatch('input', checked)"
                                              :class="{'bg-teal-600': checked, 'bg-gray-200': !checked }"
                                              role="checkbox"
                                              tabindex="0"
                                              aria-checked="false"
                                              class="relative inline-block flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline">
                                          <span aria-hidden="true"
                                                :class="{'translate-x-5': checked, 'translate-x-0': !checked }"
                                                class="translate-x-0 relative inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200">

                                            <span :class="{'opacity-0 ease-out duration-100': checked, 'opacity-100 ease-in duration-200': !checked }"
                                                  class="opacity-100 ease-in duration-200 absolute inset-0 h-full w-full flex items-center justify-center transition-opacity">
                                                <x-icon icon="times" size="3" class="text-gray-400" />
                                            </span>

                                            <span :class="{'opacity-100 ease-in duration-200': checked, 'opacity-0 ease-out duration-100': !checked }"
                                                  class="opacity-0 ease-out duration-100 absolute inset-0 h-full w-full flex items-center justify-center transition-opacity">
                                                <x-icon icon="check" size="3" class="text-teal-600" />
                                            </span>
                                          </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="zip" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Threshold
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input wire:model="threshold"
                                       id="zip"
                                       type="number" step="1" min="0"
                                       class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-5">
                        <div class="flex justify-end">
                            <span class="inline-flex rounded-md shadow-sm">
                            <button wire:click="save"
                                    type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:shadow-outline-teal active:bg-teal-700 transition duration-150 ease-in-out">
                              <x-icon icon="save" size="5" class="mr-2 -ml-1" />
                                Save
                            </button>
                          </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
