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
      <li class="active"><a href="tests">Tests</a></li>
        @if(Auth::user()->hasRole('admin'))
            <li><a href="user-list">Users</a></li>
        @endif
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="user"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}</a></li>
        <li><a href="logout"><span></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
</div>

</body>
</html>
