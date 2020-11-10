<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">Best Tests</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{route('home')}}">Home</a></li>
            <li><a href="tests">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor') || Auth::user()->hasRole('admin'))
                <li><a href="{{route('categories')}}">Categories</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{route('user')}}"><span
                        class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}
                </a></li>
            <li><a href="{{route('logout')}}"><span></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <table class="table">
        <tr>
            <td>
                <div class="form-group">
                    <label>Search</label>
                    <label for="search"></label><input type="text" class="form-controller" id="search" name="search"/>
                </div>
            </td>
        </tr>
    </table>
</div>
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
                    <header><h1>Categories
                            <a
                                href="{{ route('categories.create') }}"
                                class="btn btn-lg btn-primary align-middle float-right">Add</a>
                        </h1>
                    </header>
                </div>


                <div class="card-body">
                    <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category name</th>
                            <th scope="col">Points per question</th>
                            <th scope="col">Number of questions</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->id }}
                                </td>

                                <td>
                                    <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                                </td>

                                <td>
                                    {{$category->max_points}}
                                </td>
                                <?php
                                $noq = 0;
                                foreach ($questions_cids as $cid) {
                                    if ($cid == $category->id) {
                                        $noq++;
                                    }
                                }
                                ?>
                                <td>
                                    {{$noq}}
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-primary">Edit</a>

                                    {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                    {!! Form::close() !!}
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
