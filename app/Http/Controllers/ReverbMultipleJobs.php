<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReverbMultipleJobs
{
    public function index() : View
    {
        return view('reverb/multiple/jobs');
    }
}
