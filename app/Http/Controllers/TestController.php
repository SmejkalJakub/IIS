<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        $test_categories = TestCategory::all();
        $categories = Category::all();
        return view('tests.index', compact('tests', 'test_categories', 'categories'));
    }

    public function create()
    {
        return view('tests.create');
    }

    public function edit(Test $test)
    {
        $categories = TestCategory::all()->where('test_id', '=', $test->id);
        return view('tests.edit', compact('test', 'categories'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:tests|max:128',
                'description' => 'required|max:1024',
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Test already exists',
            ]
        );

        $test = new Test();
        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $request->max_duration;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        Session::flash('message', 'Test created successfully');
        return redirect()->route('tests');
    }

    public function update(Request $request, Test $test)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:tests,name,' . $test->id,
                'description' => 'required|max:1024',
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Test already exists',

            ]
        );

        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $request->max_duration;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        Session::flash('message', 'Test updated successfully');
        return redirect()->route('tests');
    }


    public function destroy(Test $test)
    {

        $test->delete();
        Session::flash('delete-message', 'Test deleted successfully');
        return redirect()->route('tests.index');
    }
}
