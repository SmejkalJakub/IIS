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
                <input type="text" class="form-control" placeholder="First name" name="first_name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  placeholder="Surname" name="surname" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" minlength="6">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm password" name="passwordConfirmation" required>
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
