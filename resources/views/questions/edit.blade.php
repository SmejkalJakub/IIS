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
            @if(Auth::user()->hasRole('admin'))
                <li><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor'))
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
                    class="card-header"><h1>Question edit</h1></div>

                <div class="card-body">

                    {{ Form::open(array('route' => array('categories.questions.update', $category_id, $question ), 'method' => 'put')) }}

                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', $question->name, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('task')) has-error @endif">
                        {!! Form::label('Task') !!}
                        {!! Form::textarea('task', $question->task, ['class' => 'form-control', 'placeholder' => 'Task', 'maxlength'=>512]) !!}
                        @if ($errors->has('task'))
                            <span class="help-block">{!! $errors->first('task') !!}</span>@endif
                    </div>

                    <div>
                        <label>
                            <b>Icon</b>
                        </label>
                    </div>
                            <div>
                            <small id="fileHelp" class="form-text text-muted">Current image for question.</small>
                            </div>
                    <div>

                        <img
                            src="{{'http://localhost/' . $question->image}}"
                            onerror="this.onerror=null;this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTOYeuoelhM2iWeIjc--_YW3ZlqrFaIHOCqyQ&usqp=CAU';"
                            style="max-height: 150px; max-width: 150px">


                    </div>
                    <div>

                        <img id="uploadPreview1" style="max-height: 200px; max-width: 200px"/>
                    </div>
                    <div>
                        <small id="fileHelp" class="form-text text-muted">Choose a new image for question.</small>
                        <input id="icon" type="file" name="icon"
                               onchange="PreviewImage('icon', 'uploadPreview1');"/>
                    </div>

                    <div class="form-group">
                        {!! Form::label('Type') !!}
                        {!! Form::select('type_of_answer', [1 => 'open',0 => 'abcd'],isset($question->type_of_answer) ? $question->type_of_answer : null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group @if($errors->has('right_answer')) has-error @endif">
                        {!! Form::label('Right answer') !!}
                        {!! Form::textarea('right_answer', $question->right_answer, ['class' => 'form-control', 'placeholder' => 'Right answer', 'maxlength'=>128]) !!}
                        @if ($errors->has('right_answer'))
                            <span class="help-block">{!! $errors->first('right_answer') !!}</span>@endif
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <header>
                                <h4>
                                    <b>Options</b>
                                </h4>
                            </header>
                        </div>

                        <div class="card-body">
                            <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Answer</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group @if($errors->has('option_1')) has-error @endif">
                                            {!! Form::label('First option') !!}
                                            {!! Form::text('option_1', $question->option_1, ['class' => 'form-control', 'placeholder' => 'First option', 'maxlength'=>128]) !!}
                                            @if ($errors->has('option_1'))
                                                <span class="help-block">{!! $errors->first('option_1') !!}</span>@endif
                                        </div>
                                        <div class="form-group @if($errors->has('option_2')) has-error @endif">
                                            {!! Form::label('Second option') !!}
                                            {!! Form::text('option_2', $question->option_2, ['class' => 'form-control', 'placeholder' => 'Second option', 'maxlength'=>128]) !!}
                                            @if ($errors->has('option_2'))
                                                <span class="help-block">{!! $errors->first('option_2') !!}</span>@endif
                                        </div>
                                        <div class="form-group @if($errors->has('option_2')) has-error @endif">
                                            {!! Form::label('Third option') !!}
                                            {!! Form::text('option_3', $question->option_3, ['class' => 'form-control', 'placeholder' => 'Third option', 'maxlength'=>128]) !!}
                                            @if ($errors->has('option_3'))
                                                <span class="help-block">{!! $errors->first('option_3') !!}</span>@endif
                                        </div>
                                        <div class="form-group @if($errors->has('option_4')) has-error @endif">
                                            {!! Form::label('Fourth option') !!}
                                            {!! Form::text('option_4', $question->option_4, ['class' => 'form-control', 'placeholder' => 'Fourth option', 'maxlength'=>128]) !!}
                                            @if ($errors->has('option_4'))
                                                <span class="help-block">{!! $errors->first('option_4') !!}</span>@endif
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {!! Form::submit('Update',['class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">

    function PreviewImage(orderOfImage, uploadPreviewOrder) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(orderOfImage).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById(uploadPreviewOrder).src = oFREvent.target.result;
        };
    }

</script>

