<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

<!--<div class="container">
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

                    <div class="mb-3 input-group @if($errors->has('name')) has-error @endif">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Name</label>
                        </div>
                        {!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Enter name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div class="input-group @if($errors->has('max_points')) has-error @endif">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Points per question</label>
                        </div>
                        {{ Form::input('number', 'max_points', $category->max_points, ['id' => 'max_points', 'class' => 'form-control']) }}
                        @if ($errors->has('max_points'))
                            <span class="help-block">{!! $errors->first('max_points') !!}</span>@endif
                    </div>
                    <div>
                        <tr><h2>
                                <a href="{{route('categories')}}"
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
                        <hr>

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
</div>-->

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-4">
            <a href="{{route('categories')}}" class="btn btn-secondary">Back</a>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center mb-4" style="color: #373737">Edit category</h2>
        </div>
        <div class="col-sm-4"></div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="mb-3 input-group @if($errors->has('name')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Name</label>
                </div>
                {!! Form::text('name', $category->name, ['class' => 'form-control', 'placeholder' => 'Enter name', 'maxlength'=>128]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">{!! $errors->first('name') !!}</span>@endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group @if($errors->has('max_points')) has-error @endif">
                <div class="mb-3 input-group-prepend">
                    <label class="input-group-text">Points per question</label>
                </div>
                {{ Form::input('number', 'max_points', $category->max_points, ['id' => 'max_points', 'class' => 'form-control']) }}
                @if ($errors->has('max_points'))
                    <span class="help-block">{!! $errors->first('max_points') !!}</span>@endif
            </div>
        </div>
        <div class="col-sm-2">
            {!! Form::submit('Update',['class' => 'btn btn-block btn-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="border rounded mt-4 p-3">
        <h3 class="text-center mb-3" style="color: #373737">Questions</h3>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
            </div>
            <div class="col-auto">
                <a href="{{ route('categories.questions.create', $category->id) }}" class="btn btn-success">Add</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mt-4">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>
                                {{$question->name}}
                            </td>
                            <td>
                                @if($question->type_of_answer == 1)
                                    fulltext
                                @else
                                    abcd
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('categories.questions.edit', [$category->id, $question]) }}" class="btn btn-sm btn-success mr-2">Edit</a>

                                    {!! Form::open(['route' => ['categories.questions.destroy', $category->id, $question->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this question?\')']) !!}
                                    {!! Form::close() !!}
                                </div>
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

