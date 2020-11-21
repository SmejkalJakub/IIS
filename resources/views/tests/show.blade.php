<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container-full-width">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session('message') }}
        </div>
    @endif

    @if(Session::has('delete-message'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session('delete-message') }}
        </div>
    @endif
</div>

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a role="button" class="btn btn-secondary" href="{{route('tests..', [$role, $filter])}}">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$test->name}}</span></h2>
        </div>
        <div class="col-sm-2">
            @if (Auth::user() != null && Auth::user()->hasRole('profesor') && Auth::id() == $test->creator_id)
                <a href="{{ route('tests....edit', [$role, $filter, 'detail', $test->id]) }}"
                   class="btn btn-success float-right">Edit</a>
            @endif
        </div>
    </div>

    <?php
        $total_max_test_points = 0;
        $total_num_of_questions = 0;

        foreach($test_categories as $test_category)
        {
            $num_of_questions = $test_category->pivot->number_of_questions;

            $total_max_test_points += ($test_category->max_points * $num_of_questions);
            $total_num_of_questions += $num_of_questions;
        }
    ?>

    <div class="p-3 border rounded">
        @include('tests.testInfo', ['total_max_test_points' => $total_max_test_points, 'total_num_of_questions' => $total_num_of_questions, 'test' => $test])
        <div class="d-flex">
            @if($total_max_test_points != 0)
                @if(App\Http\Helpers\SignApplyHelper::my_sign_is_signed($test, 0))
                    <a role="button" href="{{route('sign_on.test..destroy', [$test->id, Auth::id(), '0'])}}" onclick="return confirm('Are you sure you want sign off?')" class="btn mr-2 btn-sm btn-danger">Sign off</a>
                @else
                    <a role="button" href="{{route('new..sign', [$test->id, '0'])}}" class="btn mr-2 btn-sm btn-success">Sign on</a>
                @endif
            @endif

            @if(Auth::user()->hasRole('assistant') && App\Http\Helpers\SignApplyHelper::my_sign_is_signed($test, 1))
                <a role="button" href="{{route('sign_on.test..destroy', [$test->id, Auth::id(), '1'])}}" style="background-color: #EB5910" onclick="return confirm('Are you sure you want sign off?')" class="btn btn-sm text-white">Sign off as assistant</a>
            @else
                <a role="button" href="{{route('new..sign', [$test->id, '1'])}}" class="btn btn-sm btn-info">Sign on as assistant</a>
            @endif
        </div>

        <div class="border rounded mt-4 p-3">
            <h3 class="text-center mb-3" style="color: #373737">Categories</h3>

            <div class="table-responsive">
                <table class="table table-bordered mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Number of questions</th>
                        <th>Points per question</th>
                        <th>Total points from category</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($test_categories as $test_category)
                            <tr>
                                <td>{{$test_category->name}}</td>
                                <td>{{$test_category->max_points}}</td>
                                <td>{{$test_category->pivot->number_of_questions}}</td>
                                <td>{{$test_category->max_points * $test_category->pivot->number_of_questions}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(Auth::user() != null && Auth::user()->hasRole('profesor') && Auth::id() == $test->creator_id)
        <div class="p-3 mt-4 rounded border">
            <h3 class="text-center mb-3" style="color: #373737">Assistants</h3>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($test_applies as $apply)
                            @if($apply->correction == true)
                                <?php
                                    $user = App\Models\User::all()->whereIn('id', $apply->applier_id)->first();
                                ?>

                                <tr>
                                    <td>{{ $user->first_name}} {{ $user->surname}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            @if($apply->authorizer_id != null)
                                                <a href="{{ route('sign_on.test..un_confirm',  [$test->id, $user->id, $apply->correction]) }}" class="btn btn-sm text-white" style="background-color: #EB5910">Deny</a>
                                            @else
                                                <a href="{{ route('sign_on.test..confirm',  [$test->id, $user->id, $apply->correction]) }}" class="btn btn-sm btn-success">Confirm</a>
                                            @endif

                                            {!! Form::open(['route' => ['sign_on.test..destroy', [$test->id, $user->id, $apply->correction]], 'method' => 'get', 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Remove', ['class' => 'btn ml-2 btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want sign off?\')']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if (Auth::user() != null && ((Auth::user()->hasRole('assistant') && App\Http\Helpers\SignApplyHelper::my_sign_is_confirmed($test, 1)) || (Auth::user()->hasRole('profesor') && Auth::id() == $test->creator_id)))
        <div class="p-3 mt-4 rounded border">
            <h3 class="text-center mb-3" style="color: #373737">Students</h3>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($test_applies as $apply)
                        @if($apply->correction == false)
                            <?php
                            $user = App\Models\User::all()->whereIn('id', $apply->applier_id)->first();
                            ?>

                            <tr>
                                <td>{{ $user->first_name}} {{ $user->surname}}</td>
                                <td>{{$user->role}}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        @if($apply->authorizer_id != null)
                                            <a href="{{ route('sign_on.test..un_confirm',  [$test->id, $user->id, $apply->correction]) }}" class="btn btn-sm text-white" style="background-color: #EB5910">Deny</a>
                                        @else
                                            <a href="{{ route('sign_on.test..confirm',  [$test->id, $user->id, $apply->correction]) }}" class="btn btn-sm btn-success">Confirm</a>
                                        @endif

                                        {!! Form::open(['route' => ['sign_on.test..destroy', [$test->id, $user->id, $apply->correction]], 'method' => 'get', 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Remove', ['class' => 'btn ml-2 btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want sign off?\')']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</body>
</html>

