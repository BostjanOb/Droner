<div x-data="{ notifications: [] }"
     class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">

    <template x-on:toast.window="
            $event.detail.show = true;
            var l = notifications.push($event.detail);
            setTimeout(function(){ notifications[l-1].show = false }, $event.detail.timeout);">
    </template>

    <div class="flex w-full flex-col items-end space-y-4">
        <template x-for="(notification, index) in notifications" :key="index">
            <div x-show="notification.show"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto">
                <div class="rounded-lg shadow-xs overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <x-icon x-show="notification.type == 'success'" icon="check-circle" size="6" class="text-green-400" />
                                <x-icon x-show="notification.type == 'error'" icon="exclamation-circle" size="6" class="text-red-400" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p x-text="notification.title"
                                   class="text-sm leading-5 font-medium text-gray-900"></p>
                                <p x-text="notification.description"
                                   x-show="notification.description !== ''"
                                   class="mt-1 text-sm leading-5 text-gray-500"></p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="notification.show = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                    <x-icon icon="times" size="5"></x-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
