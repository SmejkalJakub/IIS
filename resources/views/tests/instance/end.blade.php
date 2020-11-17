<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<h2>End Of Test</h2>
{{$instance->test->name}}<br>
{{$instance->test->description}}<br>
{{$instance->test->creator->first_name}} {{$instance->test->creator->surname}}<br>

{{$instance->test->max_duration}}<br>

<a href="{{route('home')}}" role="button" class="btn btn-sm btn-success mr-2">End the test</a>
<a href="{{route('test-fill..', [$instance->id, 0])}}" role="button" class="btn btn-sm btn-success mr-2">Return to the test</a>

</body>
</html>
