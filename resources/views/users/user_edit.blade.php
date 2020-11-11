<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container">
    <h2>Settings</h2>
    <form action="{{url('save-edit')}}" method="POST" id="regForm">
      {{ csrf_field() }}
      <div class="form-group">
        <input type="hidden" id="id" name="id" value={{$user->id}}>
      </div>
      <div class="form-group">
          <label for="inputFirstName">First Name</label>
          <input type="text" class="form-control" id="inputFirstName" placeholder="Enter full name" name="first_name" value={{$user->first_name}}>
          @if ($errors->has('first_name'))
              <span class="error">{{ $errors->first('first_name') }}</span>
          @endif
      </div>
      <div class="form-group">
        <label for="inputSurname">Surname</label>
        <input type="text" class="form-control" id="inputSurname" placeholder="Enter full name" name="surname" value={{$user->surname}}>
        @if ($errors->has('surname'))
            <span class="error">{{ $errors->first('surname') }}</span>
        @endif
    </div>
      <div class="form-group">
          <label for="inputEmailAddress">Email:</label>
          <input type="email" class="form-control" id="inputEmailAddress" placeholder="Enter email" name="email" value={{$user->email}}>
          @if ($errors->has('email'))
              <span class="error">{{ $errors->first('email') }}</span>
          @endif
      </div>
      <div class="form-group">
        <label for="inputRole">Role:</label>
        <select id="inputRole" name="role">
            <option value="student" {{ ($user->role == 'student') ? 'selected' : '' }}>Student</option>
            <option value="assistant" {{ ($user->role == 'assistant') ? 'selected' : '' }}>Assistant</option>
            <option value="profesor" {{ ($user->role == 'profesor') ? 'selected' : '' }}>Profesor</option>
            <option value="admin" {{ ($user->role == 'admin') ? 'selected' : '' }}>Admin</option>
          </select>
    </div>
        <a href="{{ route('user-list') }}" class="btn btn-sm btn-primary">Back</a>
      <button type="submit" class="btn btn-sm btn-warning">Save</button>
    </form>
  </div>

</body>
</html>
