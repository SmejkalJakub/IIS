<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body>

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])


{{$instance->test->name}}<br>
{{$instance->test->description}}<br>
Creator: {{$instance->test->creator->first_name}} {{$instance->test->creator->surname}}<br>

Student: {{$instance->student->first_name}} {{$instance->student->surname}}<br>

<a href="{{route('question-correct..', [$instance->id, 0])}}" role="button" class="btn btn-sm btn-success mr-2">Correct the test</a>


</body>
</html>
