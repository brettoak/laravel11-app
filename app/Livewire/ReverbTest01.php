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
    public $message = '等待开始任务...';
    public $isRunning = false;

    /**
     * 启动任务
     */
    public function startTask() : void
    {
        // 生成唯一任务 ID
        $this->taskId = Str::uuid()->toString();

        // 重置状态
        $this->currentStep = 0;
        $this->progress = 0;
        $this->message = '正在启动任务...';
        $this->isRunning = true;

        // 分发任务到队列
        ProcessTaskJob::dispatch($this->taskId, $this->totalSteps);

        // 派发事件通知前端开始监听
        $this->dispatch('task-started', taskId: $this->taskId);
    }

    /**
     * 重置任务
     */
    public function resetTask()
    {
        $this->taskId = null;
        $this->currentStep = 0;
        $this->progress = 0;
        $this->message = '等待开始任务...';
        $this->isRunning = false;

        // 派发事件通知前端停止监听
        $this->dispatch('task-reset');
    }

    /**
     * 渲染组件
     */
    public function render()
    {
        return view('livewire.reverb-test01');
    }
}
