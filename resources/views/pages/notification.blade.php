@extends('layouts.app')

@section('title', 'All Notification - Barta')

@section('content')

    <main class="w-full mx-auto bg-white lg:mt-16 lg:rounded-xl lg:p-8">
        <div class="xs:mt-6 flex justify-between items-center mb-5">
            <h1 class="text-xl font-bold">
                Notifications
                <span id="notifications-counter" class="ml-2 bg-blue text-white rounded-md px-3"></span>
            </h1>
            <form action="{{ route('unread.notifications') }}" method="post">
                @csrf
                @method('PATCH')
                <button type="submit" id="mark-all-as-read"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                    href="#">Mark
                    all as read</button>
            </form>
        </div>

        <livewire:load-more-notifications />


    </main>


@endsection
