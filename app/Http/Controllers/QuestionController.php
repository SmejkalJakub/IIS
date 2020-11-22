<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    use UploadTrait;

    public function create($category_id)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }
        return view('questions.create')->with('category_id', $category_id);

    }

    public function show(Category $category, Question $question)
    {
        if (!AuthController::checkUser('assistant')) {
            return redirect()->route('home');
        }
        return view('questions.show', compact('question', 'category'));
    }

    public function edit($category_id, Question $question)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        return view('questions.edit', compact('question', 'category_id'));
    }

    public function store(Request $request, $category_id)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        $validation_array =
            [
                'name' => 'required|max:128',
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


        if ($request->has('image_path')) {
            // Get image file
            $image = $request->file('image_path');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('question_name')).'_'.time();
            // Define folder path
            $folder = '/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();;
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $question->image_path = $filePath;
        }

        request()->validate($validation_array);
        $question->save();

        Session::flash('message', 'Question created successfully');

        return redirect()->route('categories.edit', $category_id);
    }

    public function update(Request $request, $category_id, $question_id)
    {
        $question = Question::all()->find($question_id);
        $old_image = $question->image_path;
        error_log($old_image);
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }
        $validation_array =
            [
                'name' => 'required | max:128',
                'task' => 'required | max:512',
                'right_answer' => 'max:512',
                'type_of_answer' => 'required',
                'option_1' => 'nullable | max:255',
                'option_2' => 'nullable | max:255',
                'option_3' => 'nullable | max:255',
                'option_4' => 'nullable | max:255',
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


        if ($request->has('image_path')) {
            // Get image file
            $image = $request->file('image_path');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('question_name')).'_'.time();
            // Define folder path
            $folder = '/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]

            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();;
            // Delete old one
            error_log($old_image);
            $this->deleteOne('public', $old_image);
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $question->image_path = $filePath;
        }
        request()->validate($validation_array);
        $question->save();


        Session::flash('message', 'Question updated successfully');
        return redirect()->route('categories.edit', [$category_id]);
    }


    public function destroy($category_id, Question $question)
    {
        $question->delete();

        Session::flash('delete - message', 'Question deleted successfully');
        error_log("jsemtu");
        return redirect()->route('categories.edit', $category_id);
    }
}
