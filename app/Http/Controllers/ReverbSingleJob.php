<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReverbSingleJob
{

//    public function __construct()
//    {
//        dd(csrf_token());
//    }

    public function index()
    {
        return view('reverb.single.job');
    }

}
