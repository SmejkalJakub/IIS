<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TestInstance;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestInstanceController extends Controller
{
    public function create($test_id)
    {
        $instance = new TestInstance();
        $instance->test_id = $test_id;
        $instance->student_id = Auth::id();
        $instance->assistant_id = 1;
        $instance->save();

        $categories = $instance->test->categories;

        foreach ($categories as $category)
        {
            $allQuestions = $category->questions;
            $allQuestions = $allQuestions->shuffle();

            for($i = 0; $i < $category->pivot->number_of_questions; $i++)
            {
                $instance->instances_questions()->attach($allQuestions[$i], ['answer' => '', 'points' => 0]);
            }
        }

        return view('tests.instance.index', compact('instance'));
    }

    public function saveQuestion(Request $request, $instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        $question = $instance->instances_questions[$question_index];

        $instance->instances_questions()->updateExistingPivot($question->id, ['answer' => $request->answer]);

        switch($request->input('action')) {
            case 'Save':
                return $this->question($instance_id, $question_index);
            case 'Save and Next':
                return $this->question($instance_id, $question_index + 1);
            case 'Save and Previous':
                return $this->question($instance_id, $question_index - 1);
            case 'Save and End Test':
                return $this->endTest($instance_id);
        }
    }

    public function endTest($instance_id)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        return view('tests.instance.end', compact('instance'));
    }

    public function question($instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        $question = $instance->instances_questions[$question_index];

        $currentQuestion = $question_index;

        return view('tests.instance.question', compact('question', 'instance', 'currentQuestion'));

    }
}
