<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting5 extends Component
{

    public $name;
    public $email;
    public $bio;
    public $isSaving = false;

    public function mount()
    {
        // Initialize data (simulate loading user information)
        $this->name = "James";
        $this->email = "james@example.com";
        $this->bio = "PHP Developer";
    }



    public function save()
    {
        $this->isSaving = true;

        // Simulate save delay
        sleep(1);

        // Simulate save completion
        $this->isSaving = false;

        // Dispatch event to notify parent component or page refresh
        $this->dispatch('profileSaved');
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.service-greeting5');
    }
}
