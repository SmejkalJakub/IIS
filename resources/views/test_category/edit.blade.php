<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

@if($errors->has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ $errors->first('error') }}
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div
                    class="card-header"><h1>Number of questions from <b>{{$test_category->name}}</b> category</h1></div>

                <div class="card-body">

                    {!! Form::open(['route' => ['test.category.update',  [$test->id, $test_category->id]], 'method' => 'put']) !!}

                    <div class="form-group @if($errors->has('number_of_questions')) has-error @endif">
                        {!! Form::label('Number of questions') !!}
                        {!! Form::number('number_of_questions', $test_category->pivot->number_of_questions, ['class' => 'form-control',
                                                                                                             'placeholder' => 'Number of questions',
                                                                                                             'min' => 1, 'max' => count($test_category->questions),'maxlength'=>128]) !!}
                        @if ($errors->has('number_of_questions'))
                            <span class="help-block">{!! $errors->first('number_of_questions') !!}</span>@endif
                    </div>
                    <a href="{{ route('tests.edit', $test->id) }}"
                       class="btn btn-sm btn-primary">Back</a>
                    {!! Form::submit('Update', ['class' => 'btn btn-sm btn-warning']) !!}
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

