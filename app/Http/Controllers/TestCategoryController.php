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
        //error_log("test in testcat create");
        //error_log($test);

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

    public function edit(Test $test, Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $categories = Category::all();
        $test_category = $test->categories->whereIn('id', $category->id)->first();


        return view('test_category.edit', compact('test_category', 'categories', 'test'));
    }

    public function store(Request $request, Test $test)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $categoryQuestionNumber = Question::all()->whereIn('category_id', $request->category_id)->count();

        if($categoryQuestionNumber < $request->number_of_questions) {
            return redirect()->back()->withErrors(['error' => 'Number of questions is bigger than the actual number of questions in selected category']);

        }

        if($test->categories->find($request->category_id))
        {
            $test->categories()->detach($request->category_id);
        }
        $test->categories()->attach($request->category_id, ['number_of_questions' => $request->number_of_questions]);

        Session::flash('message', 'Category questions created successfully');

        return redirect()->route('tests.edit', $test->id);
    }

    public function update(Request $request, Test $test, $category_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $categoryQuestionNumber = Question::all()->whereIn('category_id', $category_id)->count();

        if($categoryQuestionNumber < $request->number_of_questions) {
            return redirect()->back()->withErrors(['error' => 'Number of questions is bigger than the actual number of questions in selected category']);

        }

        $test->categories()->detach($category_id);
        $test->categories()->attach($category_id, ['number_of_questions'=>$request->number_of_questions]);


        Session::flash('message', 'Category questions updated successfully');
        return redirect()->route('tests.edit', $test->id);
    }


    public function destroy($test_id, $category_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $test = Test::find($test_id);
        $test->categories()->detach($category_id);

        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('tests.edit', [$test_id]);
    }
}
