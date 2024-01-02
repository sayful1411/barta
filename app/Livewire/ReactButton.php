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
            $this->post->decrement('likes_count');
        } else {
            $this->post->likers()->attach(Auth::id());
            $this->post->increment('likes_count');
        }

        $this->liked = !$this->liked;
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.react-button');
    }
}
