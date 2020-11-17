<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Home'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'home'])


@foreach ($tests as $test)

{{$test->name}}
<a href="{{route('test.create', $test->id)}}" role="button" class="btn btn-sm btn-success mr-2">Fill the test</a>

@endforeach



</body>
</html>
