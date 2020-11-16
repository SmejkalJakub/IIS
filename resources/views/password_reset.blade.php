<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Reset Password'])
<body style="background-color: #B6B6B6">

@include('layouts.header')

@if($errors->has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ $errors->first('error') }}
</div>
@endif
<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Reset password</h2>
    <form action="{{url('reset-password')}}" method="POST" id="logForm">
        {{ csrf_field() }}
        <div class="p-3">
            <input type="hidden" class="form-control" id="token" name="token" value="{{$token}}"/>
            <input type="hidden" class="form-control" id="email" name="email" value="{{$email}}"/>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="New password" name="password" required>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm new password" name="password_confirmation" required>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold">Save</button>
        </div>

        <hr>

        <div class="p-3">
            <a role="button" class="btn btn-block btn-secondary" href="{{url('login')}}">Back to Login</a>
        </div>
    </form>
</div>

</body>
</html>
