<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TestInstance;
Use App\Models\User;
Use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class TestInstanceController extends Controller
{

    function checkAuth($student_id)
    {
        if($student_id != Auth::id())
        {
            return false;
        }
        return true;
    }
    public function create( $test_id)
    {
        $now = strtotime(now());
        $test = Test::all()->whereIn('id', $test_id)->first();


        if (($now > strtotime($test->available_to)) || $now < strtotime($test->available_from)) {

            return redirect()->back();
        }

        $instance = TestInstance::all()->whereIn('test_id', $test->id)->whereIn('student_id', Auth::id())->first();


        if ($instance != null) {

            sscanf($test->max_duration, "%d:%d", $hours, $minutes);
            $duration = isset($hours) ? $hours * 3600 + $minutes * 60 : $minutes * 60;

            $time_between_now_start = $now - strtotime($instance->opened_at);
            error_log($duration - $time_between_now_start);
            if ($duration - $time_between_now_start > 0) {
                return $this->question($instance->id, 0);
            } else {
                return redirect()->back();
            }
        }


        $instance = new TestInstance();
        $instance->test_id = $test->id;
        $instance->student_id = Auth::id();
        $instance->opened_at = now();
        $instance->assistant_id = null;
        $instance->save();

        $categories = $instance->test->categories;

        foreach ($categories as $category) {
            $allQuestions = $category->questions;
            $allQuestions = $allQuestions->shuffle();

            for ($i = 0;
                 $i < $category->pivot->number_of_questions;
                 $i++) {
                $instance->instances_questions()->attach($allQuestions[$i], ['answer' => '', 'points' => null]);
            }
        }

        return view('tests.instance.index', compact('instance'));
    }

    public function saveQuestion(Request $request, $instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if(!$this->checkAuth($instance->student_id))
        {
            return view('home');
        }

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

        if(!$this->checkAuth($instance->student_id))
        {
            return view('home');
        }

        return view('tests.instance.end', compact('instance'));
    }

    public function question($instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();
        $now = strtotime(now());


        if(!$this->checkAuth($instance->student_id))
        {
            return view('home');
        }

        if ($instance != null) {

            sscanf($instance->test->max_duration, "%d:%d", $hours, $minutes);
            $duration = isset($hours) ? $hours * 3600 + $minutes * 60 : $minutes * 60;

            $time_between_now_start = $now - strtotime($instance->opened_at);
            error_log($duration - $time_between_now_start);
            if ($duration - $time_between_now_start <= 0) {
                return view('tests.instance.end', compact('instance'));
            }
        }

        $instance_questions = $instance->instances_questions;

        if (count($instance_questions) > 0) {

            $question = $instance_questions[$question_index];
            $currentQuestion = $question_index;

            return view('tests.instance.question', compact('question', 'instance', 'currentQuestion'));
        } else {
            return view('tests.index');
        }

    }
}
