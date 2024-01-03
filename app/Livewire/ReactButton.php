<?php

namespace App\Livewire;

use App\Events\ReactProcessed;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

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
        $userId = Auth::id();
        $cacheKey = "like_event_fired_{$this->post->id}_{$userId}";

        if ($this->liked) {
            $this->post->likers()->detach(Auth::id());
            $this->post->decrement('likes_count');
        } else {

            $this->post->likers()->attach(Auth::id());
            $this->post->increment('likes_count');

            if (!Cache::get($cacheKey)) {
                event(new ReactProcessed($this->post));

                Cache::put($cacheKey, true, now()->addMinutes(60));
            }
        }

        $this->liked = !$this->liked;
        $this->post->refresh();
    }
    public function render()
    {
        return view('livewire.react-button');
    }
}
