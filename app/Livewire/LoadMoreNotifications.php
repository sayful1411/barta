<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class LoadMoreNotifications extends Component
{
    use WithPagination;

    public $per_page = 5;

    public function loadMore()
    {
        $this->per_page += 5;
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()
        ->orderBy('read_at')
        ->paginate($this->per_page);

        return view('livewire.load-more-notifications')->with([
            'notifications' => $notifications,
        ]);
    }
}
