<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container-full-width">
    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ $errors->first('error') }}
        </div>
    @endif
</div>

<div class="container bg-white rounded mt-5 p-4" style="max-width: 700px">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a href="{{ route('tests....edit', [$role, $filter, $from, $test->id]) }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4" style="color: #373737">Number of questions from category <span class="text-success font-weight-bold">{{$test_category->name}}</span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>

    {!! Form::open(['route' => ['test.category.update',  [$test->id, $test_category->id]], 'method' => 'put']) !!}

    <div class="input-group @if($errors->has('number_of_questions')) has-error @endif">
        <div class="input-group-prepend">
            <label class="input-group-text">Number of questions</label>
        </div>
        {!! Form::number('number_of_questions', $test_category->pivot->number_of_questions, ['class' => 'form-control', 'required', 'placeholder' => 'Number of questions', 'min' => 1, 'max' => count($test_category->questions),'maxlength'=>128]) !!}
        <div class="input-group-append">
            {!! Form::submit('Update', ['class' => 'btn btn-success float-right']) !!}
        </div>
    </div>
    @if ($errors->has('number_of_questions'))
        <span class="help-block">{!! $errors->first('number_of_questions') !!}</span>
    @endif
</div>

</body>
</html>

