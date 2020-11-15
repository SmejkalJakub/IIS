<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\TestCategory;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestCategoryController extends Controller
{

    public function create(Test $test)
    {
        error_log("test in testcat create");
        error_log($test);

        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $categories = Category::all()->pluck('name', 'id');


        return view('test_category.create', compact('test', 'categories'));
    }

    public function show(Category $category, Question $question)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        return view('categories.show', compact('question'));
    }

    public function edit($test_category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $categories = Category::all();
        error_log("here");
        error_log($test_category);

        return view('test_category.edit', compact('test_category', 'categories'));
    }

    public function store(Request $request, Test $test)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $test->categories()->attach($request->category_id, ['number_of_questions' => $request->number_of_questions]);

        Session::flash('message', 'Category questions created1 successfully');

        return redirect()->route('tests.edit', $test->id);
    }

    public function update(Request $request, $test)
    {

        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $test->categories()->sync($request->category_id, ['number_of_questions' => $request->number_of_questions]);


        Session::flash('message', 'Category questions updated successfully');
        return redirect()->route('tests.edit', $test->id);
    }


    public function destroy($test_id, $category_id)
    {

        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $test_category = TestCategory::all()->where('test_id', '=', $test_id)->where('category_id', '=', $category_id)->first();
        $test_category->delete();
        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('tests.edit', [$test_id]);
    }
}
