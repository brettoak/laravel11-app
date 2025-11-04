<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Broadcast;
use App\Events\TaskProgressUpdated;

class ProcessTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $taskId;
    public $totalSteps;

    /**
     * Create a new job instance
     */
    public function __construct(string $taskId, int $totalSteps = 10)
    {
        $this->taskId = $taskId;
        $this->totalSteps = $totalSteps;
    }

    /**
     * Execute the job
     */
    public function handle(): void
    {
        // Simulate a time-consuming task, executed in steps
        for ($currentStep = 1; $currentStep <= $this->totalSteps; $currentStep++) {
            // Simulate time-consuming operation for each step
            $this->simulateWork($currentStep);
            
            // Calculate progress percentage
            $progress = ($currentStep / $this->totalSteps) * 100;
            
            // Broadcast progress update event
            event(new TaskProgressUpdated(
                $this->taskId,
                $currentStep,
                $this->totalSteps,
                $progress,
                $this->getStatusMessage($currentStep)
            ));
        }
        
        // Task completed
        event(new TaskProgressUpdated(
            $this->taskId,
            $this->totalSteps,
            $this->totalSteps,
            100,
            'Task completed!'
        ));
    }

    /**
     * Simulate work load
     */
    private function simulateWork(int $step): void
    {
        // Simulate each step taking 1-2 seconds
        usleep(rand(500000, 2000000)); // 0.5 to 2 seconds
    }

    /**
     * Get status message
     */
    private function getStatusMessage(int $step): string
    {
        $messages = [
            1 => 'Initializing...',
            2 => 'Processing data...',
            3 => 'Validating information...',
            4 => 'Generating report...',
            5 => 'Saving files...',
            6 => 'Uploading data...',
            7 => 'Analyzing results...',
            8 => 'Optimizing performance...',
            9 => 'Performing final check...',
            10 => 'Task completed!',
        ];

        return $messages[$step] ?? "Processing step {$step}...";
    }
}

