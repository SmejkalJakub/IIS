<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tests</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">Best Tests</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{route('home')}}">Home</a></li>
            <li><a href="">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor') || Auth::user()->hasRole('admin'))
                <li><a href="{{route('tests')}}">Categories</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{route('user')}}"><span
                        class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}
                </a></li>
            <li><a href="{{route('logout')}}"><span></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div
                    class="card-header"><b>Test - edit</b></div>

                <div class="card-body">
                    {!! Form::open(['route' => ['tests.update', $test->id], 'method' => 'put']) !!}


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


                    {!! Form::label('Available from') !!}
                    {{ Form::input('dateTime-local', 'available_from', $test->available_from, ['id' => 'available_from', 'class' => 'form-control']) }}

                    {!! Form::label('Available to') !!}
                    {{ Form::input('dateTime-local', 'available_to', $test->available_to, ['id' => 'available_to', 'class' => 'form-control']) }}

                    {!! Form::label('Max Duration') !!}
                    {{ Form::input('time', 'max_duration', $test->max_duration, ['id' => 'max_duration', 'class' => 'form-control']) }}
                    <div>
                        <h2>

                            {!! Form::submit('Update',['class' => 'btn btn-sm btn-warning']) !!}
                            {!! Form::close() !!}
                        </h2>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <header><h3>Categories of test
                                <a
                                    href="{{ route('test.categories.create',  $test->id) }}"
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
                            $total_max_test_points= 0;
                            ?>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <?php
                                        $cat = \App\Models\Category::where('id', '=', $category->category_id)->first();

                                        $total_max_test_points = $total_max_test_points + ($cat->max_points * $category->number_of_questions);
                                        ?>
                                        {{ $cat->name }}
                                    </td>
                                    <td>
                                        {{$category->number_of_questions}}
                                    </td>
                                    <td>
                                        {{$cat->max_points}}
                                    </td>
                                    <td>


                                        <a href="{{ route('test.categories.edit', [$test->id, $cat->id]) }}"
                                           class="btn btn-sm btn-primary">Edit</a>

                                        {!! Form::open(['route' => ['test.categories.destroy', $test->id, $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <header>
                            <h2>
                                Maximum points per test
                            </h2>
                        </header>
                        <h3>
                        {{$total_max_test_points}}
                        </h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
