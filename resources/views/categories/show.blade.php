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
            <li><a href="">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor'))
                <li class="active"><a href="{{route('categories')}}">Categories</a></li>
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
<div class="overlay"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <header>
                        <h1>
                            Category {{$category->name}}
                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="btn btn-sm btn-primary">Edit</a>
                        </h1>
                        <h2>


                        </h2>
                    </header>
                </div>


                <article>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-10 mx-auto">
                                <h1>
                                    Description
                                </h1>
                                {{ $category->description }}
                                <div>
                                    <h2>
                                        Max points
                                    </h2>
                                    {{$category->max_points}}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="card-body">
                    <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td>
                                    <a href="{{ route('questions.show', $question->id) }}">{{ $question->id }}</a>

                                </td>
                                <td>
                                    <a href="{{ route('questions.edit', $question->id) }}"
                                       class="btn btn-sm btn-primary">Edit</a>

                                    {!! Form::open(['route' => ['questions.destroy', $question->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
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

