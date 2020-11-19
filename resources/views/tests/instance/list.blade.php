<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])

<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="    color: #373737">Categories</h2>

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
        </div>
        <div class="col-auto">
            <a role="button" class="btn btn-success" href="{{ route('categories.create') }}">Add</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($instances as $instance)
                <tr>
                <td>
                    {{ $instance->student->first_name }} {{ $instance->student->surname }}
                </td>
                <td>
                    0
                </td>
                <td>
                    <a href="{{route('test-correct.', $instance->id)}}" role="button" class="btn btn-sm btn-success mr-2">Review the test</a>
                </td>
                </tr>
            @endforeach
            </tbody>

            {{-- @include('layouts.search', ['searchType' => 'category']) --}}

        </table>
    </div>
</div>
</body>
</html>
