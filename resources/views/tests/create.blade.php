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
                    <h1>
                        Test - create
                    </h1>
                </div>

                <div class="card-body">
                    <?php
                    use Illuminate\Support\Facades\Redirect;
                    $test = new \App\Models\Test();
                    $test->creator_id = Auth::id();
                    $test->name = "";
                    $test->description = "";
                    $test->available_from = now();
                    $test->available_to = now();
                    $test->max_duration = now();
                    $test->save();
                    $test_categories = $test->categories;
                    ?>
                    {!! Form::open(['route' => ['tests.update', $test], 'method' => 'put']) !!}


                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', $test->name, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('description')) has-error @endif">
                        {!! Form::label('Description') !!}
                        {!! Form::textarea('description', $test->description, ['class' => 'form-control', 'placeholder' => 'Description', 'maxlength'=>1024]) !!}
                        @if ($errors->has('description'))
                            <span class="help-block">{!! $errors->first('description') !!}</span>@endif
                    </div>


                    <div class="form-group @if($errors->has('available_from')) has-error @endif">
                        {!! Form::label('Available from') !!}
                        {{ Form::input('dateTime-local', 'available_from', date('Y-m-d\TH:i', strtotime($test->available_from)),
                                        ['id' => 'available_from', 'class' => 'form-control']) }}
                        @if ($errors->has('available_from'))
                            <span class="help-block">{!! $errors->first('available_from') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('available_to')) has-error @endif">
                        {!! Form::label('Available to') !!}
                        {{ Form::input('dateTime-local', 'available_to', date('Y-m-d\TH:i', strtotime($test->available_to)),
                                            ['id' => 'available_to', 'class' => 'form-control']) }}
                        @if ($errors->has('available_to'))
                            <span class="help-block">{!! $errors->first('available_to') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('max_duration')) has-error @endif">
                        {!! Form::label('Max Duration') !!}
                        {{ Form::input('time', 'max_duration', $test->max_duration, ['id' => 'max_duration', 'class' => 'form-control']) }}
                        @if ($errors->has('max_duration'))
                            <span class="help-block">{!! $errors->first('max_duration') !!}</span>@endif
                    </div>
                    <div>
                        <header>
                            <h2>
                                Maximum points per test
                            </h2>
                        </header>
                        <h3>
                            {{$test->max_points}}
                        </h3>
                    </div>
                    <div>
                        <h2>
                            {!! Form::submit('Create', ['class' => 'btn btn-sm btn-warning']) !!}
                            {!! Form::close() !!}

                            {!! Form::open(['route' => ['tests.destroy', $test->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                            {!! Form::submit('Back', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to discard this test?\')']) !!}
                            {!! Form::close() !!}
                        </h2>
                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="card-header">
                        <header><h3>Categories in test
                                <a
                                    href="{{ route('test.category.create',  $test->id )}}"
                                    class="btn btn-lg btn-primary align-middle float-right">Add</a>
                            </h3>
                        </header>
                    </div>

                    <div class="card-body">
                        <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Number of questions</th>
                                <th scope="col">Maximum points per question</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $total_max_test_points = 0;
                            ?>
                            @foreach($test_categories as $test_category)
                                <tr>
                                    <td>

                                        {{ $test_category->name }}
                                    </td>
                                    <td>
                                        {{$test_category->pivot->number_of_questions}}
                                    </td>
                                    <td>
                                        {{$test_category->max_points}}
                                    </td>
                                    <td>
                                        <a href="{{ route('test.category.edit', [$test->id, $test_category->id]) }}"
                                           class="btn btn-sm btn-primary">Edit</a>

                                        {!! Form::open(['route' => ['test_category.destroy', [$test, $test_category->id]], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this category from test?\')']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>


<script>
    // Warning before leaving the page (back button, or outgoinglink)
    window.onbeforeunload = function () {

       return "Do you really want to discard changes?"


    };
</script>
