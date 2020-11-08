<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'profesor' && Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:categories|max:128',
                'max_points' => 'required|min:1|max:100'
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Category already exists',
                'max_points.required' => 'Enter number of points!'
            ]
        );

        $category = new Category();

        $category->user_id = Auth::id();

        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();


        Session::flash('message', 'Category created successfully');
        return redirect()->route('categories.index');
    }

    public function update(Request $request, Category $category)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:categories,name,' . $category->id,
                'max_points' => 'required|min:1|max:100'

            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Category already exists',
                'max_points.required' => 'Enter number of points!'

            ]
        );

        $category->user_id = Auth::id();
        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category updated successfully');
        return redirect()->route('categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        Session::flash('delete-message', 'Category deleted successfully');
        return redirect()->route('categories.index');
    }
}
