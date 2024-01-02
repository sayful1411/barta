<div>
    <div class="relative ml-3" x-data="{ open: false }">
        <div>
            <button @click="open = !open" type="button"
                class="rounded-full relative bg-white p-2 text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <span class="sr-only">View notifications</span>
                @if ($unreadNotification->count() >= 1)
                    <div
                        class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 border-1 border-white rounded-full top-0 end-0 dark:border-gray-900">
                        {{ $unreadNotification->count() }}
                    </div>

                @endif

                    <!-- Heroicon name: outline/bell -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
            </button>
        </div>

        <!-- Dropdown menu -->
        <div x-show="open" @click.away="open = false"
            class="absolute -right-36 mt-3 z-10 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <div>
                @forelse ($unreadNotification as $item)
                    <div class="px-2 py-2 my-1 bg-slate-200">
                        <a href="{{ $item['data']['post_url'] }}">
                            <p>{{ $item['data']['message'] }}</p>
                        </a>
                    </div>
                @empty
                    <div class="px-2 py-2 my-1">
                        <p>No Notification found</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('notifications') }}">
                <button type="button"
                    class="mt-3 w-full text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-b-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Show All Notifications
                </button>
            </a>
        </div>
    </div>
</div>
