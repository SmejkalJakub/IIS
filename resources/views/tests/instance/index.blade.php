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
                <div
                    class="card-header"><h1>{{$instance->test->name}}</h1></div>

                <div class="card-body">

                    <div>
                        <h3>
                            <b>Description</b>
                        </h3>
                        {{$instance->test->description}}
                        <h3>
                            <b>Author</b>
                        </h3>
                        {{$instance->test->creator->first_name}} {{$instance->test->creator->surname}}<br>
                        <h3>
                            <b>Available from</b>
                        </h3>
                        {{$instance->test->available_from}}<br>
                        <h3>
                            <b>Available to</b>
                        </h3>
                        {{$instance->test->available_to}}<br>
                        <h3>
                            <b>Max duration</b>
                        </h3>
                        {{$instance->test->max_duration}}<br>
                        <h3>
                            <b>Number of questions</b>
                        </h3>
                        <?php
                        $number_of_questions = 0;
                        foreach ($instance->test->categories as $test_category) {
                            $number_of_questions += $test_category->pivot->number_of_questions;
                        }
                        ?>
                        {{$number_of_questions}}
                        <div>
                            <a href="{{route('test-fill..', [$instance->id, 0])}}" role="button"
                               class="btn btn-sm btn-success mr-2">Start the
                                test</a>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
