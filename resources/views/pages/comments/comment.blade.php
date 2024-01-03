@if ($comments->count() > 0)
    <div class="flex flex-col space-y-6">
        <h1 class="text-lg font-semibold">Comments ({{ $comments->count() }})</h1>

        <!-- Barta User Comments Container -->
        <livewire:load-more-comments :post="$post" :key="$post->id" />
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

                var postInput = $('.post_delete_id[data-comment-id="' + commentId + '"]');
                var commentInput = $('.comment_delete_id[data-comment-id="' + commentId + '"]');

                postInput.val(postId);
                commentInput.val(commentId);
            });
        });
    </script>
@endpush
