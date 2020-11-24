<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Home'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'home'])

<div class="container-fluid ml-3 mt-5">
    <div class="row">
        <div class="col-sm-3 rounded bg-white p-4">
            <div>Name: <b>{{Auth::User()->first_name}} {{Auth::User()->surname}}</b></div>
            <div>Email: {{Auth::User()->email}}</div>
            <div>Role: {{Auth::User()->role}}</div><hr>

            <a role="button" href="{{route('tests..', ['student', 'available'])}}" class="btn btn-lg text-left btn-block mt-4 btn-success">Available tests</a>
            <a role="button" href="{{route('tests..', ['student', 'history'])}}" class="btn btn-lg text-left btn-block mt-3 btn-success">My filled tests</a>

            @if(App\Http\Controllers\AuthController::checkUser('assistant'))
                <a role="button" href="{{route('tests..', ['assistant', 'available'])}}" class="btn btn-lg text-left btn-block mt-3 btn-success">Available corrections</a>
                <a role="button" href="{{route('tests..', ['assistant', 'history'])}}" class="btn btn-lg text-left btn-block mt-3 btn-success">My corrections</a>
            @endif

            @if(App\Http\Controllers\AuthController::checkUser('profesor'))
                <a role="button" href="{{route('tests..', ['professor', 'history'])}}" class="btn btn-lg text-left btn-block mt-3 btn-success">My tests</a>
            @endif

            @if(App\Http\Controllers\AuthController::checkUser('admin'))
                <a role="button" href="{{route('user-list')}}" class="btn btn-lg text-left btn-block mt-3 btn-success">Manage users</a>
            @endif

            <a role="button" class="btn btn-lg btn-info text-left mt-5 btn-block" href="{{route('logout')}}">Log out</a>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">

    window.onload = function() {
        sessionStorage.removeItem("first_name_register");
        sessionStorage.removeItem("surname_register");
        sessionStorage.removeItem("email_register");
    }
</script>
