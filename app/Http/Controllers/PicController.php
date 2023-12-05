<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PicController extends Controller
{
    function index(){
        return view('PIC.index');
    }
}
