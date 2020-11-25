<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="text-center mb-3"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$instance->test->name}}</span></h2>
    <h4 class="text-center mb-4">Remaining time: <span class="font-weight-normal" id="timer"></span></h4>

    <div class="d-flex justify-content-center">
        @for ($i = 0; $i < count($instance->instances_questions); $i++)
            <a href="{{route('test-fill..', [$instance->id, $i])}}" role="button" class="{{($i == $currentQuestion) ? 'btn btn-sm btn-info mr-2' : 'btn btn-sm btn-secondary mr-2'}}">{{$i + 1}}</a>
        @endfor
    </div>
    <h4>Task {{$currentQuestion + 1}}</h4><hr>
    <p>{{$question->task}} (<b>{{$question->category->max_points}} p.</b>)</p>

    @if($question->image_path)
        <label class="font-weight-bold mt-3">Image</label>
        <div style="max-height: 600px; max-width: 600px">
            <img class="border rounded" src="/public{{ $question->image_path }}"
                 alt="{{ $question->image_path }}" style="max-height: 100%; max-width: 100%"/>
        </div>
    @endif

    {{ Form::open(array('route' => array('question-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

    @if($question->type_of_answer == 1)
        <label class="font-weight-bold mt-3" style="color: #373737">Solution</label>
        {!! Form::textarea('answer', $question->pivot->answer, ['class' => 'form-control', 'placeholder' => 'Enter your answer']) !!}
    @else
        <label class="font-weight-bold mt-3" style="color: #373737">Answer</label>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('answer', '1', ($question->pivot->answer == 1)) !!} {!! Form::label(null, $question->option_1) !!}
        </div>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('answer', '2', ($question->pivot->answer == 2)) !!} {!! Form::label(null, $question->option_2) !!}
        </div>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('answer', '3', ($question->pivot->answer == 3)) !!} {!! Form::label(null, $question->option_3) !!}
        </div>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('answer', '4', ($question->pivot->answer == 4)) !!} {!! Form::label(null, $question->option_4) !!}
        </div>
    @endif

    <div class="row mt-3">
        <div class="col">
            <div class="d-flex">
                @if($currentQuestion != 0)
                    <a href="{{route('test-fill..', [$instance->id, $currentQuestion - 1])}}" role="button" class="btn btn-sm btn-secondary mr-2">Previous</a>
                    {!! Form::button('Save and previous', [ 'name' => 'action', 'value' => 'Save and Previous', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}

                @if($currentQuestion != count($instance->instances_questions) - 1)
                    {!! Form::button('Save and next', [ 'name' => 'action', 'value' => 'Save and Next', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                    <a href="{{route('test-fill..', [$instance->id, $currentQuestion + 1])}}" role="button" class="btn btn-sm btn-secondary mr-2">Next</a>
                @else
                    {!! Form::button('Save and end test', [ 'name' => 'action', 'value' => 'Save and End Test', 'class' => 'btn btn-sm btn-info mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::close() !!}
            </div>
        </div>

        <?php
           $color = App\Http\Helpers\testInstanceHelper::stateOfFilling($instance, false);
        ?>

        <div class="col-auto">
            <a href="{{route('test.end', $instance->id)}}" role="button" class="btn btn-sm {{$color}}">End test</a>
        </div>
    </div>
</div>

@include('layouts.timer', ['divId' => 'timer'])

</body>
</html>

