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
            <a href="{{ route('tests.edit', $test) }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4" style="color: #373737">Add category to test</h2>
        </div>
        <div class="col-sm-2"></div>
    </div>

    {{ Form::open(array('route' => array('test.category.store', $test))) }}

    <div class="form-group @if($errors->has('category_id')) has-error @endif">
        <label class="font-weight-bold" style="color: #373737">Categories</label>
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'id' => 'category_id', 'multiple' => 'multiple']) !!}
        @if ($errors->has('category_id'))
            <span class="help-block">{!! $errors->first('category_id') !!}</span>
        @endif
    </div>

    <div class="input-group @if($errors->has('number_of_questions')) has-error @endif">
        <div class="input-group-prepend">
            <label class="input-group-text">Number of questions</label>
        </div>
        {!! Form::number('number_of_questions', null, ['class' => 'form-control', 'placeholder' => 'Enter number of questions', 'maxlength'=>128]) !!}
        <div class="input-group-append">
            {!! Form::submit('Add', ['class' => 'btn btn-success float-right']) !!}
        </div>
    </div>
    @if ($errors->has('number_of_questions'))
        <span class="help-block">{!! $errors->first('number_of_questions') !!}</span>
    @endif

    {!! Form::close() !!}
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

