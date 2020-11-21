<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Users'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="color: #373737">Users</h2>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
        </div>
            <div class="col-auto">
                <a role="button" class="btn btn-success" href="{{ route('user.create') }}">Add</a>
            </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Role</th>
                <th></th>
            </tr>
            </thead>

            @include('layouts.search', ['searchType' => 'user'])

        </table>
    </div>
</div>

</body>
</html>


<script type="text/javascript">

    window.onload = function() {
        sessionStorage.removeItem("first_name");
        sessionStorage.removeItem("surname");
        sessionStorage.removeItem("email");
        sessionStorage.removeItem("emailConfirmation");
        sessionStorage.removeItem("inputRole");

        sessionStorage.removeItem("first_name_edit");
        sessionStorage.removeItem("surname_edit");
        sessionStorage.removeItem("email_edit");
        sessionStorage.removeItem("inputRole_edit");
    }

</script>

