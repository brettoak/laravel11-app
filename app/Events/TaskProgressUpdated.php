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
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("task-progress.{$this->taskId}");
    }

    /**
     * 事件的广播名称
     * 注释掉 broadcastAs() 使用默认事件名称：App\Events\TaskProgressUpdated
     */
    // public function broadcastAs(): string
    // {
    //     return 'progress.updated';
    // }

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

