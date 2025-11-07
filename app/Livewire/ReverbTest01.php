<?php

namespace App\Livewire;

use Livewire\Component;
use App\Jobs\ProcessTaskJob;
use Illuminate\Support\Str;

class ReverbTest01 extends Component
{
    public $taskId = null;
    public $currentStep = 0;
    public $totalSteps = 10;
    public $progress = 0;
    public $message = 'Waiting to start task...';
    public $isRunning = false;

    /**
     * Start task
     */
    public function startTask() : void
    {
        // Generate unique task ID
        $this->taskId = Str::uuid()->toString();

        // Reset status
        $this->currentStep = 0;
        $this->progress = 0;
        $this->message = 'Starting task...';
        $this->isRunning = true;

        // Dispatch task to queue
        ProcessTaskJob::dispatch($this->taskId, $this->totalSteps);


        // Dispatch event to notify frontend to start listening
        $this->dispatch('task-started', taskId: $this->taskId);
    }

    /**
     * Reset task
     */
    public function resetTask()
    {
        $this->taskId = null;
        $this->currentStep = 0;
        $this->progress = 0;
        $this->message = 'Waiting to start task...';
        $this->isRunning = false;

        // Dispatch event to notify frontend to stop listening
        $this->dispatch('task-reset');
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.reverb-test01');
    }
}
