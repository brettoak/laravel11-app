<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class ServiceGreeting extends Component
{
    public int $count = 0;
    public string $message = 'Hello from Livewire with Hot Reload! 🚀';
    public string $message1 = 'Hello from Livewire with Hot Reload! 🚀';
    public array $greetings = [];
    public array $statuses = [];
    public bool $show = false;

    public function mount(): void
    {

        $this->greetings = [
            'text' => 'Hello from Livewire Service Component!',
            'time' => now()->format('H:i:s'),
        ];

        $this->statuses = [
            'status' => 'active',
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    public function increment() :int
    {
        $this->count++;
    }
    public function refresh() : void
    {
        $this->message = 'Hi: Refreshed at ' . now()->format('H:i:s');
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->show = false;
    }

    public function render() : View
    {
        return view('livewire.service-greeting');
    }
}
