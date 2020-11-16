<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Settings'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'userSetting'])

<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Edit profile</h2>
    <form action="{{url('save-config')}}" method="POST" id="regForm">
        {{ csrf_field() }}
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
                <input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ Auth::user()->email}}" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Current password" name="currentPassword">
                @if ($errors->has('wrongCurrentPass'))
                    <span class="error">{{ $errors->first('wrongCurrentPass') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="New password" name="newPassword">
                @if ($errors->has('newPassword'))
                    <span class="error">{{ $errors->first('newPassword') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm new password" name="newPassword_confirmation">
                @if ($errors->has('newPassword_confirmatio'))
                    <span class="error">{{ $errors->first('newPassword_confirmatio') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold">Save</button>
        </div>
    </form>
</div>

</body>
</html>
