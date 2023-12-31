<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class LoadMorePosts extends Component
{
    use WithPagination;

    public $per_page = 5;

    function loadMore()
    {
        $this->per_page += 5;
    }
    public function render()
    {
        $posts = Post::with('user.media', 'media', 'comments')
            ->latest()
            ->paginate($this->per_page);

        return view('livewire.load-more-posts')->with([
            'posts' => $posts,
        ]);
    }
}
