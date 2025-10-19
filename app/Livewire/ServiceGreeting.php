<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting extends Component
{
    public $count = 0;
    public $message = 'Hello from Livewire!';

    public function increment()
    {
        $this->count++;
    }

    public function refresh()
    {
        $this->message = 'Refreshed at ' . now()->format('H:i:s');
    }

    public function render()
    {
        return view('livewire.service-greeting');
    }
}
