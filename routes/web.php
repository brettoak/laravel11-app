<?php

use App\Http\Controllers\Conversation;
use App\Http\Controllers\ReverbTest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;



Route::redirect('/register', '/login');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test1', function () {
    return 'test1';
});

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

// Test route - no authentication required
Route::get('/reverb-test-public', [ReverbTest::class, 'index']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/service', [ServiceController::class, 'index']);

    Route::get('/reverb-test', [ReverbTest::class, 'index']);

    Route::get('/conversation', [Conversation::class, 'index']);
});
