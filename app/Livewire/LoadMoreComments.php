<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class LoadMoreComments extends Component
{
    use WithPagination;

    public $per_page = 5;
    public $post;

    public function loadMore()
    {
        $this->per_page += 5;
    }

    public function render()
    {
        $comments = Comment::with('user')->where('post_id', $this->post->id)
            ->latest()
            ->paginate($this->per_page);

        return view('livewire.load-more-comments')->with([
            'comments' => $comments,
        ]);
    }
}
