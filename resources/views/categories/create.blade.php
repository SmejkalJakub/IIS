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

@include('layouts.navbar', ['activeBar' => 'categories'])

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
                    <div>
                        <h1>

                    {!! Form::submit('Create',['class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::close() !!}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

