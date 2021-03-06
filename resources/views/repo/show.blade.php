@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex justify-between items-center my-4">
            <div class="text-xl">
                BostjanOb/Running
            </div>
            <div>
                <button class="bg-blue-800 text-blue-100 px-4 py-2 rounded">Queue new build</button>
            </div>
        </div>

        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
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
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="h-8 w-8 text-orange-500">
                                            <path fill="currentColor"
                                                  d="M360 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24 0 90.965 51.016 167.734 120.842 192C75.016 280.266 24 357.035 24 448c-13.255 0-24 10.745-24 24v16c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24 0-90.965-51.016-167.734-120.842-192C308.984 231.734 360 154.965 360 64c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24zm-75.078 384H99.08c17.059-46.797 52.096-80 92.92-80 40.821 0 75.862 33.196 92.922 80zm.019-256H99.078C91.988 108.548 88 86.748 88 64h208c0 22.805-3.987 44.587-11.059 64z"
                                                  class=""></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <a href="#" class="block font-medium text-gray-900 mb-2 hover:underline">
                                            Build #9
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            Added: 30. 5. 2020 22:28
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Planned start: 30. 5. 2020 22:28
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <button type="button"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline-indigo focus:border-blue-700 active:bg-blue-700 transition duration-150 ease-in-out">
                                    Force send
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-8 h-8 text-orange-500 spin">
                                            <path fill="currentColor"
                                                  d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"
                                                  class=""></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <a href="#" class="block font-medium text-gray-900 mb-2 hover:underline">
                                            Build #8
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            Added: 30. 5. 2020 22:28
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Planned start: 30. 5. 2020 22:28
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <dl class="text-sm leading-5 sm:grid sm:grid-cols-3 sm:gap-1">
                                    <dt class="font-medium text-gray-500">Send</dt>
                                    <dd class="text-gray-900 sm:mt-0 sm:col-span-2">30. 5. 2020 22:28</dd>

                                    <dt class="font-medium text-gray-500">Started</dt>
                                    <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">/</dd>

                                    <dt class="font-medium text-gray-500">Finished</dt>
                                    <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">/</dd>
                                </dl>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-8 h-8 text-green-500">
                                            <path fill="currentColor"
                                                  d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"
                                                  class=""></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <a href="#" class="block font-medium text-gray-900 mb-2 hover:underline">
                                            Build #7
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            Added: 30. 5. 2020 22:28
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Planned start: 30. 5. 2020 22:28
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <dl class="text-sm leading-5 sm:grid sm:grid-cols-3 sm:gap-1">
                                    <dt class="font-medium text-gray-500">
                                        Send
                                    </dt>
                                    <dd class="text-gray-900 sm:mt-0 sm:col-span-2">
                                        30. 5. 2020 22:28
                                    </dd>
                                    <dt class="font-medium text-gray-500">
                                        Started
                                    </dt>
                                    <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                        30. 5. 2020 22:28
                                    </dd>
                                    <dt class="font-medium text-gray-500">
                                        Finished
                                    </dt>
                                    <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                        30. 5. 2020 22:28
                                    </dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
