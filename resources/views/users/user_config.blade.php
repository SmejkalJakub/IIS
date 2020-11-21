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
                <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" value="{{Auth::user()->first_name}}" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('first_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  placeholder="Surname" id="surname" name="surname" value="{{Auth::user()->surname}}" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('surname') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" value="{{ Auth::user()->email}}" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Current password" id="currentPassword" name="currentPassword">
                @if ($errors->has('wrongCurrentPass'))
                    <span class="error">{{ $errors->first('wrongCurrentPass') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="New password" id="newPassword" name="newPassword">
                @if ($errors->has('newPassword'))
                    <span class="error">{{ $errors->first('newPassword') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm new password" id="newPasswordConfirmation" name="newPassword_confirmation">
                @if ($errors->has('newPassword_confirmation'))
                    <span class="error">{{ $errors->first('newPassword_confirmation') }}</span>
                @endif
            </div>
            <input type="checkbox" onclick="showPassword()"> Show Password

            <button type="submit" class="btn btn-success btn-block font-weight-bold">Save</button>
        </div>
    </form>
</div>

</body>
</html>

<script type="text/javascript">

    function showPassword() {
        var currentPassword = document.getElementById('currentPassword');
        var newPassword = document.getElementById("newPassword");
        var newPasswordConfirmation = document.getElementById("newPasswordConfirmation");

        console.log(newPassword.type);

        if (currentPassword.type === "password") {
            currentPassword.type = "text";
            newPassword.type = "text";
            newPasswordConfirmation.type = "text";

        } else {
            currentPassword.type = "password";
            newPassword.type = "password";
            newPasswordConfirmation.type = "password";
        }
    }

    window.onbeforeunload = function() {
        sessionStorage.setItem("first_name_config", $('#first_name').val());
        sessionStorage.setItem("surname_config", $('#surname').val());
        sessionStorage.setItem("email_config", $('#email').val());
    }


    window.onload = function() {

        var firstName = sessionStorage.getItem('first_name_config');
        var surname = sessionStorage.getItem('surname_config');
        var email = sessionStorage.getItem('email_config');

        if (firstName  !== null) $('#first_name').val(firstName);
        if (surname  !== null) $('#surname').val(surname);
        if (email  !== null) $('#email').val(email);

    }

</script>
