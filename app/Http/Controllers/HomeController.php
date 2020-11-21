<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    public function index()
    {
        if(Auth::user() == null)
        {
            return redirect()->route('/');
        }
        return view('home');
    }
}
