<?php

namespace App\Services;

class ExampleService
{
    public function getGreeting(string $name = 'World'): string
    {
        return "Hello, {$name}!";
    }
}


