@extends('layouts.app')

@section('title', 'User Profile - Barta')

@section('content')
    <!-- Cover Container -->
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[400px] space-y-8 flex items-center flex-col justify-center">
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            <!-- Avatar -->
            <div class="relative">
                {{-- <img class="w-32 h-32 rounded-full border-2 border-gray-800"
                src="https://avatars.githubusercontent.com/u/831997" alt="Ahmed Shamim" /> --}}
                <svg class="h-36 w-36 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                        clip-rule="evenodd" />
                </svg>
                <span
                    class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
            </div>
            <!-- /Avatar -->

            <!-- User Meta -->
            <div>
                <h1 class="font-bold md:text-2xl">{{ auth()->user()->fname . ' ' . auth()->user()->lname }}</h1>
                <p class="text-gray-700">{{ auth()->user()->bio }}</p>
            </div>
            <!-- / User Meta -->
        </div>
        <!-- /Profile Info -->
    </section>
    <!-- /Cover Container -->
@endsection
