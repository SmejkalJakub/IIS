<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])


<body onload="showDiv('hidden_div', 'openAnswer', 'closedAnswer', 'type_of_answer')">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div
                    class="card-header"><h1>Question create</h1></div>

                <div class="card-body">

                    {{ Form::open(array('route' => array('categories.questions.store', $category_id))) }}

                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        {!! Form::label('Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'maxlength'=>128]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{!! $errors->first('name') !!}</span>@endif
                    </div>

                    <div class="form-group @if($errors->has('task')) has-error @endif">
                        {!! Form::label('Task') !!}
                        {!! Form::textarea('task', null, ['class' => 'form-control', 'placeholder' => 'Task', 'maxlength'=>512]) !!}
                        @if ($errors->has('task'))
                            <span class="help-block">{!! $errors->first('task') !!}</span>@endif
                    </div>

                    <div>
                        <label>
                            <b>Icon</b>
                        </label>
                    </div>
                    <div>
                        <img id="uploadPreview1" style="max-height: 200px; max-width: 200px"/>
                        <small id="fileHelp" class="form-text text-muted">Choose an image for question.</small>
                        <input id="icon" type="file" name="icon"
                               onchange="PreviewImage('icon', 'uploadPreview1');"/>
                    </div>

                    <div class="form-group">
                        {!! Form::label('Type') !!}
                        {!! Form::select('type_of_answer', [1 => 'open', 0 => 'abcd'], 1, ['id' => 'type_of_answer', 'class' => 'form-control', 'onchange' => 'showDiv(\'hidden_div\', \'openAnswer\', \'closedAnswer\', \'type_of_answer\')']) !!}
                    </div>
                    <div class="form-group @if($errors->has('right_answer')) has-error @endif">
                        {!! Form::label('Right answer') !!}
                        <div id="openAnswer">
                            {!! Form::textarea('right_answer', null, ['class' => 'form-control', 'placeholder' => 'Right answer', 'maxlength'=>128]) !!}
                            @if ($errors->has('right_answer'))
                                <span class="help-block">{!! $errors->first('right_answer') !!}</span>@endif
                        </div>
                        <div id="closedAnswer">
                            {!! Form::radio('right_option', '1') !!} {!! Form::label('a)') !!}<br>
                            {!! Form::radio('right_option', '2') !!} {!! Form::label('b)') !!}<br>
                            {!! Form::radio('right_option', '3') !!} {!! Form::label('c)') !!}<br>
                            {!! Form::radio('right_option', '4') !!} {!! Form::label('d)') !!}<br>
                            @if ($errors->has('right_option'))
                                <span class="help-block">{!! $errors->first('right_option') !!}</span>@endif
                        </div>
                    </div>

                    <div id="hidden_div">
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
                                                {!! Form::text('option_1', null, ['class' => 'form-control', 'placeholder' => 'First option', 'maxlength'=>128]) !!}
                                                @if ($errors->has('option_1'))
                                                    <span class="help-block">{!! $errors->first('option_1') !!}</span>@endif
                                            </div>
                                            <div class="form-group @if($errors->has('option_2')) has-error @endif">
                                                {!! Form::label('Second option') !!}
                                                {!! Form::text('option_2', null, ['class' => 'form-control', 'placeholder' => 'Second option', 'maxlength'=>128]) !!}
                                                @if ($errors->has('option_2'))
                                                    <span class="help-block">{!! $errors->first('option_2') !!}</span>@endif
                                            </div>
                                            <div class="form-group @if($errors->has('option_2')) has-error @endif">
                                                {!! Form::label('Third option') !!}
                                                {!! Form::text('option_3', null, ['class' => 'form-control', 'placeholder' => 'Third option', 'maxlength'=>128]) !!}
                                                @if ($errors->has('option_3'))
                                                    <span class="help-block">{!! $errors->first('option_3') !!}</span>@endif
                                            </div>
                                            <div class="form-group @if($errors->has('option_4')) has-error @endif">
                                                {!! Form::label('Fourth option') !!}
                                                {!! Form::text('option_4', null, ['class' => 'form-control', 'placeholder' => 'Fourth option', 'maxlength'=>128]) !!}
                                                @if ($errors->has('option_4'))
                                                    <span class="help-block">{!! $errors->first('option_4') !!}</span>@endif
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h2>

                    <a href="{{ route('categories.show', $category_id) }}"
                       class="btn btn-sm btn-primary">Back</a>
                    {!! Form::submit('Create',['class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::close() !!}
                    </h2>
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
    function showDiv(openAnswerId, rightAnswerOpen, rightAnswerClose, element)
    {
        element = document.getElementById(element);
        if(element.value == 0)
        {
            document.getElementById(openAnswerId).style.display = 'block';
            document.getElementById(rightAnswerOpen).style.display = 'none';
            document.getElementById(rightAnswerClose).style.display = 'block';
        }
        else
        {
            document.getElementById(openAnswerId).style.display = 'none';
            document.getElementById(rightAnswerOpen).style.display = 'block';
            document.getElementById(rightAnswerClose).style.display = 'none';
        }
    }
</script>

