<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Edit User'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Edit profile</h2>
    <form action="{{url('save-edit')}}" method="POST" id="regForm">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="hidden" id="id" name="id" value={{$user->id}}>
        </div>
        <div class="p-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="First name" name="first_name" value="{{Auth::user()->first_name}}" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('first_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  placeholder="Surname" name="surname" value="{{Auth::user()->surname}}" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('surname') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ Auth::user()->email}}" reqiured>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputRole">Role</label>
                </div>
                <select class="form-control" id="inputRole" name="role">
                    <option value="student" {{ ($user->role == 'student') ? 'selected' : '' }}>Student</option>
                    <option value="assistant" {{ ($user->role == 'assistant') ? 'selected' : '' }}>Assistant</option>
                    <option value="profesor" {{ ($user->role == 'profesor') ? 'selected' : '' }}>Profesor</option>
                    <option value="admin" {{ ($user->role == 'admin') ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold mt-3">Save</button>
        </div>
    </form>

    <hr>

    <div class="p-3">
        <a role="button" class="btn btn-block btn-secondary" href="{{url('user-list')}}">Back</a>
    </div>
</div>

</body>
</html>
