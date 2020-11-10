<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
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
            <li><a href="{{route('tests')}}">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor') || Auth::user()->hasRole('admin'))
                <li><a href="{{route('categories')}}">Categories</a></li>
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
                <div class="card-header">
                    <header>
                        <h1>
                            Category update
                        </h1>
                    </header>
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'put']) !!}

                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div>
                        {!! Form::label('Max points') !!}
                        {{ Form::input('number', 'max_points', $category->max_points, ['id' => 'max_points', 'class' => 'form-control']) }}
                    </div>
                    <div>
                        <tr>
                            {!! Form::submit('Update',['class' => 'btn btn-sm btn-warning']) !!}
                            {!! Form::close() !!}
                        </tr>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <header><h3>Questions of category
                                    <a
                                        href="{{ route('categories.questions.create', $category->id) }}"
                                        class="btn btn-lg btn-primary align-middle float-right">Add</a>
                                </h3>
                            </header>
                        </div>

                        <div class="card-body">
                            <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <a href="{{ route('question.show', $question->id) }}">{{ $question->name }}</a>

                                        </td>
                                        <td>

                                            <a href="{{ route('categories.questions.edit', [$category->id, $question]) }}"
                                               class="btn btn-sm btn-primary">Edit</a>

                                            {!! Form::open(['route' => ['categories.questions.destroy', $category->id, $question->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
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
</div>

</body>
</html>

