<?php

namespace App\Http\Controllers;

use App\Services\ExampleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ServiceController extends Controller
{
    public function index(Request $request, ExampleService $service)
    {
        $name = $request->query('name', 'World');
        $greeting = $service->getGreeting($name);
        Log::info('    Generated greeting: ' . $greeting);


        return view('service.index', [
            'greeting' => $greeting,
            'name' => $name,
        ]);
    }
}


