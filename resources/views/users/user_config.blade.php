<!DOCTYPE html>
<html lang="en">
<head>
  <title>Settings</title>
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
            <li><a href="{{route('categories')}}">Tests</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('user-list')}}">Users</a></li>
            @endif
            @if(Auth::user()->hasRole('profesor'))
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
    <h2>Settings</h2>
    <form action="{{url('save-config')}}" method="POST" id="regForm">
      {{ csrf_field() }}
      <div class="form-group">
          <label for="inputFirstName">First Name</label>
          <input type="text" class="form-control" id="inputFirstName" placeholder="Enter full name" name="first_name" value={{Auth::user()->first_name}}>
          @if ($errors->has('first_name'))
              <span class="error">{{ $errors->first('first_name') }}</span>
          @endif
      </div>
      <div class="form-group">
        <label for="inputSurname">Surname</label>
        <input type="text" class="form-control" id="inputSurname" placeholder="Enter full name" name="surname" value={{Auth::user()->surname}}>
        @if ($errors->has('surname'))
            <span class="error">{{ $errors->first('surname') }}</span>
        @endif
    </div>
      <div class="form-group">
          <label for="inputEmailAddress">Email:</label>
          <input type="email" class="form-control" id="inputEmailAddress" placeholder="Enter email" name="email" value={{ Auth::user()->email}}>
          @if ($errors->has('email'))
              <span class="error">{{ $errors->first('email') }}</span>
          @endif
      </div>
      <div class="form-group">
        <label for="inputNewPassword">New Password:</label>
          <label for="newPassword"></label><input type="password" class="form-control" id="newPassword" placeholder="New password" name="newPassword">
        <b>
            @if($errors->has('notMatching'))
                {{ implode('', $errors->all(':message')) }}
            @endif
        </b>
    </div>
    <div class="form-group">
        <label for="inputNewPasswordConfirm">New Password Again:</label>
        <label for="newPasswordConfirm"></label><input type="password" class="form-control" id="newPasswordConfirm" placeholder="New password again" name="newPasswordConfirm">
    </div>
      <button type="submit" class="btn btn-default">Save</button>
    </form>
  </div>

</body>
</html>
