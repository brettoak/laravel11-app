<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting2 extends Component
{
    public array $users = [
        [ 'id'=>1, 'name' => 'Alice', 'email' => 'aa@gmail.com', 'age' => 25],
        [ 'id'=>2, 'name' => 'Bob', 'email' => 'bb@gmail.com', 'age' => 30],
        [ 'id'=>3, 'name' => 'Charlie', 'email' => '', 'age' => 35],
        [ 'id'=>4, 'name' => 'David', 'email' => '', 'age' => 28],
        [ 'id'=>5, 'name' => 'Eve', 'email' => '', 'age' => 22],
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
