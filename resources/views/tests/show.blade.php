<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container">
    <div class="row">
        <div class="col">
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
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Test: {{$test->name}}

                        @if (!(Auth::user() == null || !Auth::user()->hasRole('profesor')))
                            <a href="{{ route('tests....edit', [$role, $filter, 'detail', $test->id]) }}"
                               class="btn btn-lg btn-primary align-middle float-right">Edit</a>
                        @endif
                        <a href="{{ route('sign_on_test.create', $test->id) }}"
                           class="btn btn-sm btn-primary">Sign on</a>
                    </h1>
                </div>


                <article>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-10 mx-auto">
                                <div>
                                    <h3>
                                        Description
                                    </h3>
                                    <h4>
                                        {{ $test->description }}
                                    </h4>
                                </div>

                                <div>
                                    <h3>
                                        Available from
                                    </h3>
                                    <h4>
                                        {{$test->available_from }}
                                    </h4>
                                </div>
                                <div>
                                    <h3>
                                        Available to
                                    </h3>
                                    <h4>
                                        {{$test->available_to}}
                                    </h4>
                                </div>
                                <div>
                                    <h3>
                                        Max duration
                                    </h3>
                                    <h4>
                                        {{$test->max_duration}}
                                    </h4>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h2>
                                            Questions of category
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <table style="text-align:center"
                                               class="sortable searchable table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Category name</th>
                                                <th scope="col">Points per question</th>
                                                <th scope="col">Number of questions</th>
                                                <th scope="col">Total points from category</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                                $total_max_test_points = 0;
                                            ?>
                                            @foreach($test_categories as $test_category)
                                                <tr>
                                                    <td>
                                                        {{ $test_category->id }}</a>

                                                    </td>

                                                    <td>
                                                        <?php
                                                            $total_max_test_points = $total_max_test_points + ($test_category->max_points * $test_category->pivot->number_of_questions);
                                                        ?>
                                                        {{ $test_category->name }}
                                                    </td>
                                                    <td>
                                                        {{$test_category->max_points}}
                                                    </td>
                                                    <td>
                                                        {{$test_category->pivot->number_of_questions}}
                                                    </td>
                                                    <td>
                                                        {{$test_category->max_points * $test_category->pivot->number_of_questions}}
                                                    </td>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div>
                                    <h3>
                                        Maximum points per test
                                    </h3>
                                    <h2>
                                        {{$total_max_test_points}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->hasRole('assistant'))
                        <div class="card-body">
                            <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Type of apply</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($test_applies as $apply)
                                    <tr>
                                        <?php
                                        $user = App\Models\User::all()->whereIn('id', $apply->applier_id)->first();
                                        ?>
                                        <td>

                                            {{ $user->first_name}}
                                            {{ $user->surname}}
                                        </td>

                                        <td>
                                            {{ $user->role}}
                                        </td>

                                        <td>
                                            @if($apply->correction)
                                                on correction
                                            @else
                                                on taking test
                                            @endif
                                        </td>
                                        <td>

                                            @if($apply->authorizer_id != null)
                                                <a href="{{ route('sign_on.test..un_confirm',  [$test->id, $user->id, $apply->correction]) }}"
                                                   class="btn btn-sm btn-warning">Unconfirm</a>
                                            @else
                                                <a href="{{ route('sign_on.test..confirm',  [$test->id, $user->id, $apply->correction]) }}"
                                                   class="btn btn-sm btn-success">Confirm</a>
                                            @endif

                                            {!! Form::open(['route' => ['sign_on.test..destroy', [$test->id, $user->id, $apply->correction]], 'method' => 'get', 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Reject', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want sign off?\')']) !!}
                                            {!! Form::close() !!}


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif


                </article>

            </div>
        </div>
    </div>
</div>

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
            <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span class="text-success">{{$test->name}}</span></h2>
        </div>
        <div class="col-sm-2">
            @if (Auth::user() != null && Auth::user()->hasRole('profesor') && Auth::id() == $test->creator_id)
                <a href="{{ route('tests....edit', [$role, $filter, 'detail', $test->id]) }}"
                   class="btn btn-success float-right">Edit</a>
            @endif
        </div>
    </div>

    <div class="p-3 border rounded">
        <h3 class="mb-4"><span style="color: #373737">Maximum points:</span> <span class="{{($total_max_test_points == 0) ? 'text-secondary' : 'text-success'}}">{{$total_max_test_points}}</span></h3>
        <h5><span style="color: #373737">Max duration:</span> <span class="font-weight-normal">{{$test->max_duration}}</span></h5>
        <h5><span style="color: #373737">Available from:</span> <span class="font-weight-normal">{{$test->available_from}}</span></h5>
        <h5><span style="color: #373737">Available to:</span> <span class="font-weight-normal">{{$test->available_to}}</span></h5>
        <h4 class="mt-4" style="color: #373737">Description</h4>
        <p>{{$test->description}}</p><hr>

        <div class="d-flex">
            @if(App\Http\Helpers\SignApplyHelper::my_sign_is_signed($test, 0))
                <a role="button" href="{{route('sign_on.test..destroy', [$test->id, Auth::id(), '0'])}}" onclick="return confirm('Are you sure you want sign off?')" class="btn btn-sm btn-danger">Sign off</a>
            @else
                <a role="button" href="{{route('new..sign', [$test->id, '0'])}}" class="btn btn-sm btn-success">Sign on</a>
            @endif

            @if(Auth::user()->hasRole('assistant') && App\Http\Helpers\SignApplyHelper::my_sign_is_signed($test, 1))
                <a role="button" href="{{route('sign_on.test..destroy', [$test->id, Auth::id(), '1'])}}" onclick="return confirm('Are you sure you want sign off?')" class="btn ml-2 btn-sm btn-danger">Sign off as assistant</a>
            @else
                <a role="button" href="{{route('new..sign', [$test->id, '1'])}}" class="btn ml-2 btn-sm btn-info">Sign on as assistant</a>
            @endif
        </div>
    </div>
</div>
</body>
</html>

