<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{

    public function create()
    {
        return view('questions.create');
    }

    public function edit(Question $cquestion)
    {
        return view('questions.edit', compact('questions'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|unique:questions|max:128',
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'required|max:512',
                'type' => 'required',

                'option_1' => 'max:255',
                'option_2' => 'max:255',
                'option_3' => 'max:255',
                'option_4' => 'max:255',
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Categories already exist',
            ]
        );

        $question = new Question();

        $question->user_id = Auth::id();
        $question->name = $request->name;
        $question->right_answer = $request->right_answer;
        $question->type = $request->type;

        $question->task = $request->task;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;
        $question->image_path = '\no-image-100.png';


        /*Pre-saving to get CATEGORY_ID required for creating folder structure by imageSave function*/
        $question->save();

        Session::flash('message', 'Question created successfully');
        return redirect()->route('categories.index');
    }

    public function update(Request $request, Question $question)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:questions,name,' . $question->id,
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'required|max:512',
                'type' => 'required',

                'option_1' => 'max:255',
                'option_2' => 'max:255',
                'option_3' => 'max:255',
                'option_4' => 'max:255',
                ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Question already exist',
            ]
        );

        $question->user_id = Auth::id();
        $question->name = $request->name;
        $question->right_answer = $request->right_answer;
        $question->type = $request->type;

        $question->task = $request->task;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;


        $question->save();

        Session::flash('message', 'Question updated successfully');
        return redirect()->route('categories.index');
    }


    public function destroy(Question $question)
    {
           $question->delete();

        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('questions.index');
    }
}
