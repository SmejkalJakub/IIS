<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="text-center"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$instance->test->name}}</span></h2>

    <?php
    $i = 1;
    ?>

    @foreach($questions as $question)
        <?php
        if($question->pivot->points == null)
        {
            $bgColor = '#E5E5E5';
        }
        elseif($question->pivot->points != $question->category->max_points)
        {
            $bgColor = '#FFDCDC';
        }
        else
        {
            $bgColor = '#E6FFDC';
        }
        ?>
        <div class="mt-4 pt-3 pl-3 pr-3 rounded border" style="background-color: {{$bgColor}}">
            <h4>Task {{$i}}</h4><hr>
            <p>{{$question->task}}</p>

            @if($question->type_of_answer == 1)
                <label class="font-weight-bold mt-3" style="color: #373737">Your solution</label>
                <p>{{$question->pivot->answer}}</p>
            @else
                <?php
                $questionOptions = array($question->option_1, $question->option_2, $question->option_3, $question->option_4);
                ?>
                <p><span class="font-weight-bold mt-3" style="color: #373737">Your answer:</span> {{$questionOptions[($question->pivot->answer - 1)]}}</p>
            @endif
            <hr>
            @if($question->pivot->points == null)
                <p>Not reviewed yet.</p>
            @else
                <p><span class="font-weight-bold" style="color: #373737">Points:</span> <b>{{$question->pivot->points}}</b> out of {{$question->category->max_points}}</p>

                @if($question->pivot->comment != null)
                    <label class="font-weight-bold mt-3" style="color: #373737">Comment</label>
                    <p>{{$question->pivot->comment}}</p>
                @endif
            @endif
        </div>

        <?php
        $i++;
        ?>
    @endforeach
</div>

</body>
</html>
