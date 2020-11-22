<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Home'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'home'])

Name: {{Auth::User()->first_name}} {{Auth::User()->surname}} <br>
Email: {{Auth::User()->email}} <br>
Role: {{Auth::User()->role}} <br>



<a role="button" href="{{route('tests..', ['student', 'available'])}}" class="btn btn-lg btn-success ">Available tests</a><br><br>
<a role="button" href="{{route('tests..', ['student', 'history'])}}" class="btn btn-lg btn-success ">My filled tests</a><br><br>


@if(App\Http\Controllers\AuthController::checkUser('assistant'))
    <a role="button" href="{{route('tests..', ['assistant', 'available'])}}" class="btn btn-lg btn-success ">Available corrections</a><br><br>
    <a role="button" href="{{route('tests..', ['assistant', 'history'])}}" class="btn btn-lg btn-success ">My corrections</a><br><br>
@endif
@if(App\Http\Controllers\AuthController::checkUser('profesor'))
    <a role="button" href="{{route('tests..', ['professor', 'history'])}}" class="btn btn-lg btn-success ">My tests</a><br><br>
@endif

@if(App\Http\Controllers\AuthController::checkUser('admin'))
    <a role="button" href="{{route('user-list')}}" class="btn btn-lg btn-success ">Manage users</a><br><br>
@endif

</body>
</html>

<script type="text/javascript">

    window.onload = function() {
        sessionStorage.removeItem("first_name_register");
        sessionStorage.removeItem("surname_register");
        sessionStorage.removeItem("email_register");
    }
</script>
