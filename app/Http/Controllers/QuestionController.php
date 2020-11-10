<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{

    public function create($category_id)
    {
        return view('questions.create')->with('category_id', $category_id);

    }

    public function show(Category $category, Question $question)
    {
        return view('categories.show', compact( 'question'));
    }

    public function edit( $category_id, Question $question)
    {
        return view('questions.edit', compact('question', 'category_id'));
    }

    public function store(Request $request, $category_id)
    {

       /* $this->validate(
            $request,
            [
                'name' => 'required|unique:questions|max:128',
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'required|max:512',
                'type' => 'required',

                'option_1' => ['nullable','max:255'],
                'option_2' => ['nullable','max:255'],
                'option_3' => ['nullable','max:255'],
                'option_4' => ['nullable','max:255'],
            ],
            [
                'name.required' => 'Enter name',
                'name.unique' => 'Categories already exist',
                'type.required' => 'Choose a file.',
                'right_answer.required' => 'Fill up right answer.',
            ]
        );*/

        $question = new Question();
        $question->category_id = $category_id;

        $question->name = $request->name;
        $question->right_answer = $request->right_answer;
        $question->type_of_answer = $request->type_of_answer;

        $question->task = $request->task;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;
        $question->image_path = $request->icon;


        $question->save();

        Session::flash('message', 'Question created successfully');
        return redirect()->route('categories.edit', $category_id);
    }

    public function update(Request $request, $category_id, Question $question)
    {
        /*$this->validate(
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
        );*/

        $question->name = $request->name;
        $question->right_answer = $request->right_answer;
        $question->type_of_answer = $request->type_of_answer;
        $question->category_id = $category_id;

        $question->task = $request->task;
        $question->option_1 = $request->option_1;
        $question->option_2 = $request->option_2;
        $question->option_3 = $request->option_3;
        $question->option_4 = $request->option_4;
        $question->image_path = $request->icon;

        $question->save();

        Session::flash('message', 'Question updated successfully');
        return back();
    }


    public function destroy($category_id, Question $question)
    {
        $question->delete();

        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('categories.edit', $category_id);
    }
}
