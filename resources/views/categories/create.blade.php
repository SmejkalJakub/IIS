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
            <li><a href="">Categories</a></li>
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
                <div
                    class="card-header"><h1>Category create</h1></div>

                <div class="card-body">
                    {!! Form::open(['route' => 'categories.store']) !!}


                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div>
                        {!! Form::label('Max points') !!}
                        {{ Form::input('number', 'max_points', null, ['id' => 'max_points', 'class' => 'form-control']) }}
                    </div>



                    {!! Form::submit('Create',['class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

