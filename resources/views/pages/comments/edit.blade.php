@extends('layouts.app')

@section('title', 'Edit Post - Barta')

@section('content')
    <!-- User Specific Posts Feed -->
    <!-- Barta Card -->
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col space-y-6">
        <!-- Barta User Comments Container -->
        <article
            class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
            <!-- Comments -->
            <div class="py-4">
                <!-- Content -->
                <div class="py-4 text-gray-700 font-normal">
                    <form action="{{ route('posts.comments.update', [$comment->post_id, $comment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Create Comment Card Top -->
                        <div>
                            <div class="flex items-start /space-x-3/">
                                <!-- Auto Resizing Comment Box -->
                                <div class="text-gray-700 font-normal w-full">
                                    <textarea x-data="{
                                        resize() {
                                            $el.style.height = '0px';
                                            $el.style.height = $el.scrollHeight + 'px'
                                        }
                                    }" x-init="resize()" @input="resize()" type="text" name="comment"
                                        placeholder="Write a comment..."
                                        class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900 "
                                        style="height: 38px;" spellcheck="false">{{ $comment->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Create Comment Card Bottom -->
                        <div>
                            <!-- Card Bottom Action Buttons -->
                            <div class="flex items-center justify-end">
                                <button type="submit"
                                    class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                                    Update Comment
                                </button>
                            </div>
                            <!-- /Card Bottom Action Buttons -->
                        </div>
                        <!-- /Create Comment Card Bottom -->
                    </form>
                </div>
            </div>
            <!-- /Comments -->
        </article>
        <!-- /Barta User Comments -->
    </div>



    <!-- /Barta Card -->
    <!-- /User Specific Posts Feed -->

    <hr>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.deletePostBtn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                $('#post_id').val(postId);
            });
        });
    </script>
@endpush
