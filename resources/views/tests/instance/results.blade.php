<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container rounded mt-5 pt-4 pl-4 pr-4 pb-4 bg-white">
    <div class="row" style="padding: 0px">
        <div class="col-sm-2">
            <a role="button" class="btn btn-secondary" href="{{($from == 'student') ? route('tests..', ['student', 'history']) : route('tests..instance.', ['history', $test_id, Auth::id()])}}">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$instance->test->name}}</span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>

<div class="container" style="padding-left: 0px; padding-right: 0px">
    <?php
    $i = 1;
    ?>

    @foreach($questions as $question)
        <?php
        if($question->pivot->points == $question->category->max_points)
        {
            $bgColor = '#74FF6F';
        }
        else
        {
            $bgColor = '#FF6F6F';
        }
        ?>

        <div class="rounded mt-2 bg-white p-4">
            <h4>Task {{$i}}</h4><hr>
            <p>{{$question->task}}</p>

            @if($question->image_path)
                <label class="font-weight-bold mt-3">Image</label>
                <div class="mb-3" style="max-height: 600px; max-width: 600px">
                    <img class="border rounded" src="/public{{ $question->image_path }}"
                         alt="{{ $question->image_path }}" style="max-height: 100%; max-width: 100%"/>
                </div>
            @endif

            @if($question->type_of_answer == 1)
                <label class="font-weight-bold mt-3" style="color: #373737">Your solution</label>
                @if($question->pivot->answer)
                    <div class="rounded border p-2 mb-5">
                        {{$question->pivot->answer}}
                    </div>
                @else
                    <p class="font-weight-bold text-danger mb-5"> - Missing</p>
                @endif
            @else
                <label class="font-weight-bold mt-3" style="color: #373737">Your answer</label>
                <form class="mb-5">
                    <div class="form-check" style="padding-left: 0px">
                        {!! Form::radio('testQuestion', '1', ($question->pivot->answer == 1), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_1, ['class' => (($question->pivot->answer == 1) ? (($question->pivot->points != null) ? (($question->right_option == 1) ? 'font-weight-bold text-success' : 'font-weight-bold text-danger') : 'font-weight-bold') : '')]) !!}
                    </div>
                    <div class="form-check" style="padding-left: 0px">
                        {!! Form::radio('testQuestion', '2', ($question->pivot->answer == 2), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_2, ['class' => (($question->pivot->answer == 2) ? (($question->pivot->points != null) ? (($question->right_option == 2) ? 'font-weight-bold text-success' : 'font-weight-bold text-danger') : 'font-weight-bold') : '')]) !!}
                    </div>
                    <div class="form-check" style="padding-left: 0px">
                        {!! Form::radio('testQuestion', '3', ($question->pivot->answer == 3), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_3, ['class' => (($question->pivot->answer == 3) ? (($question->pivot->points != null) ? (($question->right_option == 3) ? 'font-weight-bold text-success' : 'font-weight-bold text-danger') : 'font-weight-bold') : '')]) !!}
                    </div>
                    <div class="form-check" style="padding-left: 0px">
                        {!! Form::radio('testQuestion', '4', ($question->pivot->answer == 4), ['disabled' => 'disabled']) !!} {!! Form::label(null, $question->option_4, ['class' => (($question->pivot->answer == 4) ? (($question->pivot->points != null) ? (($question->right_option == 4) ? 'font-weight-bold text-success' : 'font-weight-bold text-danger') : 'font-weight-bold') : '')]) !!}
                    </div>
                </form>
            @endif

            @if($question->pivot->points === null)
                <div class="p-2 rounded" style="background-color: #C4C4C4">
                    <b>Not reviewed yet</b>
                </div>
            @else
                <div class="p-2 rounded" style="background-color: {{$bgColor}}">
                    <b>{{$question->pivot->points}} p.</b> (out of {{$question->category->max_points}} p.)
                </div>

                @if($question->pivot->comment != null)
                    <label class="font-weight-bold mt-3" style="color: #373737">Comment</label>
                    <div class="rounded border p-2">
                        {{$question->pivot->comment}}
                    </div>
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
