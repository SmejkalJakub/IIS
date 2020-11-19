<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SignApplyHelper;
use App\Models\Category;
use App\Models\Test;
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

    public function show(Test $test)
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasRole('profesor')) {
            $test_applies = $test->applies;
        } elseif (Auth::user()->hasRole('assistant')) {
            $test_applies = $test->applies()->where('correction', '=', false);

        } else {
            $test_applies = [];
        }

        $test_instances = $test->instances;


        $test_categories = $test->categories;
        return view('tests.show', compact('test', 'test_categories', 'test_applies', 'test_instances'));
    }

    public function showInstances($test_id, $assistant_id)
    {
        if($assistant_id == 0) {
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

            $listType = 'testInstances';

            return view('tests.instance.list', compact('instances', 'listType'));
        }
        else
        {
            return $this->showMyInstances($test_id, $assistant_id);
        }
    }

    public function showMyInstances($test_id, $assistant_id)
    {
        $instances = TestInstance::all()->whereIn('test_id', $test_id)->whereIn('assistant_id', $assistant_id);

        $listType = 'myInstances';

        return view('tests.instance.list', compact('instances', 'listType'));
    }

    public function create()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        return view('tests.create');
    }

    public function edit(Test $test)
    {

        $points_per_test = 0;
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $test_categories = $test->categories;

        foreach ($test_categories as $test_cat) {

            $points_per_test += $test_cat->max_points * $test_cat->pivot->number_of_questions;
        }

        $test->setAttribute('max_points', $points_per_test);

        return view('tests.edit', compact('test', 'test_categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
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

        error_log('nvm');
        return redirect()->route('tests.edit', $test->id);
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
                            if($test->applies->where('correction', '==', '0')->where('applier_id', '==', Auth::id())->first())
                            {
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
                                if(($test->applies->where('correction', '==', '0')
                                        ->where('applier_id', '==', Auth::id())
                                        ->whereNull('authorizer_id')->first() == null or $now >= $test_end)
                                    and ($test->applies->where('correction', '==', '0')
                                            ->where('applier_id', '==', Auth::id())
                                            ->whereNotNull('authorizer_id')->first() == null or $now >= $test_start))
                                {
                                    continue;
                                }
                            }
                            elseif($request->filter == 'active')
                            {
                                if($test->applies->where('correction', '==', '0')
                                        ->where('applier_id', '==', Auth::id())
                                        ->whereNotNull('authorizer_id')->first() == null or $now < $test_start or $now >= $test_end)
                                {
                                    continue;
                                }
                            }
                            else
                            {
                                if($test->applies->where('correction', '==', '0')
                                        ->where('applier_id', '==', Auth::id())
                                        ->whereNotNull('authorizer_id')->first() == null or $now < $test_end)
                                {
                                    continue;
                                }
                            }
                        }
                    }
                    elseif($request->role == 'assistant' and Auth::user()->hasRole('assistant'))
                    {
                        if($request->filter == 'available')
                        {
                            if($test->applies->where('correction', '==', '1')->where('applier_id', '==', Auth::id())->first())
                            {
                                continue;
                            }
                        }
                        else
                        {
                            $now = strtotime(now());
                            $test_end = strtotime($test->available_to);

                            if($request->filter == 'registered')
                            {
                                if(($test->applies->where('correction', '==', '1')
                                            ->where('applier_id', '==', Auth::id())
                                            ->whereNull('authorizer_id')->first() == null)
                                    and ($test->applies->where('correction', '==', '1')
                                            ->where('applier_id', '==', Auth::id())
                                            ->whereNotNull('authorizer_id')->first() == null or $now >= $test_end))
                                {
                                    continue;
                                }
                            }
                            elseif($request->filter == 'active')
                            {
                                if($test->applies->where('correction', '==', '1')
                                        ->where('applier_id', '==', Auth::id())
                                        ->whereNotNull('authorizer_id')->first() == null or $now < $test_end)
                                {
                                    continue;
                                }
                            }
                            else
                            {
                                if($test->applies->where('correction', '==', '1')
                                        ->where('applier_id', '==', Auth::id())
                                        ->whereNotNull('authorizer_id')->first() == null or $now < $test_end)
                                {
                                    continue;
                                }
                            }
                        }
                    }
                    elseif(Auth::user()->hasRole('profesor'))
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
                    elseif($request->role == 'assistant' and Auth::user()->hasRole('assistant'))
                    {
                        if($request->filter == 'active')
                        {
                            $correctedByMe = TestInstance::all()->where('assistant_id', Auth::id())->where('corrected', '1');
                            $corrected = TestInstance::all()->where('corrected', '1');
                            $row .= '<td style="vertical-align: middle">' . count($test->instances) . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($corrected) . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($correctedByMe) . '</td>';
                        }
                        elseif($request->filter == 'history')
                        {
                            $correctedByMe = TestInstance::all()->where('assistant_id', Auth::id())->where('corrected', '1');

                            $row .= '<td style="vertical-align: middle">' . count($test->instances) . '</td>';
                            $row .= '<td style="vertical-align: middle">' . count($correctedByMe) . '</td>';
                        }
                    }
                    elseif(Auth::user()->hasRole('profesor'))
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
                            $row .= '<a href="'.route('test.create', $test->id).'" role="button" class="btn btn-sm btn-success">Start</a>';
                        }
                        else
                        {
                            $row .= '<a role="button" href="'.route('test..results', [$test->id, Auth::id()]).'" class="btn btn-sm btn-success">View result</a>';
                        }
                    }
                    elseif($request->role == 'assistant' and Auth::user()->hasRole('assistant'))
                    {
                        if($request->filter == 'available')
                        {
                            $row .= '<a role="button" href="'.route('new..sign', [$test->id, true]).'" class="btn btn-sm btn-success "> Sign on as assistant</a>';
                        }
                        elseif($request->filter == 'registered')
                        {
                            $row .= '<a role="button" href="'.route('sign_on.test..destroy', [$test->id, Auth::id(), true]).'" onclick="return confirm(\'Are you sure you want sign off?\')" class="btn btn-sm btn-danger">Sign off</a>';
                        }
                        elseif($request->filter == 'active')
                        {
                            $row .= '<a role="button" href="'.route('test.instances.', [$test->id, '0']).'" class="btn btn-sm btn-success">Revision</a>';
                        }
                        else
                        {
                            $row .= '<a role="button" href="'.route('test.instances.', [$test->id, Auth::id()]).'" class="btn btn-sm btn-success">My revisions</a>';
                        }
                    }
                    elseif(Auth::user()->hasRole('profesor'))
                    {
                        $row .= '<a href="'.route('tests.edit', $test->id).'" role="button" class="btn btn-sm btn-success">Edit</a>';
                        $row .= '<form class="delete" action="'.route('tests.destroy', $test->id).'" method="POST" style="display:inline">'.
                            '<input type="hidden" name="_method" value="DELETE">'.
                            '<button type="submit" onclick="return confirm(\'Are you sure that you want to delete this test?\')" class="btn btn-sm btn-danger ml-2">Delete</button>'.
                            csrf_field().
                            '</form>';
                    }

                    $row .= '<a href="'.route('tests.show', $test->id).'" role="button" class="btn btn-sm ml-2 btn-info">Detail</a>';
                    $row .= '</div></td>';
                    $row .= '</tr>';

                    $body .= $row;
                }
                return Response($body);
            }
        }
    }

    public function update(Request $request, Test $test)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:tests,name,' . $test->id,
                'description' => 'required|max:1024',
                'available_from' => 'required',
                'available_to' => 'required',
                'max_duration' => 'required',
            ]
        );

        sscanf($request->max_duration, "%d:%d", $hours, $minutes);
        $duration = isset($hours) ? $hours * 3600 + $minutes * 60  : $minutes * 60 ;

        $time_between_from_to = strtotime($request->available_to) - strtotime($request->available_from);

        if ($time_between_from_to <= 0) {
            Session::flash('delete-message', 'Test available from must be before available to');
            return redirect()->route('tests.edit', $test->id);
        }
        if ($time_between_from_to < $duration) {
            Session::flash('delete-message', 'Test duration must fit between available times');
            return redirect()->route('tests.edit', $test->id);
        }

        $test->creator_id = Auth::id();

        $test->name = $request->name;
        $test->description = $request->description;
        $test->max_duration = $request->max_duration;
        $test->available_to = $request->available_to;
        $test->available_from = $request->available_from;

        $test->save();

        Session::flash('message', 'Test updated successfully');

        return redirect()->route('tests..', ['professor', 'myTests']);
    }


    public function destroy(Test $test)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $test->delete();
        Session::flash('delete-message', 'Test deleted successfully');
        return redirect()->route('tests..', ['professor', 'myTests']);
    }
}
