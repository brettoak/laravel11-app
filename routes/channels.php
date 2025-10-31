<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// 任务进度频道 - 允许所有用户访问（可以根据需要添加权限检查）
Broadcast::channel('task-progress.{taskId}', function ($user, $taskId) {
    // 这里可以添加权限检查，例如检查用户是否有权限查看该任务
    // 为了演示，我们允许所有已认证用户访问
    return $user !== null;
});
