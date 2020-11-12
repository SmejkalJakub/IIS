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
        if(Auth::user() == null || !Auth::user()->hasRole('student'))
        {
            return redirect()->route('home');
        }
        $tests = Test::all();
        $test_categories = TestCategory::all();
        $categories = Category::all();
        return view('tests.index', compact('tests', 'test_categories', 'categories'));
    }
    public function show(Test $test)
    {
        $test_categories = TestCategory::all()->where('test_id', '=', $test->id);
        return view('tests.show', compact('test', 'test_categories'));
    }

    public function create()
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        return view('tests.create');
    }

    public function edit(Test $test)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        error_log($test->available_from);
        $categories = TestCategory::all()->where('test_id', '=', $test->id);
        return view('tests.edit', compact('test', 'categories'));
    }

    public function store(Request $request)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:tests|max:128',
                'description' => 'required|max:1024',
                'available_from' => 'required',
                'available_to' => 'required',
                'max_duration' => 'required',
            ]
        );

        if(strtotime($request->available_from) - strtotime($request->available_to) >= 0){
            Session::flash('delete-message', 'Test available from must be before available to');
            return redirect()->route('tests.create');
        }



        $test = new Test();
        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $request->max_duration;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        return redirect()->route('tests');
    }

    public function update(Request $request, Test $test)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:tests,name,' . $test->id,
                'description' => 'required|max:1024',
                'available_from' => 'required',
                'available_to' => 'required',
                'max_duration' => 'required',
            ]
        );

        if(strtotime($request->available_from) - strtotime($request->available_to) >= 0){
            Session::flash('delete-message', 'Test available from must be before available to');
            return redirect()->route('tests.edit', $test->id);
        }


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
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }

        $test->delete();
        Session::flash('delete-message', 'Test deleted successfully');
        return redirect()->route('tests');
    }
}
