<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Categories'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'categories'])

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
    <h2 class="mb-3 text-center" style="color: #373737">Categories</h2>

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
                <th>Points per question</th>
                <th>Number of questions</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            {{$category->max_points}}
                        </td>
                        <td>
                            {{$category->number_of_questions}}
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <a role="button" class="btn btn-sm btn-success mr-2" href="{{ route('categories.edit', $category->id) }}">Edit</a>

                                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this category?\')']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
