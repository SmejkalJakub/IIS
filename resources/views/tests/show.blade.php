<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

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
                                                        $cat = \App\Models\Category::where('id', '=', $test_category->id)->first();

                                                        $total_max_test_points = $total_max_test_points + ($cat->max_points * $test_category->number_of_questions);
                                                        ?>
                                                        {{ $cat->name }}
                                                    </td>
                                                    <td>
                                                        {{$cat->max_points}}
                                                    </td>
                                                    <td>
                                                        {{$test_category->number_of_questions}}
                                                    </td>
                                                    <td>
                                                        {{$cat->max_points * $test_category->number_of_questions}}
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
            <h2 class="text-center mb-4" style="color: #373737">Test detail</h2>
        </div>
        <div class="col-sm-2">
            @if (Auth::user() != null && Auth::user()->hasRole('profesor') && Auth::id() == $test->creator_id)
                <a href="{{ route('tests....edit', [$role, $filter, 'detail', $test->id]) }}"
                   class="btn btn-success float-right">Edit</a>
            @endif
        </div>
    </div>
</div>
</body>
</html>

