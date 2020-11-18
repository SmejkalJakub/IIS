<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TestInstance;
use Illuminate\Support\Facades\Auth;



class TestInstanceCorrectionController extends Controller
{

    function checkAuth($assistant_id)
    {
        if($assistant_id != Auth::id())
        {
            return false;
        }
        return true;
    }
    public function index($instance_id)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if($instance->assistant->id == Auth::id())
        {
            return $this->question($instance_id, 0);
        }

        return view('tests.instance.correction.index', compact('instance'));
    }

    public function question($instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();


        if(!$this->checkAuth($instance->assistant_id))
        {
            return view('home');
        }

        $question = $instance->instances_questions[$question_index];

        $currentQuestion = $question_index;

        return view('tests.instance.correction.question', compact('question', 'instance', 'currentQuestion'));

    }

    public function startCorrection($instance_id)
    {
        $instance = TestInstance::where('id', $instance_id)->first();
        if($instance->assistant == null)
        {
            $instance->assistant_id = Auth::id();
            $instance->update();
            return $this->question($instance_id, 0);
        }
        else if($instance->assistant->id == Auth::id())
        {
            return $this->question($instance_id, 0);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function saveCorrection(Request $request, $instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if(!$this->checkAuth($instance->assistant_id))
        {
            return view('home');
        }

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
