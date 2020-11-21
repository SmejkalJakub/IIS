<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Register'])
<body style="background-color: #B6B6B6">

@include('layouts.header')

<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Registration</h2>
    <form action="{{url('post-register')}}" method="POST" id="regForm">
        {{ csrf_field() }}
        <div class="p-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="First name" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  placeholder="Surname" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" minlength="6">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm password" id="passwordConfirmation" name="passwordConfirmation" required>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold">Register</button>
        </div>
    </form>

    <hr>

    <div class="p-3">
        <a role="button" class="btn btn-block btn-secondary" href="{{url('login')}}">Have an account? Sign in</a>
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
        sessionStorage.setItem("first_name_register", $('#first_name').val());
        sessionStorage.setItem("surname_register", $('#surname').val());
        sessionStorage.setItem("email_register", $('#email').val());
    }


    window.onload = function() {

        var firstName = sessionStorage.getItem('first_name_register');
        var surname = sessionStorage.getItem('surname_register');
        var email = sessionStorage.getItem('email_register');

        if (firstName  !== null) $('#first_name').val(firstName);
        if (surname  !== null) $('#surname').val(surname);
        if (email  !== null) $('#email').val(email);

    }

</script>
