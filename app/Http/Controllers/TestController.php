<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SignApplyHelper;
use App\Models\Category;
use App\Models\Test;
use App\Models\SignOnTestApply;
use App\Models\TestInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function index($role, $filter)
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }

        return view('tests.index', compact('role', 'filter'));
    }

    public function show($role, $filter, $testId)
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }

        $test = Test::all()->where('id', '=', $testId)->first();

        if (AuthController::checkUser('assistant')) {
            $test_applies = $test->applies;
        } else {
            $test_applies = [];
        }

        $test_instances = $test->instances;

        $test_categories = $test->categories;
        return view('tests.show', compact('test', 'test_categories', 'test_applies', 'test_instances', 'role', 'filter'));
    }

    public function showInstances($from ,$test_id, $assistant_id)
    {
        $test = Test::all()->whereIn('id', $test_id)->first();

        $instances = $test->instances;

        if($assistant_id == 0)
        {
            $list_type = 'testInstances';
        }
        else
        {
            $instances = $instances->whereIn('assistant_id', $assistant_id);
            $list_type = 'myInstances';
        }

        foreach ($instances as $test_instance)
        {
            $result = 0;
            if($test_instance)
            {
                $test_questions = $test_instance->instances_questions;

                foreach($test_questions as $question)
                {
                    $result += $question->pivot->points;
                }
            }
            $test_instance->setAttribute('points', $result);
        }

        return view('tests.instance.list', compact('from', 'instances', 'list_type'));
    }

    public function showAllInstances($test_id)
    {
        $test = Test::all()->whereIn('id', $test_id)->first();

        $instances = $test->instances;

        foreach ($instances as $test_instance)
        {
            $result = 0;
            if($test_instance)
            {
                $test_questions = $test_instance->instances_questions;

                foreach($test_questions as $question)
                {
                    $result += $question->pivot->points;
                }
            }
            $test_instance->setAttribute('points', $result);
        }

        return view('tests.instance.allList', compact('instances'));
    }

    public function create()
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        return view('tests.create');
    }

    public function edit($role, $filter, $from, $testId)
    {

        $points_per_test = 0;
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        $test = Test::all()->where('id', '=', $testId)->first();

        $test_categories = $test->categories;

        foreach ($test_categories as $test_cat) {

            $points_per_test += $test_cat->max_points * $test_cat->pivot->number_of_questions;
        }

        $test->setAttribute('max_points', $points_per_test);

        return view('tests.edit', compact('test', 'test_categories', 'role', 'filter', 'from'));
    }

    public function store(Request $request)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:tests|max:128',
                'description' => 'required|max:1024',
                'available_from' => 'required',
                'available_to' => 'required',
                'max_duration' => 'required',
            ]
        );

        if (strtotime($request->available_from) - strtotime($request->available_to) >= 0) {
            Session::flash('delete-message', 'Test available from must be before available to');
            return redirect()->route('tests.create');
        }


        $test = new Test();
        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $request->max_duration;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        $apply = new SignOnTestApply();
        $apply->applier_id = Auth::id();
        $apply->test_id = $test->id;

        $apply->applied_datetime = now();

        $apply->correction = True;
        $apply->authorizer_id = Auth::id();
        $apply->confirmed_datetime = now();

        $apply->save();

        return redirect()->route('tests....edit', ['professor', 'myTests', 'list', $test->id]);
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $tests = Test::query()
                ->where('name','LIKE','%'.$request->search."%")
                ->orWhere('description','LIKE','%'.$request->search."%")
                ->orWhere('id','LIKE','%'.$request->search."%")
                ->get();

            $body="";

            if($tests)
            {
                foreach ($tests as $test)
                {
                    if($test->name == "")
                    {
                        $test->delete();
                        continue;
                    }

                    if($request->role == 'student')
                    {
                        if($request->filter == 'available')
                        {
                            $now = strtotime(now());
                            $test_end = strtotime($test->available_to);
                            //tests on which is user already signed
                            if(SignApplyHelper::my_sign_is_signed($test, false))
                            {
                                continue;
                            }
                            //test, which isnt possible to take
                            else if($now > $test_end){
                                continue;
                            }
                        }
                        else
                        {
                            $now = strtotime(now());
                            $test_start = strtotime($test->available_from);
                            $test_end = strtotime($test->available_to);

                            if($request->filter == 'registered')
                            {
                                if(!SignApplyHelper::my_sign_is_signed($test, false) or $now > $test_end or (SignApplyHelper::my_sign_is_confirmed($test, false) and $now >= $test_start))
                                {
                                    continue;
                                }
                            }
                            elseif($request->filter == 'active')
                            {
                                if(!SignApplyHelper::my_sign_is_confirmed($test, false) or $now < $test_start or $now >= $test_end)
                                {
                                    continue;
                                }
                                if(($instance = ($test->instances->where('student_id', '==', Auth::id())->first())))
                                {
                                    if($instance->ended == 1)
                                    {
                                        continue;
                                    }
                                }
                            }
                            else
                            {
                                $instance = $test->instances->where('student_id', '==', Auth::id())->first();
                                if($instance)
                                {
                                    if($instance->ended == 0)
                                    {
                                        if(!SignApplyHelper::my_sign_is_confirmed($test, false) or $now < $test_end)
                                        {
                                            continue;
                                        }
                                    }
                                }
                                else
                                {
                                    continue;
                                }
                            }
                        }
                    }
                    elseif($request->role == 'assistant' and AuthController::checkUser('assistant'))
                    {
                        if($request->filter == 'available')
                        {
                            if(SignApplyHelper::my_sign_is_signed($test, true))
                            {
                                continue;
                            }
                        }
                        else
                        {
                            $now = strtotime(now());
                            $test_end = strtotime($test->available_to);

                            $test_start = strtotime($test->available_from);


                            if($request->filter == 'registered')
                            {
                                if(!SignApplyHelper::my_sign_is_signed($test, true) or (SignApplyHelper::my_sign_is_confirmed($test, true) and $now >= $test_end))
                                {
                                    continue;
                                }
                                elseif(count($test->instances->where('assistant_id', '=', Auth::id())))
                                {
                                    continue;
                                }
                            }
                            elseif($request->filter == 'active')
                            {
                                if(!SignApplyHelper::my_sign_is_confirmed($test, true) or $now < $test_start)
                                {
                                    continue;
                                }
                            }
                            else
                            {
                                if(!SignApplyHelper::my_sign_is_confirmed($test, true))
                                {
                                    continue;
                                }
                                else if($test->instances->where('corrected', '==', '1')
                                        ->where('assistant_id', '==', Auth::id())->first() == null)
                                {
                                    continue;
                                }
                            }
                        }
                    }
                    elseif(AuthController::checkUser('profesor'))
                    {
                        if($test->creator_id != Auth::id())
                        {
                            continue;
                        }
                    }

                    $row = '';

                    $row .= '<tr><td style="vertical-align: middle">' . $test->name . '</td>';

                    if($request->role != 'professor')
                    {
                        $row .= '<td style="vertical-align: middle">' . $test->creator->first_name . ' ' . $test->creator->surname . '</td>';
                    }

                    if($request->role != 'assistant')
                    {
                        $points_per_test = 0;
                        $test_cats = $test->categories;

                        foreach ($test_cats as $test_cat)
                        {
                            $points_per_test += $test_cat->max_points * $test_cat->pivot->number_of_questions;
                        }

                        if($points_per_test == 0 && $request->role != 'professor')
                        {
                            continue;
                        }
                        $row .= '<td style="vertical-align: middle">' . $points_per_test . '</td>';
                    }

                    if($request->role == 'student')
                    {
                        if($request->filter == 'active')
                        {
                            $row .= '<td style="vertical-align: middle">' . $test->max_duration . '</td>';
                            $row .= '<td style="vertical-align: middle">' . $test->available_to . '</td>';
                        }
                        elseif($request->filter == 'history')
                        {
                            $test_instance = $test->instances->whereIn('student_id', Auth::id())->first();
                            $result = 0;

                            if($test_instance)
                            {
                                $test_questions = $test_instance->instances_questions;

                                foreach($test_questions as $question)
                                {
                                    $result += $question->pivot->points;
                                }
                            }

                            $row .= '<td style="vertical-align: middle">' . $result . '</td>';
                        }
                    }
                    elseif($request->role == 'assistant' and AuthController::checkUser('assistant'))
                    {
                        if($request->filter == 'active')
                        {
                            $correctedByMe = $test->instances->where('assistant_id', Auth::id())->where('corrected', '1');
                            $corrected = $test->instances->where('corrected', '1');
                            $numberOfInstances = count($test->instances);

                            if($numberOfInstances == count($corrected))
                            {
                                continue;
                            }

                            $row .= '<td style="vertical-align: middle">' . $numberOfInstances . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($corrected) . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($correctedByMe) . '</td>';
                        }
                        elseif($request->filter == 'history')
                        {
                            $correctedByMe = $test->instances->where('assistant_id', Auth::id())->where('corrected', '1');

                            $row .= '<td style="vertical-align: middle">' . count($test->instances) . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($correctedByMe) . '</td>';
                        }
                    }
                    elseif(AuthController::checkUser('profesor'))
                    {
                        $row .= '<td style="vertical-align: middle">' . $test->updated_at . '</td>';
                        $row .= '<td style="vertical-align: middle">' . count($test->applies->whereNotNull('confirmed_datetime')->whereIn('correction', '0')) . '</td>';
                        $row .= '<td style="vertical-align: middle">' . count($test->applies->whereNotNull('confirmed_datetime')->whereIn('correction', '1')) . '</td>';
                    }

                    if($request->filter == 'registered')
                    {
                        if($request->role == 'student')
                        {
                            $apply = \App\Http\Helpers\SignApplyHelper::my_sign_is_confirmed($test, false);
                        }
                        else
                        {
                            $apply = \App\Http\Helpers\SignApplyHelper::my_sign_is_confirmed($test, true);
                        }

                        if($apply)
                        {
                            $row .= '<td class="text-success font-weight-bold" style="vertical-align: middle">Approved</td>';
                        }
                        else
                        {
                            $row .= '<td class="text-secondary font-weight-bold" style="vertical-align: middle">Pending...</td>';
                        }
                    }

                    $row .= '<td><div class="d-flex justify-content-end">';

                    if($request->role == 'student')
                    {
                        if($request->filter == 'available')
                        {
                            $row .= '<a role="button" href="'.route('new..sign', [$test->id, '0']).'" class="btn btn-sm btn-success ">Sign on</a>';
                        }
                        elseif($request->filter == 'registered')
                        {
                            $row .= '<a role="button" href="'.route('sign_on.test..destroy', [$test->id, Auth::id(), '0']).'" onclick="return confirm(\'Are you sure you want sign off?\')" class="btn btn-sm btn-danger">Sign off</a>';
                        }
                        elseif($request->filter == 'active')
                        {
                            $row .= '<a href="'.route('test.preview', $test->id).'" role="button" class="btn btn-sm btn-success">Fill</a>';
                        }
                        else
                        {
                            $row .= '<a role="button" href="'.route('tests...results', ['student', $test->id, Auth::id()]).'" class="btn btn-sm btn-success">View result</a>';
                        }
                    }
                    elseif($request->role == 'assistant' and AuthController::checkUser('assistant'))
                    {
                        if($request->filter == 'available')
                        {
                            $row .= '<a role="button" href="'.route('new..sign', [$test->id, true]).'" class="btn btn-sm btn-success ">Sign on as assistant</a>';
                        }
                        elseif($request->filter == 'registered')
                        {
                            $row .= '<a role="button" href="'.route('sign_on.test..destroy', [$test->id, Auth::id(), true]).'" onclick="return confirm(\'Are you sure you want sign off?\')" class="btn btn-sm btn-danger">Sign off</a>';
                        }
                        elseif($request->filter == 'active')
                        {
                            $row .= '<a role="button" href="'.route('tests..instance.', ['active', $test->id, '0']).'" class="btn btn-sm btn-success">Revision</a>';
                        }
                        else
                        {
                            $row .= '<a role="button" href="'.route('tests..instance.', ['history', $test->id, Auth::id()]).'" class="btn btn-sm btn-success">My revisions</a>';
                        }
                    }
                    elseif(AuthController::checkUser('profesor'))
                    {
                        if(count($test->instances) != 0)
                        {
                            $row .= '<a href="'.route('test.all', [$test->id]).'" role="button" class="btn btn-sm btn-secondary">All instances</a>';
                        }

                        $row .= '<a href="'.route('tests....edit', [$request->role, $request->filter, 'list', $test->id]).'" role="button" class="btn btn-sm btn-success ml-2">Edit</a>';
                        $row .= '<form class="delete" action="'.route('tests.destroy', $test->id).'" method="POST" style="display:inline">'.
                            '<input type="hidden" name="_method" value="DELETE">'.
                            '<button type="submit" onclick="return confirm(\'Are you sure that you want to delete this test?\')" class="btn btn-sm btn-danger ml-2">Delete</button>'.
                            csrf_field().
                            '</form>';
                    }

                    $row .= '<a href="'.route('tests...show', [$request->role, $request->filter, $test->id]).'" role="button" class="btn btn-sm ml-2 btn-info">Detail</a>';
                    $row .= '</div></td>';
                    $row .= '</tr>';

                    $body .= $row;
                }
                return Response($body);
            }
        }
    }

    public function update(Request $request, $role, $filter, $from, $testId)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        $test = Test::all()->where('id', '=', $testId)->first();

        $max_duration_backup = $request->max_duration;

        sscanf($max_duration_backup, "%d:%d", $hours, $minutes);
        $max_duration = isset($hours) ? $hours * 3600 + $minutes * 60 : $minutes * 60;
        $time_between_from_to = strtotime($request->available_to) - strtotime($request->available_from);
        $request->request->add(['time_between' => $time_between_from_to]);
        $request->request->remove('max_duration');
        $request->request->add(['max_duration' => $max_duration]);

        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:tests,name,' . $test->id,
                'description' => 'required|max:1024',
                'available_from' => 'required|date',
                'available_to' => 'required|date|after:available_from',
                'max_duration' => 'required|int|lte:time_between',
            ],
            ['max_duration.lte' => 'Max duration must fit between available from and available to!']
        );

        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $max_duration_backup;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        Session::flash('message', 'Test updated successfully');

        if($from == 'list')
        {
            return redirect()->route('tests..', ['professor', 'myTests']);
        }
        else
        {
            return redirect()->route('tests...show', [$role, $filter, $test->id]);
        }
    }


    public function destroy(Test $test)
    {
        if (!AuthController::checkUser('profesor')) {
            return redirect()->route('home');
        }

        $test->delete();
        Session::flash('delete-message', 'Test deleted successfully');
        return redirect()->route('tests..', ['professor', 'myTests']);
    }
}
