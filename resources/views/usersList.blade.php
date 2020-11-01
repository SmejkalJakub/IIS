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

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="home">Best Tests</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="home">Home</a></li>
      <li><a href="tests">Tests</a></li>
        @if(Auth::user()->hasRole('admin'))
            <li class="active"><a href="user-list">Users</a></li>
        @endif
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="user"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}</a></li>
        <li><a href="logout"><span></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <table class="table table-hover">
        <thead>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </thead>

        <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->first_name}} {{$user->surname}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role}}</td>
            <td>
                <form class="delete" action="{{ route('user.delete', [$user->id]) }}" method="DELETE">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
                <input type="submit" class="btn btn-danger" value="Delete">
                </form>
                <form class="edit" action="{{ route('user.edit', [$user->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-info" value="Edit">
                </form>
            </td>
        </tr>
    @endforeach

        </tbody>
    </table>
</div>

</body>
</html>

<script>
    $(".delete").on("submit", function(){
        return confirm("Are you sure?");
    });
</script>
