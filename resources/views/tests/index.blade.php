<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container-fullwidth">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session('message') }}
        </div>
    @endif

    @if(Session::has('delete-message'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session('delete-message') }}
        </div>
    @endif
</div>

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="color: #373737">
        @if($role == 'student')
            @if($filter == 'available')
                Available tests
            @elseif($filter == 'registered')
                Registered tests
            @elseif($filter == 'active')
                Active tests
            @else
                Completed tests
            @endif
        @elseif($role == 'assistant')
            @if($filter == 'available')
                Available tests for correction
            @elseif($filter == 'registered')
                Registered tests for correction
            @elseif($filter == 'active')
                Active tests for correction
            @else
                Corrected tests
            @endif
        @else
            My tests
        @endif
    </h2>

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
        </div>
        @if($role == 'professor')
            <div class="col-auto">
                <a role="button" class="btn btn-success" href="{{ route('tests.create') }}">Add</a>
            </div>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                @if($role != 'professor')
                    <th>Created by</th>
                @endif
                @if($role != 'assistant')
                    <th>Max points</th>
                @endif
                @if($filter == 'registered')
                    <th>Apply</th>
                @elseif($role == 'student')
                    @if($filter == 'active')
                        <th>Duration</th>
                        <th>Available to</th>
                    @elseif($filter == 'history')
                        <th>Earned points</th>
                    @endif
                @elseif($role == 'assistant')
                    @if($filter == 'active' or $filter == 'history')
                        <th>Instances</th>
                        @if($filter == 'active')
                            <th>Corrected</th>
                        @endif
                        <th>Corrected by me</th>
                    @endif
                @else
                    <th>Last update</th>
                    <th>Students</th>
                    <th>Assistants</th>
                @endif
                <th></th>
            </tr>
            </thead>

            @include('layouts.search', ['searchType' => 'test', 'role' => $role, 'filter' => $filter])

        </table>
    </div>
</div>

</body>
</html>

