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
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        return view('questions.create')->with('category_id', $category_id);

    }

    public function show(Category $category, Question $question)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('assistant'))
        {
            return redirect()->route('home');
        }
        return view('questions.show', compact( 'question', 'category'));
    }

    public function edit( $category_id, Question $question)
    {
        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        return view('questions.edit', compact('question', 'category_id'));
    }

    public function store(Request $request, $category_id)
    {

        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }

        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:questions,name,' ,
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'required|max:512',
                'type_of_answer' => 'required',
                'option_1' => 'nullable|max:255',
                'option_2' => 'nullable|max:255',
                'option_3' => 'nullable|max:255',
                'option_4' => 'nullable|max:255',
            ],
        );

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

        if(Auth::user() == null || !Auth::user()->hasRole('profesor'))
        {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:questions,name,' . $question->id,
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'required|max:512',
                'type_of_answer' => 'required',
                'option_1' => 'nullable|max:255',
                'option_2' => 'nullable|max:255',
                'option_3' => 'nullable|max:255',
                'option_4' => 'nullable|max:255',
                ],

        );
        error_log("ulozeno");

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
        return redirect()->route('categories.questions.show', [$category_id, $question->id]);
    }


    public function destroy($category_id, Question $question)
    {
        $question->delete();

        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('categories.edit', $category_id);
    }
}
