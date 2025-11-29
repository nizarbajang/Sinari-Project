<?php

namespace App\Http\Controllers;

class FarmerController extends Controller
{
    public function dashboard(){
        return view('farmer.dashboard');
    }

}
