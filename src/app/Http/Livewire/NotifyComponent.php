<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotifyComponent extends Component
{
    public $countNotifyUnread = 0;

    public function maskAsRead()
    {
        $this->countNotifyUnread = $this->getCountNotifyUnread();
    }

    private function getCountNotifyUnread()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return auth()->user()->unreadNotifications->count();
        }
        return 0;
    }

    public function render()
    {
        $this->countNotifyUnread = $this->getCountNotifyUnread();
       
        return view('livewire.notify-component');
    }
}
