<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TestInstance;


class TestInstanceCorrectionController extends Controller
{
    public function index($instance_id)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();
        return view('tests.instance.correction.index', compact('instance'));
    }

    public function question($instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        $question = $instance->instances_questions[$question_index];

        $currentQuestion = $question_index;

        return view('tests.instance.correction.question', compact('question', 'instance', 'currentQuestion'));

    }

    public function saveCorrection(Request $request, $instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        $question = $instance->instances_questions[$question_index];

        $instance->instances_questions()->updateExistingPivot($question->id, ['points' => $request->points]);

        switch($request->input('action')) {
            case 'Save':
                return $this->question($instance_id, $question_index);
                break;
            case 'Save and Next':
                return $this->question($instance_id, $question_index + 1);
                break;
            case 'Save and Previous':
                return $this->question($instance_id, $question_index - 1);
                break;
            case 'Save and End Test':
                return $this->endTest($instance_id);
                break;
        }
    }
}
