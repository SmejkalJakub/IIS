<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestCategoryController extends Controller
{

    public function create($test_id)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $categories = Category::all()->pluck('name', 'id');

        return view('test_category.create', compact('test_id', 'categories'));
    }

    public function show(Category $category, Question $question)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        return view('categories.show', compact( 'question'));
    }

    public function edit($test_id, $category_id)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }

        $test_category = TestCategory::all()->where('test_id', '=', $test_id)->where('category_id', '=', $category_id)->first();
        $categories = Category::all();
        $cat = $categories->where('id', '=', $test_category->category_id)->first();
        return view('test_category.edit', compact('test_id', 'category_id', 'test_category', 'categories', 'cat'));
    }

    public function store(Request $request, $test_id)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $test_category = new TestCategory();

        $test_category->category_id = $request->category_id;
        $test_category->test_id = $test_id;

        $test_category->number_of_questions = $request->number_of_questions;
        $test_category->save();
        Session::flash('message', 'Category questions created1 successfully');

        return redirect()->route('tests.edit', $test_id);
    }

    public function update(Request $request, $category_id, $test_id)
    {

        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }

        $test_category = TestCategory::all()->where('category_id', '=', $category_id)->where('test_id', '=', $test_id)->first();
        $test_category->number_of_questions = $request->number_of_questions;
        $test_category->update();

        Session::flash('message', 'Category questions updated successfully');
        return redirect()->route('tests.edit', $test_id);
    }


    public function destroy( $test_id, $category_id)
    {

        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $test_category = TestCategory::all()->where('test_id', '=', $test_id)->where('category_id', '=', $category_id)->first();
        $test_category->delete();
        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('tests.edit', [$test_id]);
    }
}
