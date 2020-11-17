<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])


{{$instance->test->name}}<br>
{{$instance->test->description}}<br>
{{$instance->test->creator->first_name}} {{$instance->test->creator->surname}}<br>

{{$instance->test->max_duration}}<br>

<a href="{{route('test-fill..', [$instance->id, 0])}}" role="button" class="btn btn-sm btn-success mr-2">Start the test</a>

</body>
</html>
