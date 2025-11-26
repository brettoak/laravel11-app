<?php

use App\Http\Controllers\Conversation;
use App\Http\Controllers\ReverbMultipleJobs;
use App\Http\Controllers\ReverbSingleJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::redirect('/register', '/login');

Route::redirect('/', '/login');

Route::get('/test2', static function () {
    return response()->json([
        'message' => 'test2',
        'code' => 200,
        'data' => [
            'name' => 'test2',
            'age' => 20,
        ],
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('/admin', function () {
    //     return view('admin');
    // })->name('admin');

    Route::get('/service', [ServiceController::class, 'index']);

    Route::get('/reverb/single/job', [ReverbSingleJob::class, 'index']);

    Route::get('/reverb/multiple/jobs', [ReverbMultipleJobs::class, 'index']);

    Route::get('/conversation', [Conversation::class, 'index']);
});
