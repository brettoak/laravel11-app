<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Conversation extends Component
{
    public array $messages = [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'Hello, who won the world series in 2020?'],
        ['role' => 'assistant', 'content' => 'The Los Angeles Dodgers won the World Series in 2020.'],
        ['role' => 'user', 'content' => 'Where was it played?'],
    ];


    public function render(): View
    {
        return view('livewire.conversation');
    }
}
