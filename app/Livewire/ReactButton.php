<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReactButton extends Component
{
    public $post;
    public $liked;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->liked = $this->post->likers->contains(Auth::id());
    }

    public function toggleLike()
    {
        if ($this->liked) {
            $this->post->likers()->detach(Auth::id());
            $this->post->decrement('likes_count'); // Decrement likes_count when unliking
        } else {
            $this->post->likers()->attach(Auth::id());
            $this->post->increment('likes_count'); // Increment likes_count when liking
        }

        $this->liked = !$this->liked;
        $this->post->refresh(); // Refresh the post model to reflect the updated likers relationship
    }

    public function render()
    {
        return view('livewire.react-button');
    }
}
