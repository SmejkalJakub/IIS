<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])

<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a role="button" class="btn btn-secondary" href="{{route('tests..', ['professor', 'myTests']) }}">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="mb-3 text-center" style="color: #373737">Instances of test <b>{{$instances[0]->test->name}}</b></h2>
        </div>
        <div class="col-sm-2"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Students name</th>
                <th>Assistant name</th>
                <th>Max points</th>
                <th>Points</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($instances as $instance)
                <?php
                $total_points = 0;
                $categories = $instance->test->categories;

                foreach($categories as $category)
                {
                    $total_points += ($category->max_points * $category->pivot->number_of_questions);
                }
                ?>

                <tr>
                <td>{{ $instance->student->first_name }} {{ $instance->student->surname }}</td>
                @if($instance->assistant == null)
                    <td>No assistant</td>
                @else
                    <td>{{ $instance->assistant->first_name }} {{ $instance->assistant->surname }}</td>
                @endif
                <td>{{$total_points}}</td>
                <td>{{$instance->points}}</td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{route('tests...results', ['assistant' ,$instance->test->id, $instance->student_id])}}" role="button" class="btn btn-sm btn-info ml-2">Student view</a>
                    </div>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
