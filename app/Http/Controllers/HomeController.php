<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;


class HomeController extends Controller
{
    public function index()
    {
        $tests = Test::all();

        return view('home', compact('tests'));
    }
}
