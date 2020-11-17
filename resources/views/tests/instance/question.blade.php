<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

@for ($i = 0; $i < count($instance->instances_questions); $i++)
    <a href="{{route('test-fill..', [$instance->id, $i])}}" role="button" class="btn btn-sm btn-warning mr-2">{{$i + 1}}</a>
@endfor
<br>

<h2>{{$question->name}}</h2>
<br><br>
{{$question->task}}
<br><br><hr>

{{ Form::open(array('route' => array('question-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

@if($question->type_of_answer == 1)
    {!! Form::textarea('answer', $question->pivot->answer, ['class' => 'form-control', 'placeholder' => 'Answer', 'maxlength'=>128]) !!}
@else
    {!! Form::radio('answer', '1', ($question->pivot->answer == 1)) !!} {!! Form::label($question->option_1) !!}<br>
    {!! Form::radio('answer', '2', ($question->pivot->answer == 2)) !!} {!! Form::label($question->option_2) !!}<br>
    {!! Form::radio('answer', '3', ($question->pivot->answer == 3)) !!} {!! Form::label($question->option_3) !!}<br>
    {!! Form::radio('answer', '4', ($question->pivot->answer == 4)) !!} {!! Form::label($question->option_4) !!}<br>
@endif

{{--'onclick' => 'return confirm(\'Are you sure you want to discard this category?\')'--}}
@if($currentQuestion != 0)
    <a href="{{route('test-fill..', [$instance->id, $currentQuestion - 1])}}" role="button" class="btn btn-sm btn-primary mr-2">Previous</a>
    {!! Form::button('Save and Previous', [ 'name' => 'action', 'value' => 'Save and Previous', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
@endif

@if($currentQuestion != count($instance->instances_questions) - 1)
    {!! Form::button('Save and Next', [ 'name' => 'action', 'value' => 'Save and Next', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
    <a href="{{route('test-fill..', [$instance->id, $currentQuestion + 1])}}" role="button" class="btn btn-sm btn-primary mr-2">Next</a>
@else
    {!! Form::button('Save and End Test', [ 'name' => 'action', 'value' => 'Save and End Test', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
    <a href="{{route('test.end', $instance->id)}}" role="button" class="btn btn-sm btn-primary mr-2">End test</a>
@endif

{!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
{!! Form::close() !!}



</body>
</html>
