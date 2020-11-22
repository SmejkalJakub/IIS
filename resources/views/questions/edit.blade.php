<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])

<body onload="showDiv('openAnswer', 'closedAnswer', 'type_of_answer')" style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a href="{{ route('categories.edit', $category_id) }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4" style="color: #373737">Edit question</h2>
        </div>
        <div class="col-sm-2">
            {{ Form::open(array('route' => array('categories.questions.update', $category_id, $question ), 'method' => 'put', 'files'=>true)) }}
            {!! Form::submit('Save',['class' => ['btn btn-success', 'float-right']]) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="input-group @if($errors->has('name')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Name</label>
                </div>
                {!! Form::text('name', $question->name, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
            </div>
            @if ($errors->has('name'))
                <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
        <div class="col-sm-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text">Type</label>
                </div>
                {!! Form::select('type_of_answer', [1 => 'fulltext', 0 => 'test'], isset($question->type_of_answer) ? $question->type_of_answer : null, ['id' => 'type_of_answer', 'class' => 'form-control', 'onchange' => 'showDiv(\'openAnswer\', \'closedAnswer\', \'type_of_answer\')']) !!}
            </div>
        </div>
    </div>

    <div class="mt-3 form-group @if($errors->has('task')) has-error @endif">
        <label class="font-weight-bold" style="color: #373737">Task</label>
        {!! Form::textarea('task', $question->task, ['class' => 'form-control', 'placeholder' => 'Task', 'maxlength'=>512]) !!}
        @if ($errors->has('task'))
            <span class="help-block">{!! $errors->first('task') !!}</span>@endif
    </div>
    @if($question->image_path)
        <div>
            <img src="/public/{{ $question->image_path }}"
                 alt="{{ $question->image_path }}"/>
        </div>
    @endif
    <label class="font-weight-bold" style="color: #373737">Image</label>
    <div>
        <img class="border rounded" id="uploadPreview1" style="max-height: 500px; max-width: 500px"/>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <input id="image_path" type="file" class="form-control"
                   name="image_path" onchange="PreviewImage('image_path', 'uploadPreview1');"/>
        </div>
    </div>

    <div class="form-group @if($errors->has('right_answer')) has-error @endif">
        <div id="openAnswer">
            <label class="font-weight-bold" style="color: #373737">Right answer</label>
            {!! Form::textarea('right_answer', $question->right_text_answer, ['class' => 'form-control', 'placeholder' => 'Right answer', 'maxlength'=>128]) !!}
            @if ($errors->has('right_answer'))
                <span class="help-block">{!! $errors->first('right_answer') !!}</span>@endif
        </div>
        <div id="closedAnswer">
            <label class="font-weight-bold" style="color: #373737">Select right answer</label>
            <div class="input-group mb-3 @if($errors->has('option_1')) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {!! Form::radio('right_option', '1', ($question->right_option == 1)) !!}
                    </div>
                </div>
                {!! Form::text('option_1', $question->option_1, ['class' => 'form-control', 'placeholder' => 'A)', 'maxlength'=>128]) !!}
                @if ($errors->has('option_1'))
                    <span class="help-block">{!! $errors->first('option_2') !!}</span>
                @endif
            </div>
            <div class="input-group mb-3 @if($errors->has('option_1')) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {!! Form::radio('right_option', '2', ($question->right_option == 2)) !!}
                    </div>
                </div>
                {!! Form::text('option_2', $question->option_2, ['class' => 'form-control', 'placeholder' => 'B)', 'maxlength'=>128]) !!}
                @if ($errors->has('option_2'))
                    <span class="help-block">{!! $errors->first('option_2') !!}</span>
                @endif
            </div>
            <div class="input-group mb-3 @if($errors->has('option_3')) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {!! Form::radio('right_option', '3', ($question->right_option == 3)) !!}
                    </div>
                </div>
                {!! Form::text('option_3', $question->option_3, ['class' => 'form-control', 'placeholder' => 'C)', 'maxlength'=>128]) !!}
                @if ($errors->has('option_3'))
                    <span class="help-block">{!! $errors->first('option_3') !!}</span>
                @endif
            </div>
            <div class="input-group @if($errors->has('option_4')) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {!! Form::radio('right_option', '4', ($question->right_option == 4)) !!}
                    </div>
                </div>
                {!! Form::text('option_4', $question->option_4, ['class' => 'form-control', 'placeholder' => 'D)', 'maxlength'=>128]) !!}
                @if ($errors->has('option_4'))
                    <span class="help-block">{!! $errors->first('option_4') !!}</span>
                @endif
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

    function showDiv(rightAnswerOpen, rightAnswerClose, element) {
        element = document.getElementById(element);
        if (element.value == 0) {
            document.getElementById(rightAnswerOpen).style.display = 'none';
            document.getElementById(rightAnswerClose).style.display = 'block';
        } else {
            document.getElementById(rightAnswerOpen).style.display = 'block';
            document.getElementById(rightAnswerClose).style.display = 'none';
        }
    }

    function changeText() {
        document.getElementById('customFileLabelId').innerHTML = document.getElementById('image_path').files[0].name;
    }
</script>

