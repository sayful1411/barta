@if ($comments->count() > 0)
    <div class="flex flex-col space-y-6">
        <h1 class="text-lg font-semibold">Comments ({{ $comments->count() }})</h1>

        <!-- Barta User Comments Container -->
        <article
            class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
            <!-- Comments -->
            @foreach ($comments as $comment)
                <div class="py-4">
                    <!-- Barta User Comments Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a href="{{ route('users.profile', $comment->user->username) }}"
                                        class="hover:underline font-semibold line-clamp-1">
                                        {{ $comment->user->fname . ' ' . $comment->user_lname }}
                                    </a>

                                    <a href="{{ route('users.profile', $comment->user->username) }}"
                                        class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        {{ '@' . $comment->user->username }}
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p class="comment-content">
                            {{ $comment->description }}
                        </p>
                    </div>

                    <!-- Comment Actions -->
                    <div class="comment-actions"></div>

                    <!-- Date Created -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <span class="">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                    </div>

                    @if (auth()->user()->id == $comment->user->id)
                        <div class="mt-3">
                            <a href="{{ route('posts.comments.edit', [$comment->post_id, $comment->id]) }}"
                                class="inline pe-2 py-2 me-2 text-sm text-gray-700 hover:underline">Edit</a>
                            {{-- <a data-post-id="{{ $comment->id }}" @click="modalOpen=true"
                                class="inline pe-2 py-2 text-sm text-gray-700 hover:underline">Delete</a> --}}

                            <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                :class="{ 'z-40': modalOpen }" class="relative w-auto h-auto inline">
                                <a data-post-id="{{ $comment->post_id }}" data-comment-id="{{ $comment->id }}"
                                    @click="modalOpen=true"
                                    class="inline pe-2 py-2 text-sm text-gray-700 hover:underline hover:cursor-pointer deleteCommentBtn">Delete</a>
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
                                        <form
                                            action="{{ route('posts.comments.destroy', [$comment->post_id, $comment->id]) }}"
                                            method="POST">
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
                                                <input type="hidden" name="post_delete_id" id="post_delete_id">
                                                <input type="hidden" name="comment_delete_id" id="comment_delete_id">
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
                    @endif
                </div>
            @endforeach
            <!-- /Comments -->
        </article>
        <!-- /Barta User Comments -->
    </div>
@endif

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // post delete
        $(document).ready(function() {
            $('.deleteCommentBtn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                var commentId = $(this).data('comment-id');

                $('#post_delete_id').val(postId);
                $('#comment_delete_id').val(commentId);
            });
        });
    </script>
@endpush
