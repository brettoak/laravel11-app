<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

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





Route::get('/service', [ServiceController::class, 'index']);