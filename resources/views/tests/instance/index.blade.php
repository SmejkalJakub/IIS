<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a role="button" class="btn btn-secondary" href="{{route('tests..', ['student', 'active'])}}">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4"><span style="color: #373737">Test:</span> <span class="font-weight-normal">{{$test->name}}</span></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>

    <?php
    $total_max_test_points = 0;
    $total_num_of_questions = 0;
    $test_categories = $test->categories;

    foreach($test_categories as $test_category)
    {
        $num_of_questions = $test_category->pivot->number_of_questions;

        $total_max_test_points += ($test_category->max_points * $test_category->pivot->number_of_questions);
        $total_num_of_questions += $num_of_questions;
    }
    ?>

    <div class="p-3 border rounded">
        @include('tests.testInfo', ['total_max_test_points' => $total_max_test_points, 'total_num_of_questions' => $total_num_of_questions, 'test' => $test])

        <a href="{{route('test.create', $test->id)}}" role="button" class="btn btn-sm btn-success mr-2">Start the test</a>
    </div>
</div>

</body>
</html>
