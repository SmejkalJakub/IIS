<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function index()
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }
        $tests = Test::all();

        foreach ($tests as $test) {

            $points_per_test = 0;
            $test_cats = $test->categories;
            $test->setAttribute('max_points', $points_per_test);

            foreach ($test_cats as $test_cat) {

                $points_per_test += $test_cat->max_points * $test_cat->pivot->number_of_questions;

            }
            $test->setAttribute('max_points', $points_per_test);

        }

        return view('tests.index', compact('tests'));
    }

    public function show(Test $test)
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }

        $test_categories = $test->categories;
        return view('tests.show', compact('test', 'test_categories'));
    }

    public function create()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }



        return view('tests.create');
    }

    public function edit(Test $test)
    {

        $points_per_test = 0;
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $test_categories = $test->categories;

        $test->setAttribute('max_points', $points_per_test);

        foreach ($test_categories as $test_cat) {

            $points_per_test += $test_cat->max_points * $test_cat->pivot->number_of_questions;
        }
        $test->setAttribute('max_points', $points_per_test);

        //error_log($test_categories);
        return view('tests.edit', compact('test', 'test_categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
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

        if (strtotime($request->available_from) - strtotime($request->available_to) >= 0) {
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
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
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

        if (strtotime($request->available_from) - strtotime($request->available_to) >= 0) {
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
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $test->delete();
        Session::flash('delete-message', 'Test deleted successfully');
        return redirect()->route('tests');
    }
}
