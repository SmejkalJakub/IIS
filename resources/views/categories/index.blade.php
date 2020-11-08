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
            <li><a href="../tests">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor') || Auth::user()->hasRole('admin'))
                <li><a href="{{route('categories')}}">Categories</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{route('user')}}"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}</a></li>
            <li><a href="{{route('logout')}}"><span></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <table class="table">
        <tr>
            <td><div class="form-group">
                <label>Search</label>
                    <label for="search"></label><input type="text" class="form-controller" id="search" name="search"/>
                </div>
            </td>
            <td align="right"><button type="button" class="btn btn-success" style="background-color: #4a5568"><b>+ Add Category</b></button></td>
        </tr>
    </table>

    <table class="table table-bordered table-hover">
        <thead>
          <th>Name</th>
          <th>Points per question</th>
          <!---<th></th>
          <th></th>
        </thead>--->

        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->name}}</td>
                    <td>{{$category->max_points}}</td>
                    <!---<td>
                        <form class="delete" action="{{ route('user.delete', [$user->id]) }}" method="DELETE">
                        <input type="hidden" name="_method" value="DELETE">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                        <form class="edit" action="{{ route('user.edit', [$user->id]) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-info" value="Edit">
                        </form>
                    </td>--->
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
</body>
</html>
