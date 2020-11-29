<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

<div class="container bg-white rounded mt-5 p-4">
    <?php
    $category = new \App\Models\Category();
    $category->max_points = -1;
    $category->name = "";
    $category->save();
    $questions = \App\Models\Question::all()->where('category_id', $category->id);
    ?>

    <div class="mb-3 row">
        <div class="col-sm-4">
            {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
            {!! Form::submit('Back', ['class' => 'btn btn-secondary', 'onclick' => 'return confirm(\'Are you sure you want to discard this category?\')']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-sm-4">
            <h2 class="text-center mb-4" style="color: #373737">Create category</h2>
        </div>
        <div class="col-sm-4"></div>
    </div>

        {!! Form::open(['route' => 'categories.store']) !!}

    <div class="row">
        <div class="col-sm-7">
            <div class="mb-3 input-group @if($errors->has('name')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Name *</label>
                </div>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name', 'maxlength'=>128]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">{!! $errors->first('name') !!}</span>@endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group @if($errors->has('max_points')) has-error @endif">
                <div class="mb-3 input-group-prepend">
                    <label class="input-group-text">Points per question *</label>
                </div>
                {{ Form::input('number', 'max_points', null, ['id' => 'max_points','min'=>0, 'class' => 'form-control']) }}
                @if ($errors->has('max_points'))
                    <span class="help-block">{!! $errors->first('max_points') !!}</span>@endif
            </div>
        </div>
        <div class="col-sm-2">
            {!! Form::submit('Save and create',['class' => 'btn btn-block btn-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

</body>
</html>

