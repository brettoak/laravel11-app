<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReverbSingleJob
{

    public function index(): View
    {
        return view('reverb.single.job');
    }
    
}
