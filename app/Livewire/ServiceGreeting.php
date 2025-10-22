<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting extends Component
{
    public $count = 0;
    public $message = 'Hello from Livewire with Hot Reload! 🚀';

    public array $greetings = [];
    public array $statuses = [];

    public function mount(): void{

        $this->greetings = [
            'text' => 'Hello from Livewire Service Component!',
            'time' => now()->format('H:i:s'),
        ];

        $this->statuses = [
            'status' => 'active',
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

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
