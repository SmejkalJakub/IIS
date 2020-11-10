<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\Models\Category;



class CategoriesController extends Controller
{
    public function showCategories()
    {
        if(!Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }
}
