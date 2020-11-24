<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])

<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="color: #373737">Test Instances</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Max points</th>
                <th>Points</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($instances as $instance)
                @if($listType == 'testInstances')
                    @if($instance->assistant and $instance->assistant->id != Auth::id())
                        @continue
                    @endif
                @endif

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
                <td>{{$total_points}}</td>
                <td>{{$instance->points}}</td>
                <td>
                @if($listType == 'testInstances')
                    @if(!$instance->assistant)
                        <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm float-right btn-info">Review the test</a>
                    @elseif($instance->assistant->id == Auth::id())
                        <?php
                            $revisionState = App\Http\Helpers\testInstanceHelper::stateOfFilling($instance, true);
                        ?>
                        <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm float-right {{$revisionState}}">Edit revision</a>
                    @endif
                @elseif($listType == 'myInstances')
                    <div class="d-flex justify-content-end">
                        <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm btn-success">Edit revision</a>
                        <a href="{{route('test..results', [$instance->test->id, $instance->student_id])}}" role="button" class="btn btn-sm btn-info ml-2">Student view</a>
                    </div>
                @endif
                </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>
</body>
</html>
