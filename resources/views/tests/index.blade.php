<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tests</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container">
    <div class="row">
        <div class="col">
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
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <header><h1>Tests
                            @if (!(Auth::user() == null || !Auth::user()->hasRole('profesor')))
                                <a
                                    href="{{ route('tests.create') }}"
                                    class="btn btn-lg btn-primary align-middle float-right"> Add</a>

                            @endif
                        </h1>
                    </header>
                </div>


                <div class="card-body">
                    <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Test name</th>
                            <th scope="col">Created by</th>
                            <th scope="col">Max points</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($tests as $test)
                            <tr>
                                <td>
                                    {{ $test->id }}
                                </td>

                                <td>
                                    <a href="{{ route('tests.show', $test->id) }}">{{ $test->name }}</a>
                                </td>
                                <td>
                                    {{ $test->creator->first_name }}
                                    {{ $test->creator->surname }}
                                </td>
                                <td>
                                    {{$test->max_points}}
                                </td>
                                <td>

                                    <a href="{{ route('sign_on_test.create', $test->id) }}"
                                       class="btn btn-sm btn-primary">Sign on</a>
                                    @if (!(Auth::user() == null || !Auth::user()->hasRole('profesor')))

                                        <a href="{{ route('tests.edit', $test->id) }}"
                                           class="btn btn-sm btn-primary">Edit</a>

                                        {!! Form::open(['route' => ['tests.destroy', $test->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this test?\')']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
