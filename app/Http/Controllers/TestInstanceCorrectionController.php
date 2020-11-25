<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestInstance;
use Illuminate\Support\Facades\Auth;


class TestInstanceCorrectionController extends Controller
{

    function checkAuth($assistant_id)
    {
        if ($assistant_id != Auth::id()) {
            return false;
        }
        return true;
    }

    public function index($from ,$instance_id)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if ($instance->assistant == null)
        {
            $instance->assistant_id = Auth::id();
            $instance->update();
            return $this->question($from, $instance_id, 0);
        }
        else if ($instance->assistant->id == Auth::id())
        {
            return $this->question($from, $instance_id, 0);
        }
        else
        {
            return redirect()->back();
        }

    }

    public function question($from ,$instance_id, $question_index)
    {

        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if (!$this->checkAuth($instance->assistant_id)) {
            return view('home');
        }

        $question = $instance->instances_questions[$question_index];

        $currentQuestion = $question_index;

        return view('tests.instance.correction.question', compact('from','question', 'instance', 'currentQuestion'));

    }


    public function endReview($from, $instance_id)
    {
        $instance = TestInstance::all()->where('id', '=',$instance_id)->first();

        $instance->corrected = true;
        $instance->update();

        $test = $instance->test;
        $list_type = 0;

        if($from == 'history')
        {
            $list_type = Auth::id();
        }
        elseif(count($test->instances->where('corrected', '1')) == count($test->instances))
        {
            return redirect()->route('tests..', ['assistant', 'active']);
        }

        return redirect()->route('tests..instance.', [$from , $test->id, $list_type]);
    }

    public function saveCorrection(Request $request, $from, $instance_id, $question_index)
    {
        $instance = TestInstance::all()->whereIn('id', $instance_id)->first();

        if (!$this->checkAuth($instance->assistant_id)) {
            return view('home');
        }

        $question = $instance->instances_questions[$question_index];

        $instance->instances_questions()->updateExistingPivot($question->id, ['points' => $request->points, 'comment' => $request->comment]);

        switch ($request->input('action')) {
            case 'Save':
                return $this->question($from, $instance_id, $question_index);
                break;
            case 'Save and next':
                return $this->question($from, $instance_id, $question_index + 1);
                break;
            case 'Save and previous':
                return $this->question($from, $instance_id, $question_index - 1);
                break;
            case 'Save and end revision':
                return $this->endReview($from, $instance_id);
                break;
        }
    }
}
