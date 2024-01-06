<div>
    <div>
        @forelse ($notifications as $item)
            @if ($item->unread())
                <a href="{{ route('markAsRead', $item['id']) }}" class="text-darkgb">
                    <div id="notification-card-1"
                        class="border-b-slate-200 border-b-2 mt-3 bg-verylightgb rounded-md flex justify-between p-3 bg-slate-200">
                        <div class="ml-2 text-sm flex-auto">
                            <span class="font-bold hover:text-blue">{{ $item['data']['userName'] }}</span>
                            <span class="text-darkgb">{{ $item['data']['message'] }}</span>
                            <span
                                class="font-bold text-darkgb cursor-pointer hover:text-blue">{{ $item['data']['post'] }}</span>

                            <p class="text-gb mt-1">{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @else
                <div id="notification-card-2"
                    class="border-b-slate-200 border-b-2 mt-3 bg-verylightgb rounded-md flex justify-between p-3 ">
                    {{-- <img src="./assets/images/avatar-mark-webber.webp" alt="notification user avatar" class="w-12 h-12 "> --}}
                    <div class="ml-2 text-sm flex-auto">
                        <a href="{{ route('users.profile', $item['data']['username']) }}"
                            class="font-bold hover:text-blue">{{ $item['data']['userName'] }}</a>
                        <span class="text-darkgb">{{ $item['data']['message'] }}</span>
                        <a href="{{ route('posts.show', $item['data']['post_id']) }}"
                            class="font-bold text-darkgb cursor-pointer hover:text-blue">{{ $item['data']['post'] }}</a>

                        <p class="text-gb mt-1">{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</p>
                    </div>
                </div>
            @endif

        @empty
            <div id="notification-card-1" class=" mt-3 bg-verylightgb rounded-md flex justify-between p-3 ">
                {{-- <img src="./assets/images/avatar-mark-webber.webp" alt="notification user avatar" class="w-12 h-12 "> --}}
                <div class="ml-2 text-sm flex-auto text-center">
                    <h3 class="text-2xl">There is no notification yet</h3>
                </div>
            </div>
        @endforelse
    </div>

    @if ($notifications->hasMorePages())
        <div class="mt-10 text-center">
            <button
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                wire:click="loadMore" wire:loading.remove>
                Load More
            </button>
            <span wire:loading>Loading...</span>
        </div>
    @else
        <p class="text-center mt-10 font-bold">No more notification to load.</p>
    @endif
</div>
