<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting2 extends Component
{
    public array $users = [
        [ 'id'=>1, 'name' => 'Alice', 'email' => 'aa@gmail.com', 'age' => 25],
        [ 'id'=>2, 'name' => 'Bob', 'email' => 'bb@gmail.com', 'age' => 30],
        ];



    public function mount()
    {
        // Initialization logic can go here

    }

    public function render()
    {
        return view('livewire.service-greeting2');
    }
}
