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
                        <tr><h2>
                                <a href="{{ route('categories.show', $category->id) }}"
                                   class="btn btn-sm btn-primary">Back</a>
                                {!! Form::submit('Update',['class' => 'btn btn-sm btn-warning']) !!}
                                {!! Form::close() !!}
                            </h2>
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type of answer</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <a href="{{ route('categories.questions.show', [$category->id, $question->id]) }}">{{ $question->id }}</a>

                                        </td>
                                        <td>
                                            {{$question->name}}
                                        </td>
                                        <td>
                                            @if($question->type_of_answer == 1)
                                                open
                                            @else
                                                abcd
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('categories.questions.edit', [$category->id, $question]) }}"
                                               class="btn btn-sm btn-primary">Edit</a>

                                            {!! Form::open(['route' => ['categories.questions.destroy', $category->id, $question->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this question?\')']) !!}
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

