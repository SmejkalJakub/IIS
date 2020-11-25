<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <?php
            $now = strtotime(now());
            $show_get_back = false;

            if($instance != null) {

                sscanf($instance->test->max_duration, "%d:%d", $hours, $minutes);
                $duration = isset($hours) ? $hours * 3600 + $minutes * 60 : $minutes * 60;

                $time_between_now_start = $now - strtotime($instance->opened_at);
                if ($duration - $time_between_now_start > 0) {
                    $show_get_back = true;
                }
            }
            ?>

            @if($show_get_back)
                <a href="{{route('test-fill..', [$instance->id, 0])}}" role="button" class="btn btn-info mr-2">Back to the tasks</a>
            @endif
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$instance->test->name}}</span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>

    <?php
    $total_max_test_points = 0;
    $total_num_of_questions = 0;
    $test_categories = $instance->test->categories;

    foreach($test_categories as $test_category)
    {
        $num_of_questions = $test_category->pivot->number_of_questions;

        $total_max_test_points += ($test_category->max_points * $test_category->pivot->number_of_questions);
        $total_num_of_questions += $num_of_questions;
    }
    ?>

    <div class="p-3 border rounded">
        @include('tests.testInfo', ['total_max_test_points' => $total_max_test_points, 'total_num_of_questions' => $total_num_of_questions, 'test' => $instance->test])

       <h4><span style="color: #373737">Remaining time: </span> <span class="font-weight-normal" id="timer"></span></h4><hr>

        <a href="{{route('test.finish', $instance->id)}}" role="button" class="btn btn-sm {{$color}}">End test</a>
    </div>
</div>

@include('layouts.timer', ['divId' => 'timer'])

</body>
</html>
