<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Home'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'home'])

</body>
</html>

<script type="text/javascript">

    window.onload = function() {
        sessionStorage.removeItem("first_name_register");
        sessionStorage.removeItem("surname_register");
        sessionStorage.removeItem("email_register");
    }
</script>
