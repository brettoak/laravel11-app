<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Task progress channel - allow all authenticated users to access (you can add permission checks as needed)
Broadcast::channel('task-progress.{taskId}', function ($user, $taskId) {
    // You can add permission checks here, e.g., check if user has permission to view the task
    // For demo purposes, we allow all authenticated users to access
    return $user !== null;
});
