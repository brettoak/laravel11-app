<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskProgressUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskId;
    public $currentStep;
    public $totalSteps;
    public $progress;
    public $message;

    /**
     * Create a new event instance
     */
    public function __construct(
        string $taskId,
        int $currentStep,
        int $totalSteps,
        float $progress,
        string $message
    ) {
        $this->taskId = $taskId;
        $this->currentStep = $currentStep;
        $this->totalSteps = $totalSteps;
        $this->progress = $progress;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("task-progress.{$this->taskId}");
    }

    /**
     * The event's broadcast name
     * Commented out broadcastAs() to use default event name: App\Events\TaskProgressUpdated
     */
    // public function broadcastAs(): string
    // {
    //     return 'progress.updated';
    // }

    /**
     * Get the data to broadcast
     */
    public function broadcastWith(): array
    {
        return [
            'taskId' => $this->taskId,
            'currentStep' => $this->currentStep,
            'totalSteps' => $this->totalSteps,
            'progress' => round($this->progress, 2),
            'message' => $this->message,
        ];
    }
}

