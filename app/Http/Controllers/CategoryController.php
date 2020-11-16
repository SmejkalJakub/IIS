<?php

namespace App\Http\Controllers;

use App\Item;
use App\Models\Category;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }
        $categories = Category::all();
        foreach ($categories as $category) {

            if ($category->name == "") {
                $category->delete();
                continue;
            }
            $number_of_questions = 0;

            $category->setAttribute('number_of_questions', $number_of_questions);

            $questions = $category->questions;

            foreach ($questions as $q) {
                $number_of_questions += 1;
            }

            $category->setAttribute('number_of_questions', $number_of_questions);


        }
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }

        $questions = Question::all()->where('category_id', '=', $category->id);
        return view('categories.show', compact('category', 'questions'));
    }

    public function create()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $questions = Question::all()->where('questions');
        return view('categories.create', compact('questions'));
    }

    public function edit(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $questions = $category->questions;

        return view('categories.edit', compact('category', 'questions'));
    }

    public function store(Request $request)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:categories|max:128',
                'max_points' => 'required|gte:1|lte:100'
            ],
        );

        $category = new Category();


        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category created successfully');
        return redirect()->route('categories');
    }

    public function update(Request $request, Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:categories,name,' . $category->id,
                'max_points' => 'required|gte:1|lte:100'
            ],

        );

        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category updated successfully');
        return redirect()->route('categories');
    }


    public function destroy(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $category->delete();
        Session::flash('delete-message', 'Category deleted successfully');
        return redirect()->route('categories');
    }
}
