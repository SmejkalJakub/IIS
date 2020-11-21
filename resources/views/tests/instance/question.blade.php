<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span
            class="font-weight-normal">{{$instance->test->name}}</span></h2>
    <div class="d-flex justify-content-center">
        @for ($i = 0; $i < count($instance->instances_questions); $i++)
            <a href="{{route('test-fill..', [$instance->id, $i])}}" role="button"
               class="{{($i == $currentQuestion) ? 'btn btn-sm btn-info mr-2' : 'btn btn-sm btn-secondary mr-2'}}">{{$i + 1}}</a>
        @endfor
    </div>
    <h4>Task {{$currentQuestion + 1}}</h4>
    <hr>
    <p>{{$question->task}} (<b>{{$question->category->max_points}} p.</b>)</p>


    @if($question->image_path != 'no_image.png')
        <label>Image</label>
        <div>

            <img src="/lsapp/public/{{ $question->image_path }}"
                 alt="{{ $question->image_path }}"/>
        </div>
    @endif
    <br><br>
    <hr>


    {{ Form::open(array('route' => array('question-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

    @if($question->type_of_answer == 1)
        <label class="font-weight-bold mt-3" style="color: #373737">Solution</label>
        {!! Form::textarea('answer', $question->pivot->answer, ['class' => 'form-control', 'placeholder' => 'Enter your answer', 'maxlength'=>128]) !!}
    @else
        <label class="font-weight-bold mt-3" style="color: #373737">Answer</label><br>
        {!! Form::radio('answer', '1', ($question->pivot->answer == 1)) !!} {!! Form::label($question->option_1) !!}
        <br>
        {!! Form::radio('answer', '2', ($question->pivot->answer == 2)) !!} {!! Form::label($question->option_2) !!}
        <br>
        {!! Form::radio('answer', '3', ($question->pivot->answer == 3)) !!} {!! Form::label($question->option_3) !!}
        <br>
        {!! Form::radio('answer', '4', ($question->pivot->answer == 4)) !!} {!! Form::label($question->option_4) !!}
        <br>
    @endif

    <div class="row mt-3">
        <div class="col">
            <div class="d-flex">
                @if($currentQuestion != 0)
                    <a href="{{route('test-fill..', [$instance->id, $currentQuestion - 1])}}" role="button"
                       class="btn btn-sm btn-secondary mr-2">Previous</a>
                    {!! Form::button('Save and previous', [ 'name' => 'action', 'value' => 'Save and Previous', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}

                @if($currentQuestion != count($instance->instances_questions) - 1)
                    {!! Form::button('Save and next', [ 'name' => 'action', 'value' => 'Save and Next', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                    <a href="{{route('test-fill..', [$instance->id, $currentQuestion + 1])}}" role="button"
                       class="btn btn-sm btn-secondary mr-2">Next</a>
                @else
                    {!! Form::button('Save and end test', [ 'name' => 'action', 'value' => 'Save and End Test', 'class' => 'btn btn-sm btn-info mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::close() !!}
            </div>
        </div>

        <?php
        $color = App\Http\Helpers\testInstanceHelper::stateOfFilling($instance);
        ?>

        <div class="col-auto">
            <a href="{{route('test.end', $instance->id)}}" role="button" class="btn btn-sm {{$color}}">End test</a>
        </div>
    </div>
</div>


</body>
</html>
