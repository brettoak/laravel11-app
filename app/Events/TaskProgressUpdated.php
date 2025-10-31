<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskProgressUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskId;
    public $currentStep;
    public $totalSteps;
    public $progress;
    public $message;

    /**
     * 创建一个新的事件实例
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
     * 获取事件应该广播到的频道
     */
    public function broadcastOn(): Channel
    {
        return new Channel("task-progress.{$this->taskId}");
    }

    /**
     * 事件的广播名称
     */
    public function broadcastAs(): string
    {
        return 'progress.updated';
    }

    /**
     * 获取要广播的数据
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

