<?php

namespace App\Livewire;

use Livewire\Component;

class Notification extends Component
{
    public function render()
    {
        $unreadNotification = auth()->user()->unreadNotifications()->get();

        return view('livewire.notification')->with([
            'unreadNotification' => $unreadNotification
        ]);
    }
}
