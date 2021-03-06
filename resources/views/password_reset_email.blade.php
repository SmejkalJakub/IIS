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
@if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session('status') }}
    </div>
@endif

<div class="container mt-5 p-3 bg-white rounded" style="max-width: 400px">
    <h2 class="mb-3 text-center" style="color: #373737">Login issues?</h2>
    <form action="{{url('reset-password-request')}}" method="POST" id="logForm">
        {{ csrf_field() }}
        <div class="p-3">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="E-mail *" name="email" required>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-block font-weight-bold">Reset Password</button>
        </div>

        <hr>

        <div class="p-3">
            <a role="button" class="btn btn-block btn-secondary" href="{{url('login')}}">Back to login</a>
        </div>
    </form>
</div>

</body>
</html>
