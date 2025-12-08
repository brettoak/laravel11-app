<?php

namespace App\Livewire;

use Livewire\Component;
use App\Jobs\ProcessTaskJob;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class ReverbMultipleJobs extends Component
{
    public $jobs = [];
    public $totalSteps = 10;
    public $maxConcurrentJobs = 10;

    /**
     * Mount component
     */
    public function mount(): void
    {
        // Initialize with empty jobs array
        $this->jobs = [];
    }

    /**
     * Start a new task
     */
    public function startTask(): void
    {
        try {
            // Check if we've reached the maximum number of concurrent jobs
            if (count($this->jobs) >= $this->maxConcurrentJobs) {
                $this->dispatch('notification', [
                    'type' => 'warning',
                    'message' => "Maximum concurrent jobs reached ({$this->maxConcurrentJobs}). Please clear some jobs first."
                ]);
                return;
            }

            // Generate unique task ID
            $taskId = Str::uuid()->toString();

            // Add new job to the list
            $this->jobs[$taskId] = [
                'id' => $taskId,
                'currentStep' => 0,
                'progress' => 0,
                'message' => 'Starting task...',
                'isRunning' => true,
                'createdAt' => now()->format('H:i:s'),
            ];

            // Dispatch task to queue
            ProcessTaskJob::dispatch($taskId, $this->totalSteps);
            
            // Dispatch event to notify frontend to start listening
            $this->dispatch('task-started', taskId: $taskId);

            // Log success
            \Illuminate\Support\Facades\Log::info("Task started: {$taskId}", ['jobs_count' => count($this->jobs)]);
        
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Error starting task: " . $e->getMessage());
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => "Failed to start task: " . $e->getMessage()
            ]);
        }
    }

    /**
     * Start multiple tasks at once
     */
    public function startMultipleTasks(int $count = 3): void
    {
        $count = min($count, $this->maxConcurrentJobs - count($this->jobs));
        
        if ($count <= 0) {
            $this->dispatch('notification', [
                'type' => 'warning',
                'message' => 'Cannot create more tasks. Limit reached.'
            ]);
            return;
        }

        for ($i = 0; $i < $count; $i++) {
            $this->startTask();
        }
    }

    /**
     * Remove a specific job
     */
    public function removeJob($taskId): void
    {
        if (isset($this->jobs[$taskId])) {
            unset($this->jobs[$taskId]);
            
            // Dispatch event to notify frontend to stop listening
            $this->dispatch('task-removed', taskId: $taskId);
        }
    }

    /**
     * Clear all completed jobs
     */
    public function clearCompleted(): void
    {
        $removedCount = 0;
        
        foreach ($this->jobs as $taskId => $job) {
            if (!$job['isRunning'] && $job['progress'] >= 100) {
                unset($this->jobs[$taskId]);
                $this->dispatch('task-removed', taskId: $taskId);
                $removedCount++;
            }
        }

        if ($removedCount > 0) {
            $this->dispatch('notification', [
                'type' => 'success',
                'message' => "{$removedCount} completed jobs cleared"
            ]);
        }
    }

    /**
     * Clear all jobs
     */
    public function clearAll(): void
    {
        $count = count($this->jobs);
        
        foreach ($this->jobs as $taskId => $job) {
            $this->dispatch('task-removed', taskId: $taskId);
        }
        
        $this->jobs = [];

        if ($count > 0) {
            $this->dispatch('notification', [
                'type' => 'success',
                'message' => "All {$count} jobs cleared"
            ]);
        }
    }

    /**
     * Mark a job as complete (called from JavaScript)
     */
    #[On('mark-job-complete')]
    public function markJobComplete($taskId, $data): void
    {
        if (isset($this->jobs[$taskId])) {
            $this->jobs[$taskId]['currentStep'] = $data['currentStep'];
            $this->jobs[$taskId]['progress'] = 100;
            $this->jobs[$taskId]['message'] = $data['message'];
            $this->jobs[$taskId]['isRunning'] = false;
        }
    }

    /**
     * Get running jobs count
     */
    public function getRunningJobsCount(): int
    {
        return collect($this->jobs)->where('isRunning', true)->count();
    }

    /**
     * Get completed jobs count
     */
    public function getCompletedJobsCount(): int
    {
        return collect($this->jobs)->where('progress', '>=', 100)->count();
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.reverb-multiple-jobs');
    }
}
