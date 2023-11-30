@extends('layouts.app')

@section('title', 'Profile - Barta')

@section('content')
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    <!-- Cover Container -->
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            {{-- Avatar --}}
            <div class="relative">
                <img class="w-32 h-32 rounded-full border-2 border-gray-800" src="{{ auth()->user()->avatar_url }}"
                    alt="{{ auth()->user()->fname }}">
                <!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>-->
            </div>
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
            <div class="flex flex-col justify-center items-center">
                <h4 class="sm:text-xl font-bold">{{ $posts->count() }}</h4>
                <p class="text-gray-600">Posts</p>
            </div>

            <!-- Total Comments Count -->
            <div class="flex flex-col justify-center items-center">
                <h4 class="sm:text-xl font-bold">{{ $totalComments }}</h4>
                <p class="text-gray-600">Comments</p>
            </div>
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
                {{-- User Avatar --}}
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}"
                        alt="{{ auth()->user()->fname }}">
                </div>
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
            <div>
                <!-- Card Bottom Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex gap-4 text-gray-600">
                        <!-- Upload Picture Button -->
                        <div>
                            <input type="file" name="picture" id="picture" class="hidden">

                            <label for="picture"
                                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">
                                <span class="sr-only">Picture</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                                    </path>
                                </svg>
                            </label>
                        </div>
                        <!-- /Upload Picture Button -->

                        <!-- GIF Button -->
                        <!--                <button-->
                        <!--                  type="button"-->
                        <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                        <!--                  <span class="sr-only">GIF</span>-->
                        <!--                  <svg-->
                        <!--                    xmlns="http://www.w3.org/2000/svg"-->
                        <!--                    fill="none"-->
                        <!--                    viewBox="0 0 24 24"-->
                        <!--                    stroke-width="1.5"-->
                        <!--                    stroke="currentColor"-->
                        <!--                    class="w-6 h-6">-->
                        <!--                    <path-->
                        <!--                      stroke-linecap="round"-->
                        <!--                      stroke-linejoin="round"-->
                        <!--                      d="M12.75 8.25v7.5m6-7.5h-3V12m0 0v3.75m0-3.75H18M9.75 9.348c-1.03-1.464-2.698-1.464-3.728 0-1.03 1.465-1.03 3.84 0 5.304 1.03 1.464 2.699 1.464 3.728 0V12h-1.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />-->
                        <!--                  </svg>-->
                        <!--                </button>-->
                        <!-- /GIF Button -->

                        <!-- Emoji Button -->
                        <!--                <button-->
                        <!--                  type="button"-->
                        <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                        <!--                  <span class="sr-only">Emoji</span>-->
                        <!--                  <svg-->
                        <!--                    xmlns="http://www.w3.org/2000/svg"-->
                        <!--                    fill="none"-->
                        <!--                    viewBox="0 0 24 24"-->
                        <!--                    stroke-width="1.5"-->
                        <!--                    stroke="currentColor"-->
                        <!--                    class="w-6 h-6">-->
                        <!--                    <path-->
                        <!--                      stroke-linecap="round"-->
                        <!--                      stroke-linejoin="round"-->
                        <!--                      d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />-->
                        <!--                  </svg>-->
                        <!--                </button>-->
                        <!-- /Emoji Button -->
                    </div>

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
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Post Card Bottom -->
    </form>
    @error('barta')
        <div class="p-2 m-0 text-sm text-red-500 rounded-lg" role="alert">
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
                        {{-- User Avatar --}}
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}"
                                alt="{{ auth()->user()->fname }}">
                        </div>
                        <!-- User Info -->
                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                            <a href="{{ route('profile') }}" class="hover:underline font-semibold line-clamp-1">
                                {{ $post->user->fname . ' ' . $post->user->lname }}
                            </a>

                            <a href="{{ route('profile') }}" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                {{ '@' . $post->user->username }}
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
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1" style="display: none;">
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
                <span class="">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                <span class="">•</span>
                <span>{{ $post->view_count }} views</span>
            </div>

            <!-- Barta card bottom -->
            <footer class="border-t border-gray-200 pt-2">
                <!-- Card Bottom Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex gap-8 text-gray-600">
                        <!-- Comment Button -->
                        <a href="{{ route('posts.show', $post->uuid) }}" type="button"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                            <span class="sr-only">Comment</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z">
                                </path>
                            </svg>

                            <p>{{ $post->comments->count() }}</p>
                        </a>
                        <!-- /Comment Button -->
                    </div>
                </div>
                <!-- /Card Bottom Action Buttons -->
            </footer>
            <!-- /Barta card bottom -->
        </article>
    @endforeach
    <!-- /Barta Card -->
    <!-- /User Specific Posts Feed -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // auto expand post area
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize() {
            var el = this;
            setTimeout(function() {
                el.style.cssText = 'min-height:37px; height: 37px;';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
            }, 0);
        }

        // post delete
        $(document).ready(function() {
            $('.deletePostBtn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                $('#post_id').val(postId);
            });
        });
    </script>
@endpush
