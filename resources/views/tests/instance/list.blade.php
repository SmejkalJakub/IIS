<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])

<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="color: #373737">Test Instances</h2>

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Reviewer</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($instances as $instance)
                @if($listType == 'testInstances')
                    @if($instance->assistant and $instance->assistant->id != Auth::id())
                        @continue
                    @endif
                @endif
                <tr>
                <td>
                    {{ $instance->student->first_name }} {{ $instance->student->surname }}
                </td>
                <td>
                @if($instance->assistant)
                    {{ $instance->assistant->first_name }} {{ $instance->assistant->surname }}
                @else
                    No Assistant
                @endif
                </td>
                <td>
                    {{$instance->points}}
                </td>
                <td>
                @if($listType == 'testInstances')
                    @if(!$instance->assistant or $instance->assistant->id == Auth::id())
                        <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm btn-success mr-2">Review the test</a>
                    @endif
                @elseif($listType == 'myInstances')
                        <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm btn-success mr-2">Review the test</a>
                        <a href="{{route('test..results', [$instance->test->id, $instance->student_id])}}" role="button" class="btn btn-sm btn-success mr-2">Detail</a>
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
