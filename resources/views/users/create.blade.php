<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Create User'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">

    <?php
        $randomPass = Str::random(12);
    ?>
    <h2 class="mb-3 text-center" style="color: #373737">Create User</h2>
    <form action="{{url('user/create/save')}}" method="POST" id="regForm">
        {{ csrf_field() }}
        <div class="p-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('first_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  placeholder="Surname" id="surname" name="surname" required>
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('surname') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" reqiured>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Confirm E-mail" id="emailConfirmation" name="emailConfirmation" reqiured>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="{{$randomPass}}" reqiured>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="passwordConfirmation" name="passwordConfirmation" value="{{$randomPass}}" reqiured>
                @if ($errors->has('passwordConfirmation'))
                    <span class="error">{{ $errors->first('passwordConfirmation') }}</span>
                @endif
            </div>
            <input type="checkbox" onclick="showPassword()"> Show Password

            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputRole">Role</label>
                </div>
                <select class="form-control" id="inputRole" name="role">
                    <option value="student" selected>Student</option>
                    <option value="assistant">Assistant</option>
                    <option value="profesor">Profesor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold mt-3">Create</button>
        </div>
    </form>

    <hr>

    <div class="p-3">
        <a role="button" class="btn btn-block btn-secondary" href="{{url('user-list')}}">Back</a>
    </div>
</div>

</body>
</html>

<script type="text/javascript">

    function showPassword() {
        var password = document.getElementById("password");
        var passwordConfirmation = document.getElementById("passwordConfirmation");

        if (password.type === "password") {
            password.type = "text";
            passwordConfirmation.type = "text";

        } else {
            password.type = "password";
            passwordConfirmation.type = "password";
        }
    }

    window.onbeforeunload = function() {
        sessionStorage.setItem("first_name", $('#first_name').val());
        sessionStorage.setItem("surname", $('#surname').val());
        sessionStorage.setItem("email", $('#email').val());
        sessionStorage.setItem("emailConfirmation", $('#emailConfirmation').val());
        sessionStorage.setItem("inputRole", $('#inputRole').val());
    }


    window.onload = function() {

        var firstName = sessionStorage.getItem('first_name');
        var surname = sessionStorage.getItem('surname');
        var email = sessionStorage.getItem('email');
        var emailConfirmation = sessionStorage.getItem('emailConfirmation');
        var role = sessionStorage.getItem('inputRole');

        if (firstName  !== null) $('#first_name').val(firstName);
        if (surname  !== null) $('#surname').val(surname);
        if (email  !== null) $('#email').val(email);
        if (emailConfirmation  !== null) $('#emailConfirmation').val(emailConfirmation);
        if (role  !== null) $('#inputRole').val(role);

    }

</script>

