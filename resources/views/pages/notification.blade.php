@extends('layouts.app')

@section('title', 'All Notification - Barta')

@section('content')

    <main class="w-full mx-auto bg-white lg:mt-16 lg:rounded-xl lg:p-8">

        @forelse ($notifications as $item)
            <div id="notification-card-1"
                class="border-b-slate-200 border-b-2 mt-3 bg-verylightgb rounded-md flex justify-between p-3 ">
                {{-- <img src="./assets/images/avatar-mark-webber.webp" alt="notification user avatar" class="w-12 h-12 "> --}}
                <div class="ml-2 text-sm flex-auto">
                    <a href="{{ route('users.profile', $item['data']['username']) }}" class="font-bold hover:text-blue">{{ $item['data']['userName'] }}</a>
                    <span class="text-darkgb">{{ $item['data']['message'] }}</span>
                    <a href="{{ route('posts.show', $item['data']['post_id']) }}" class="font-bold text-darkgb cursor-pointer hover:text-blue">{{ $item['data']['post'] }}</a>

                    <p class="text-gb mt-1">{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</p>
                </div>
            </div>
        @empty
        <div id="notification-card-1"
                class=" mt-3 bg-verylightgb rounded-md flex justify-between p-3 ">
                {{-- <img src="./assets/images/avatar-mark-webber.webp" alt="notification user avatar" class="w-12 h-12 "> --}}
                <div class="ml-2 text-sm flex-auto text-center">
                    <h3 class="text-2xl">There is no notification yet</h3>
                </div>
            </div>

        @endforelse

    </main>


@endsection
