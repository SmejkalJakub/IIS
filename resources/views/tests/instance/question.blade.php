<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">


                <div class="card-body">

                    @for ($i = 0; $i < count($instance->instances_questions); $i++)
                        <a href="{{route('test-fill..', [$instance->id, $i])}}" role="button"
                           class="{{($i == $currentQuestion) ? 'btn btn-sm btn-success mr-2' : 'btn btn-sm btn-warning mr-2'}}">{{$i + 1}}</a>
                    @endfor
                    <br>
                    <h3>Name of question: </h3>
                    <h4>{{$question->name}}</h4>
                    <h3>
                        Task:
                    </h3>
                    <h4>
                        {{$question->task}}
                    </h4>
                    <h3>
                        Max points:
                    </h3>
                    <h4>
                        {{$question->category->max_points}}
                    </h4>

                    @if($question->image_path != 'no_image.png')
                        <label>Image</label>
                        <div>
                            <img alt="Question image"  src="{{ asset($question->image_path) }}" style="width: 400px; height: 300px; border-radius: 50%;">
                        </div>
                    @endif
                    <br><br>
                    <hr>

                    <h3>Your answer:</h3>

                    {{ Form::open(array('route' => array('question-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

                    @if($question->type_of_answer == 1)
                        {!! Form::textarea('answer', $question->pivot->answer, ['class' => 'form-control', 'placeholder' => 'Answer', 'maxlength'=>128]) !!}
                    @else
                        {!! Form::radio('answer', '1', ($question->pivot->answer == 1)) !!} {!! Form::label($question->option_1) !!}
                        <br>
                        {!! Form::radio('answer', '2', ($question->pivot->answer == 2)) !!} {!! Form::label($question->option_2) !!}
                        <br>
                        {!! Form::radio('answer', '3', ($question->pivot->answer == 3)) !!} {!! Form::label($question->option_3) !!}
                        <br>
                        {!! Form::radio('answer', '4', ($question->pivot->answer == 4)) !!} {!! Form::label($question->option_4) !!}
                        <br>
                    @endif

                    {{--'onclick' => 'return confirm(\'Are you sure you want to discard this category?\')'--}}
                    @if($currentQuestion != 0)
                        <a href="{{route('test-fill..', [$instance->id, $currentQuestion - 1])}}" role="button"
                           class="btn btn-sm btn-primary mr-2">Previous</a>
                        {!! Form::button('Save and Previous', [ 'name' => 'action', 'value' => 'Save and Previous', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                    @endif

                    @if($currentQuestion != count($instance->instances_questions) - 1)
                        {!! Form::button('Save and Next', [ 'name' => 'action', 'value' => 'Save and Next', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                        <a href="{{route('test-fill..', [$instance->id, $currentQuestion + 1])}}" role="button"
                           class="btn btn-sm btn-primary mr-2">Next</a>
                    @else
                        {!! Form::button('Save and End Test', [ 'name' => 'action', 'value' => 'Save and End Test', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                        <a href="{{route('test.end', $instance->id)}}" role="button"
                           class="btn btn-sm btn-primary mr-2">End test</a>
                    @endif

                    {!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
