<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function index()
    {
        
        return view('welcome');
    }

}
