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

@include('layouts.navbar', ['activeBar' => 'categories'])

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

                                <td>
                                    {{$category->number_of_questions}}
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-sm btn-primary">Edit</a>

                                    {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this category?\')']) !!}
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
