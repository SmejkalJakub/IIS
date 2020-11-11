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
                <div
                    class="card-header"><b>Test - create</b></div>

                <div class="card-body">
                    {!! Form::open(['route' => 'tests.store']) !!}


                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('description')) has-error @endif">
                        {!! Form::label('Description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'maxlength'=>1024]) !!}
                        @if ($errors->has('description'))
                            <span class="help-block">{!! $errors->first('description') !!}</span>@endif
                    </div>






                    {!! Form::label('Available from') !!}
                    {{ Form::input('dateTime-local', 'available_from', null, ['id' => 'available_from', 'class' => 'form-control']) }}

                    {!! Form::label('Available to') !!}
                    {{ Form::input('dateTime-local', 'available_to', null, ['id' => 'available_to', 'class' => 'form-control']) }}

                    {!! Form::label('Max Duration') !!}
                    {{ Form::input('time', 'max_duration', null, ['id' => 'max_duration', 'class' => 'form-control']) }}

<div>
    <h2>
        <a href="{{ route('tests') }}"
           class="btn btn-sm btn-primary">Back</a>
        {!! Form::submit('Create',['class' => 'btn btn-sm btn-warning']) !!}
        {!! Form::close() !!}
    </h2>
</div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
