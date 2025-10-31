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
     * 创建一个新的任务实例
     */
    public function __construct(string $taskId, int $totalSteps = 10)
    {
        $this->taskId = $taskId;
        $this->totalSteps = $totalSteps;
    }

    /**
     * 执行任务
     */
    public function handle(): void
    {
        // 模拟一个耗时的任务，分步骤执行
        for ($currentStep = 1; $currentStep <= $this->totalSteps; $currentStep++) {
            // 模拟每个步骤的耗时操作
            $this->simulateWork($currentStep);
            
            // 计算进度百分比
            $progress = ($currentStep / $this->totalSteps) * 100;
            
            // 广播进度更新事件
            event(new TaskProgressUpdated(
                $this->taskId,
                $currentStep,
                $this->totalSteps,
                $progress,
                $this->getStatusMessage($currentStep)
            ));
        }
        
        // 任务完成
        event(new TaskProgressUpdated(
            $this->taskId,
            $this->totalSteps,
            $this->totalSteps,
            100,
            '任务完成！'
        ));
    }

    /**
     * 模拟工作负载
     */
    private function simulateWork(int $step): void
    {
        // 模拟每个步骤耗时 1-2 秒
        usleep(rand(500000, 2000000)); // 0.5 到 2 秒
    }

    /**
     * 获取状态消息
     */
    private function getStatusMessage(int $step): string
    {
        $messages = [
            1 => '正在初始化...',
            2 => '正在处理数据...',
            3 => '正在验证信息...',
            4 => '正在生成报告...',
            5 => '正在保存文件...',
            6 => '正在上传数据...',
            7 => '正在分析结果...',
            8 => '正在优化性能...',
            9 => '正在进行最终检查...',
            10 => '任务完成！',
        ];

        return $messages[$step] ?? "正在处理步骤 {$step}...";
    }
}

