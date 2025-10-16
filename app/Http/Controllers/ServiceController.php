<?php

namespace App\Http\Controllers;

use App\Services\ExampleService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request, ExampleService $service)
    {
        $name = $request->query('name', 'World');
        $greeting = $service->getGreeting($name);

        return view('service.index', [
            'greeting' => $greeting,
            'name' => $name,
        ]);
    }
}


