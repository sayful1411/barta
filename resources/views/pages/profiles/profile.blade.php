@extends('layouts.app')

@section('title', 'Profile - Barta')

@section('content')
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    <!-- Cover Container -->
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            <!-- User Meta -->
            <div>
                <h1 class="font-bold md:text-2xl">{{ auth()->user()->fname . ' ' . auth()->user()->lname }}</h1>
                <p class="text-gray-700">{{ auth()->user()->bio }}</p>
            </div>
            <!-- / User Meta -->
        </div>
        <!-- /Profile Info -->

        <!-- Profile Stats -->
        <div class="flex flex-row gap-16 justify-center text-center items-center">
            <!-- Total Posts Count -->
        </div>
        <!-- /Profile Stats -->

        <!-- Edit Profile Button (Only visible to the profile owner) -->
        <a href="{{ route('profile.edit') }}" type="button"
            class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125">
                </path>
            </svg>
            Edit Profile
        </a>
        <!-- /Edit Profile Button -->
    </section>
    <!-- /Cover Container -->
    <!-- Barta Create Post Card -->
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
        @csrf
        <!-- Create Post Card Top -->
        <div>
            <div class="flex items-start /space-x-3/">
                <!-- Content -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea class="block w-full p-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                        name="barta" rows="2" placeholder="What's going on, {{ auth()->user()->fname }}?">{{ old('barta') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Create Post Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end">
                <div>
                    <!-- Post Button -->
                    <button type="submit"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                        Post
                    </button>
                    <!-- /Post Button -->
                </div>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Post Card Bottom -->
    </form>
    @error('barta')
        <div class="p-2 m-0 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
            {{ $message }}
        </div>
    @enderror
    <!-- /Barta Create Post Card -->
    <!-- User Specific Posts Feed -->
    <!-- Barta Card -->
    @foreach ($posts as $post)
        <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
            <!-- Barta Card Top -->
            <header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- User Info -->
                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                            <a href="{{ route('profile') }}" class="hover:underline font-semibold line-clamp-1">
                                {{ $post->user_fname . ' ' . $post->user_lname }}
                            </a>

                            <a href="{{ route('profile') }}" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                {{ '@' . $post->user_username }}
                            </a>
                        </div>
                        <!-- /User Info -->
                    </div>

                    <!-- Card Action Dropdown -->
                    <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button"
                                    class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                    id="menu-0-button">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                                style="display: none;">
                                <a href="{{ route('posts.edit', $post->uuid) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Edit</a>
                                <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                    :class="{ 'z-40': modalOpen }" class="relative w-auto h-auto">
                                    <a data-post-id="{{ $post->id }}" @click="modalOpen=true"
                                        class="block cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 deletePostBtn"
                                        role="menuitem" tabindex="-1" id="user-menu-item-1">
                                        Delete
                                    </a>
                                    <template x-teleport="body">
                                        <div x-show="modalOpen"
                                            class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen"
                                            x-cloak>
                                            <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-300"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                @click="modalOpen=false"
                                                class="absolute inset-0 w-full h-full bg-white backdrop-blur-sm bg-opacity-70">
                                            </div>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                                                    class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-lg">
                                                    <div class="flex items-center justify-between pb-3">
                                                        <h3 class="text-lg font-semibold">Delete Post</h3>
                                                        <button type="button" @click="modalOpen=false"
                                                            class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="post_delete_id" id="post_id">
                                                    <div class="relative w-auto pb-8">
                                                        <p>Do you really want to delete this post?</p>
                                                    </div>
                                                    <div
                                                        class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                                                        <button @click="modalOpen=false" type="button"
                                                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors border rounded-md focus:outline-none focus:ring-2 focus:ring-neutral-100 focus:ring-offset-2">Cancel</button>
                                                        <button @click="modalOpen=false" type="submit"
                                                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 bg-rose-700 hover:bg-rose-900">Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Card Action Dropdown -->
                </div>
            </header>

            <!-- Content -->
            <a href="{{ route('posts.show', $post->uuid) }}">
                <div class="py-4 text-gray-700 font-normal">
                    <p>
                        {!! nl2br($post->description) !!}
                    </p>
                </div>
            </a>

            <!-- Date Created & View Stat -->
            <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                <span class="">{{ $post->created_at->diffForHumans() }}</span>
                <span class="">•</span>
                <span>{{ $post->view_count }} views</span>
            </div>
        </article>
    @endforeach
    <!-- /Barta Card -->
    <!-- /User Specific Posts Feed -->
@endsection

@push('scripts')
    <script>
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize() {
            var el = this;
            setTimeout(function() {
                el.style.cssText = 'min-height:37px; height: 37px;';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
            }, 0);
        }
    </script>
@endpush
