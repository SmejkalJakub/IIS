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
        if(Auth::user()->role != 'profesor' && Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $categories = Category::all();
        $questions_cids = Question::all()->pluck('category_id');
        error_log('\n\n\n\n\n');
        error_log($questions_cids);

        return view('categories.index', compact('categories', 'questions_cids'));
    }

    public function show(Category $category)
    {
        $questions = Question::all()->where('category_id', '=', $category->id);
        return view('categories.show', compact('category', 'questions'));
    }

    public function create()
    {
        $questions = Question::all()->where('questions');
        return view('categories.create', compact('questions'));
    }

    public function edit(Category $category)
    {
        $questions = Question::all()->where('category_id', '=', $category->id);
        return view('categories.edit', compact('category', 'questions'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:categories|max:128',
                'max_points' => 'required|min:1|lt:101|gt:0'
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Category already exists',
                'max_points.required' => 'Enter number of points!'
            ]
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
        /*
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
*/
        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category updated successfully');
        return redirect()->route('categories');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        Session::flash('delete-message', 'Category deleted successfully');
        return redirect()->route('categories');
    }
}
