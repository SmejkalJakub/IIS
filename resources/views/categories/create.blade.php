<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div
                    class="card-header"><h1>Category create</h1></div>

                <div class="card-body">

                    <?php
                    $category = new \App\Models\Category();
                    $category->max_points = -1;
                    $category->name = "";
                    $category->save();

                    ?>
                        {!! Form::open(['route' => ['categories.update', $category], 'method' => 'put']) !!}

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


                            {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                            {!! Form::submit('Back', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to discard this category?\')']) !!}
                            {!! Form::close() !!}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
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

</body>
</html>

