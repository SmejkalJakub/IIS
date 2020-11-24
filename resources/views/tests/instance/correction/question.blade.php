<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span
            class="font-weight-normal">{{$instance->test->name}}</span></h2>
    <div class="d-flex justify-content-center">
        @for ($i = 0; $i < count($instance->instances_questions); $i++)
            <a href="{{route('question-correct..', [$instance->id, $i])}}" role="button"
               class="{{($i == $currentQuestion) ? 'btn btn-sm btn-info mr-2' : 'btn btn-sm btn-secondary mr-2'}}">{{$i + 1}}</a>
        @endfor
    </div>
    <h4>Task {{$currentQuestion + 1}}</h4>
    <hr>
    <p>{{$question->task}} (<b>{{$question->category->max_points}} p.</b>)</p>

    @if($question->image_path)
        <label class="font-weight-bold mt-3">Image</label>
        <div style="max-height: 600px; max-width: 600px">
            <img class="border rounded" src="/public{{ $question->image_path }}"
                 alt="{{ $question->image_path }}" style="max-height: 100%; max-width: 100%"/>
        </div>
    @endif

    <?php
        $suggested_points = $question->pivot->points;
    ?>

    @if($question->type_of_answer == 1)
        <label class="font-weight-bold mt-3" style="color: #373737">Solution</label>
        @if($question->pivot->answer)
            <div class="rounded border p-2">
                {{$question->pivot->answer}}
            </div>
        @else
            <p class="font-weight-bold text-danger"> - Missing</p>
        @endif
        <label class="font-weight-bold text-success mt-3">Right Solution</label>
        <div class="rounded border mb-5 p-2">
            {{$question->right_text_answer}}
        </div>
    @else
        <?php
            if($question->pivot->points === null)
            {
                if($question->right_option == $question->pivot->answer)
                {
                    $suggested_points = $question->category->max_points;
                }
                else
                {
                    $suggested_points = 0;
                }
            }
        ?>

        <label class="font-weight-bold mt-3" style="color: #373737">Answer</label>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('testQuestion', '1', ($question->pivot->answer == 1), ['disabled' => 'disabled', 'style' => 'background-color: #44FF00']) !!} {!! Form::label(null, $question->option_1, ['class' => (($question->right_option == 1) ? 'text-success font-weight-bold' : (($question->pivot->answer == 1) ? 'text-danger font-weight-bold' : ''))]) !!}
        </div>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('testQuestion', '2', ($question->pivot->answer == 2), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_2, ['class' => (($question->right_option == 2) ? 'text-success font-weight-bold' : (($question->pivot->answer == 2) ? 'text-danger font-weight-bold' : ''))]) !!}
        </div>
        <div class="form-check" style="padding-left: 0px">
            {!! Form::radio('testQuestion', '3', ($question->pivot->answer == 3), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_3, ['class' => (($question->right_option == 3) ? 'text-success font-weight-bold' : (($question->pivot->answer == 3) ? 'text-danger font-weight-bold' : ''))]) !!}
        </div>
        <div class="form-check mb-5" style="padding-left: 0px">
            {!! Form::radio('testQuestion', '4', ($question->pivot->answer == 4), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_4, ['class' => (($question->right_option == 4) ? 'text-success font-weight-bold' : (($question->pivot->answer == 4) ? 'text-danger font-weight-bold' : ''))]) !!}
        </div>
    @endif

    {{ Form::open(array('route' => array('correction-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

    <div class="input-group" style="max-width: 400px">
        <div class="input-group-prepend">
            <label class="input-group-text">Points</label>
        </div>
        {!! Form::number('points', $suggested_points, ['class' => 'form-control', 'step'=>'any', 'placeholder' => 'Enter number of points', 'maxlength'=>128, 'min' => '0', 'max' => $question->category->max_points]) !!}
    </div>

    <label class="font-weight-bold mt-3" style="color: #373737">Comment</label>
    {!! Form::textarea('comment', $question->pivot->comment, ['class' => 'form-control', 'placeholder' => 'Enter comment']) !!}

    <div class="row mt-3">
        <div class="col">
            <div class="d-flex">
                @if($currentQuestion != 0)
                    <a href="{{route('question-correct..', [$instance->id, $currentQuestion - 1])}}" role="button" class="btn btn-sm btn-secondary mr-2">Previous</a>
                    {!! Form::button('Save and previous', [ 'name' => 'action', 'value' => 'Save and previous', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}

                @if($currentQuestion != count($instance->instances_questions) - 1)
                    {!! Form::button('Save and next', [ 'name' => 'action', 'value' => 'Save and next', 'class' => 'btn btn-sm btn-success mr-2', 'type' => 'submit']) !!}
                    <a href="{{route('question-correct..', [$instance->id, $currentQuestion + 1])}}" role="button" class="btn btn-sm btn-secondary mr-2">Next</a>
                @else
                    {!! Form::button('Save and end revision', [ 'name' => 'action', 'value' => 'Save and end revision', 'onclick' => 'return confirm(\'Are you sure that you want to end this review?\')',' class' => 'btn btn-sm btn-info mr-2', 'type' => 'submit']) !!}
                @endif

                {!! Form::close() !!}
            </div>
        </div>

        <?php
        $color = App\Http\Helpers\testInstanceHelper::stateOfFilling($instance, true);
        ?>

        <div class="col-auto">
            <a href="{{route('test-correct.instances-end', $instance->id)}}" onclick="return confirm('Are you sure that you want to end this review?')" role="button" class="btn btn-sm {{$color}}">End Revision</a>
        </div>
    </div>
</div>

</body>
</html>
