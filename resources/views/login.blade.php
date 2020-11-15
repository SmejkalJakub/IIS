<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Login'])
<body style="background-color: #B6B6B6">

@include('layouts.header')

@if(Session::has('error-message'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session('error-message') }}
    </div>
@endif
@if(Session::has('suc-message'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session('suc-message') }}
    </div>
@endif
<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Test yourself...</h2>
    <form action="{{url('post-login')}}" method="POST" id="logForm">
        {{ csrf_field() }}
        <div class="p-3">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail" name="email">
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password">
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold">Log in</button>
        </div>
    </form>

    <div class="text-center">
        <a class="text-success" href="{{ route('reset-password') }}">Forgotten password?</a>
    </div>

    <hr>

    <div class="p-3">
        <a role="button" class="btn btn-block btn-secondary" href="{{url('register')}}">Don't have an account? Sign up</a>
    </div>
</div>

</body>
</html>


