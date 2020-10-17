<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>
  <form action="{{url('post-register')}}" method="POST" id="regForm">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="inputFirstName">Full Name</label>
        <input type="text" class="form-control" id="inputFirstName" placeholder="Enter first name" name="first_name">
        @if ($errors->has('name'))
            <span class="error">{{ $errors->first('first_name') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="inputSurname">Full Name</label>
        <input type="text" class="form-control" id="inputSurname" placeholder="Enter surname" name="surname">
        @if ($errors->has('name'))
            <span class="error">{{ $errors->first('surname') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="inputEmailAddress">Email:</label>
        <input type="email" class="form-control" id="inputEmailAddress" placeholder="Enter email" name="email">
        @if ($errors->has('email'))
            <span class="error">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="inputPassword">Password:</label>
        <input type="password" class="form-control" id="inputPassword" placeholder="Enter password" name="password">
        @if ($errors->has('password'))
            <span class="error">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <button type="submit" class="btn btn-default">Submit</button>

    <div class="card-footer text-center">
        <div class="small"><a href="{{url('login')}}">Have an account? Go to login</a></div>
    </div>
  </form>
</div>

</body>
</html>
