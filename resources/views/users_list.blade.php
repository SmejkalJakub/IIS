<!DOCTYPE html>
<html lang="en">
<head>
  <title>Users</title>
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
        @if(Auth::user()->hasRole('profesor'))
            <li><a href="categories">Categories</a></li>
        @endif
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="user"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}</a></li>
        <li><a href="logout"><span></span> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="form-group">
        <label>Search</label>
        <input type="text" class="form-controller" id="search" name="search"/>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
          <th></th>
          <th></th>
        </thead>

    <tbody>
    </tbody>

    </table>
    <script type="text/javascript">
        $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
        type : 'get',
        url : '{{URL::to('search')}}',
        data:{'search':$value},
        success:function(data){
        $('tbody').html(data);
        }
        });
        })
    </script>
    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure?");
        });
    </script>
    </body>
</html>

