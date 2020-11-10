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

@include('layouts.navbar', ['activeBar' => 'tests'])


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div
                    class="card-header"><h1>Question add</h1></div>

                <div class="card-body">

                    {{ Form::open(array('route' => array('test.categories.store', $test_id))) }}

                    <div class="form-group @if($errors->has('number_of_questions')) has-error @endif">
                        {!! Form::label('Number of questions') !!}
                        {!! Form::number('number_of_questions', null, ['class' => 'form-control', 'placeholder' => 'Number of questions', 'maxlength'=>128]) !!}
                        @if ($errors->has('number_of_questions'))
                            <span class="help-block">{!! $errors->first('number_of_questions') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('category_id')) has-error @endif">
                        {!! Form::label('Categories') !!}
                        {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'id' => 'category_id', 'multiple' => 'multiple']) !!}
                        @if ($errors->has('category_id'))
                            <span class="help-block">{!! $errors->first('category_id') !!}</span>
                        @endif
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

<script type="text/javascript">

    function PreviewImage(orderOfImage, uploadPreviewOrder) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(orderOfImage).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById(uploadPreviewOrder).src = oFREvent.target.result;
        };
    }

</script>

