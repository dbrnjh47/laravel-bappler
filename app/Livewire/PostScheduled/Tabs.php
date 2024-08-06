<?php

namespace App\Livewire\PostScheduled;

use Livewire\Component;

class Tabs extends Component
{
    public function render()
    {
        return view('livewire.post-scheduled.tabs');
    }

    public $activeTab = 'overview'; // Начальная активная вкладка

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
}
