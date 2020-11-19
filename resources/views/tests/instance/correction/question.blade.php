<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])


<br>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">


                <div class="card-body">
                    Answers:

                    @for ($i = 0; $i < count($instance->instances_questions); $i++)
                        <a href="{{route('question-correct..', [$instance->id, $i])}}" role="button"
                        class="{{($i == $currentQuestion) ? 'btn btn-sm btn-success mr-2' : 'btn btn-sm btn-warning mr-2'}}">{{$i + 1}}</a>
                    @endfor
                    <br>
                    <h3>Name of question: </h3>
                    <h4>{{$question->name}}</h4>
                    <h3>
                        Task:
                    </h3>
                    <h4>{{$question->task}}

                    </h4>
                    <br><br>
                    <hr>

                    @if($question->type_of_answer == 1)
                        Question Type: Full text<br>
                        <hr>
                        Answer: {{$question->pivot->answer}}<br>
                        Right answer: {{$question->right_text_answer}}<br>
                    @else
                        <?php
                        $questionOptions = array($question->option_1, $question->option_2, $question->option_3, $question->option_4);
                        ?>

                        @if($question->pivot->points == null)
                            @if($question->right_option == $question->pivot->answer)
                                <?php
                                $question->pivot->points = $question->category->max_points;
                                ?>
                            @else
                                <?php
                                $question->pivot->points = 0;
                                ?>
                            @endif
                        @endif
                        Question Type: Test<br>
                        <hr>
                        Right answer: {{$questionOptions[($question->right_option - 1)]}}
                        <br>
                        Answer: {{$questionOptions[($question->pivot->answer - 1)]}}<br>
                    @endif
                    <br>

                    {{ Form::open(array('route' => array('correction-save..', $instance->id, $currentQuestion), 'style' => 'display:inline')) }}

                    {!! Form::number('points', $question->pivot->points, ['class' => 'form-control', 'step'=>'any', 'placeholder' => 'Points', 'maxlength'=>128, 'min' => '0', 'max' => $question->category->max_points]) !!}
                    <br>
                    {!! Form::textarea('comment', $question->pivot->comment, ['class' => 'form-control', 'placeholder' => 'Comment', 'maxlength'=>256]) !!}
                    <br>

                    @if($currentQuestion != 0)
                        <a href="{{route('question-correct..', [$instance->id, $currentQuestion - 1])}}" role="button"
                           class="btn btn-sm btn-primary mr-2">Previous</a>
                        {!! Form::button('Save and Previous', [ 'name' => 'action', 'value' => 'Save and Previous', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                    @endif

                    @if($currentQuestion != count($instance->instances_questions) - 1)
                        {!! Form::button('Save and Next', [ 'name' => 'action', 'value' => 'Save and Next', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                        <a href="{{route('question-correct..', [$instance->id, $currentQuestion + 1])}}" role="button"
                           class="btn btn-sm btn-primary mr-2">Next</a>
                    @else
                        {!! Form::button('Save and End Review', [ 'name' => 'action', 'value' => 'Save and End Review', 'onclick' => 'return confirm(\'Are you sure that you want to end this review?\')',' class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                        <a href="{{route('test-correct.instances-end', $instance->id)}}" onclick="return confirm('Are you sure that you want to end this review?')" role="button"
                           class="btn btn-sm btn-primary mr-2">End Review</a>
                    @endif

                    {!! Form::button('Save', [ 'name' => 'action', 'value' => 'Save', 'class' => 'btn btn-sm btn-primary mr-2', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>


</body>
</html>
