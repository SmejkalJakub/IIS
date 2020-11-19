<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($questions as $question)
                <div class="card">
                    Title: {{$question->name}}<br>
                    Task: {{$question->task}}<br><br>



                    @if($question->type_of_answer == 1)
                        Answer: {{$question->pivot->answer}}<br>
                    @else
                        <?php
                        $questionOptions = array($question->option_1, $question->option_2, $question->option_3, $question->option_4);
                        ?>
                        Answer: {{$questionOptions[($question->pivot->answer - 1)]}}<br>
                    @endif

                    <br>
                    @if($question->pivot->points == null)
                        Not yet reviewed.
                    @else
                        Points: {{$question->pivot->points}} out of {{$question->category->max_points}}<br>
                        Reviewer comment: {{$question->pivot->comment}}
                    @endif
                </div>
            @endforeach


        </div>
    </div>
</div>


</body>
</html>
