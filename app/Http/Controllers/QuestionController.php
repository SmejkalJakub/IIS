<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class QuestionController extends Controller
{

    public function create($category_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        return view('questions.create')->with('category_id', $category_id);

    }

    public function show(Category $category, Question $question)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }
        return view('questions.show', compact('question', 'category'));
    }

    public function edit($category_id, Question $question)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        return view('questions.edit', compact('question', 'category_id'));
    }

    public function store(Request $request, $category_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $validation_array =
            [
                'name' => 'required|max:128|unique:questions,name,',
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'max:512',
                'type_of_answer' => 'required',
                'option_1' => 'nullable|max:255',
                'option_2' => 'nullable|max:255',
                'option_3' => 'nullable|max:255',
                'option_4' => 'nullable|max:255',
            ];

        $question = new Question();
        $question->category_id = $category_id;

        $question->name = $request->name;
        $question->type_of_answer = $request->type_of_answer;

        if ($request->type_of_answer == 1) {
            $question->right_text_answer = $request->right_answer;
        } else {
            error_log($request->right_option);
            $validation_array = array_merge($validation_array, [
                'right_option' => 'required',
            ]);
            $question->option_1 = $request->option_1;
            $question->option_2 = $request->option_2;
            $question->option_3 = $request->option_3;
            $question->option_4 = $request->option_4;
            $question->right_option = $request->right_option;
        }


        $question->task = $request->task;

        $question->image_path = 'no_image.png';
        if ($request->image_path != "") {
            $image = Image::make($request->image_path);
            $question->image_path = (strtotime(now())) . '.png';
            $image->save($question->image_path);
        }


        request()->validate($validation_array);

        $question->save();

        Session::flash('message', 'Question created successfully');
        return redirect()->route('categories.edit', $category_id);
    }

    public function update(Request $request, $category_id, Question $question)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $validation_array =
            [
                'name' => 'required|max:128|unique:questions,name,' . $question->id,
                'image_path' => ['nullable', 'regex:/^.*\.(png|jpeg|jpg|gif)+$/'],
                'task' => 'required|max:512',
                'right_answer' => 'max:512',
                'type_of_answer' => 'required',
                'option_1' => 'nullable|max:255',
                'option_2' => 'nullable|max:255',
                'option_3' => 'nullable|max:255',
                'option_4' => 'nullable|max:255',
            ];

        $question->name = $request->name;
        $question->type_of_answer = $request->type_of_answer;

        if ($request->type_of_answer == 1) {
            $question->right_text_answer = $request->right_answer;
        } else {
            $validation_array = array_merge($validation_array, [
                'right_option' => 'required',
            ]);
            $question->option_1 = $request->option_1;
            $question->option_2 = $request->option_2;
            $question->option_3 = $request->option_3;
            $question->option_4 = $request->option_4;
            $question->right_option = $request->right_option;
        }


        $question->task = $request->task;
        if ($request->image_path != "") {
            $image = Image::make($request->image_path);
            $question->image_path = (strtotime(now())) . '.png';
            $image->save($question->image_path);
        }
        request()->validate($validation_array);
        $question->save();


        Session::flash('message', 'Question updated successfully');
        return redirect()->route('categories.edit', [$category_id]);
    }


    public function destroy($category_id, Question $question)
    {
        $question->delete();

        Session::flash('delete-message', 'Question deleted successfully');
        return redirect()->route('categories.edit', $category_id);
    }
}
